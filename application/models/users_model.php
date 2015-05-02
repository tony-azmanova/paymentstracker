<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** 
* Users_model Class 
* 
* @package PaymentsTracker
* @subpackage Users_model
* @category Users
* @author Tony Azmanova <layela@abv.bg>
* @link http://tonyarticles.com
*/  
class Users_model extends CI_Model {
	
	protected $user_id;
	
	protected $id_profile;
	
	/**
	 * userId function -function that sets the curent users id in the session
	 */
	private function userId($user_id){
		$this->session->set_userdata('user_id',$user_id);
		$this->user_id = $user_id;
	}
	
	
	/**
	 * __construct function -function that loads the database and session library
	 *  also give the curent users profile information as checking the session userdata for the users id
	 * @return void
	 */
	public function __construct(){
        parent::__construct();
        
        $this->load->database();
        $this->load->library('session');
		$user_id =$this->session->userdata('user_id');
		if(!empty($user_id)){
			$this->userId($user_id);
		}
		$this->user_profile_id = $this->userProfileId($user_id);
    }
    
  
	/**
	 * getUserId function - check if the users id is empty
	 * @return integer|bool - if the user id is not empty returns this user id else returns bool 
	 */
	public function getUserId(){
		if(!empty($this->user_id)){
			return $this->user_id;
		}else{
			return false;
		}		
	}	
    
    
	/**
	 * userloggedIn function - check if the users id is in the curent session
	 * @return bool
	 */
	public function userloggedIn(){
		
		if(!empty($this->user_id)){
			return true;
		}else{
			return false;
		}	
	}
	
	/**
	 * usersLevel function - check if the level of the curent user is 0(admin)
	 * @return bool
	 */
	public function usersLevel(){
		
		$this->db->select('users.level,users.id as user_id');
		$this->db->from('users');
		$this->db->where('users.id',$this->user_id);
		$this->db->where('users.level',0);
		$result = $this->db->get()->row_array();
		$i = $this->db->affected_rows();
		if($i > 0 ){
			return true;
		}else{	
			return false;
		}
	}
	
	/**
	 * userStatus function - check if the status of the curent user is unactiv(1)
	 * @return bool
	 */
	public function userStatus(){
		$this->db->select('users.status');
		$this->db->from('users');
		$this->db->where('users.id',$this->user_id);
		$this->db->where('users.status',1);
		$result = $this->db->get()->row_array();
		$i = $this->db->affected_rows();
		if($i > 0 ){
			return true;
		}else{	
			return false;
		}

	}
	
	/**
	 * usersLogin function - check if the user is login
	 * @param string $username is the username from the input field in the login area
	 * @param string $password is the password from the input field in the login area
	 * @return integer|bool - if there is a user with $username and $password in the database we set 
	 * the user id in the session, else returns bool
	 */
	public function usersLogin($username,$password){
		
		$this->db->select('id');
		$this->db->from('users');
		$this->db->where('username',$username);
		$this->db->where('password',$password);
		$this->db->limit('1');
		$user_id = $this->db->get()->row_array();
		if(!empty($user_id)){
			$this->session->set_userdata('user_id',$user_id['id']);
			$this->userId($user_id['id']);
			return $this->user_id;
		}else{	
			return false;
		}
	}
	
	
	/**
	 * insertNewUser function - make the insert in to the database 
	 * as it gives the new user status 1(unactiv) and level 1(user)
	 * @return bool
	 */
	public function insertNewUser(){
		
		$this->db->trans_begin();
	
		$user_profile = array(
				'first_name'=>$this->input->post('first_name'),
				'last_name'=>$this->input->post('last_name'),
				'email'=>$this->input->post('email')
			);
		$this->db->insert('user_profile',$user_profile);
		
		$profile_id = $this->db->insert_id();
		$user = array(
				'username'=>$this->input->post('username'),
				'password'=>$this->input->post('password'),
				'profile_id'=>$profile_id,
				'level'=>'1',
				'status'=>'1'
			);
		$this->db->insert('users',$user);
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return true;
		}
	}
	
	
	/**
     * getAllUsers function - get all users for the pagination
	 * @param integer|null $page is null if it is not defined else is the number of 
	 * the current page of the pagination
	 * @param integer|null $limit is null if it is not defined else is the 
	 * limit of results shown on the page 
	 * @return array
	 */
	public function getAllUsers($page=null,$limit=null){
		
		$this->db->select('users.username,users.id as user_id,user_profile.first_name,
		user_profile.last_name,user_profile.email,users.status,
			SUM(incomes.total_income) as total_income,
				(CASE 
					WHEN total_income 
						IS NULL 
					THEN 
						"-"
					ELSE 
						total_income 
				END),
			(SELECT 
				SUM(items.item_price * items.quantity) as total_exspenses
					FROM items 
					JOIN invoices ON items.invoice_id = invoices.id
					WHERE users.id = invoices.created_by_id
					AND incomes.deleted = 0
			) as total_exspenses
		',FALSE);
		$this->db->from('users');
		$this->db->join('incomes',' users.id = incomes.income_user','left');
		$this->db->join('user_profile','users.profile_id = user_profile.id');
		$this->db->group_by('users.id');
		if(!empty($page)) {
			$start = ($page-1)*$limit;
			$this->db->limit($limit,$start);
		}
		$results = $this->db->get()->result_array();
		return $results;
	}
	
	/**
     * getAllUsers function - get all users 
	 * @return array
	 */
	public function allUsers(){
		$this->db->select('users.id as users_id,users.username');
		$result = $this->db->get('users')->result_array();
		return $result;
	}
	
	
	/**
     * countClientsList function - count the result for the pagination
     * @return integer
	 */
	public function countUsersList(){
		$this->db->select('COUNT(*) as count',FALSE);
		$result = $this->db->get('users')->row_array();
		return $result['count'];	
	}
	
	
	/**
     * userProfile function - gives the curent users profile information as checking the session userdata for the users id
	 * @return array
	 */
    public function userProfile(){
		if(!$this->userloggedIn()) {
			return false;
		}
		$this->db->select('users.username,users.id as user_id,user_profile.first_name,user_profile.last_name');
		$this->db->from('users');
		$this->db->join('user_profile','users.profile_id = user_profile.id');
		$this->db->where('users.id',$this->user_id);
		$results = $this->db->get()->row_array();
		return $results;
	}	
	
	
	/**
     * userInfo function - gives information about the selectet user
     * @param integer $user_id is the id of the selectet user
	 * @return array
	 */
	public function userInfo($user_id){
		
		if(!$user_id){
			die;
		}else{
			$this->db->select('users.username,users.password,user_profile.first_name,user_profile.email,
			user_profile.last_name,status_user.status_name,users.level,users.status,
			levels.level_name,status_user.id as status_id,levels.id as level_id');
			$this->db->from('user_profile');
			$this->db->join('users','user_profile.id = users.profile_id','left');
			$this->db->join('levels','users.level = levels.id','left');
			$this->db->join('status_user','users.status = status_user.id','left');
			$this->db->where('users.id',$user_id);
			$results = $this->db->get()->row_array();
			return $results;
		}
	}
	
	
	
	/**
     * getStatusUserse function - get all statuses
	 * @return array
	 */
	public function getStatusUsers(){
		$this->db->select('status_user.status_name,status_user.id as status_id');
		$this->db->from('status_user');
		$result = $this->db->get()->result_array();
		return $result;
	}
	
	
	/**
     * getLevelsUsers function - get all the levels 
	 * @return array
	 */
	public function getLevelsUsers(){
		$this->db->select('levels.level_name,levels.id as level_id');
		$this->db->from('levels');
		$result = $this->db->get()->result_array();
		return $result;
	}
	
	
	/**
     * usernameCheck function - check if there is another user that have the same username
     * @param string $username is the username from the input field in the users/edit
     * @param integer $user_id is the selected users id
	 * @return bool
	 */
	public function usernameCheck($username,$user_id){
		if(empty($username)){
			die;
		}
		$this->db->select('users.username');
		$this->db->from('users');
		$this->db->where('users.username',$username);
		$this->db->where_not_in('users.id',$user_id);
		$this->db->get()->result_array();
			
		$i = $this->db->affected_rows();
		if($i > 0 ){
			return true;
		}else{	
			return false;
		}
	}
	
	/**
     * emailCheck function - check if there is another user that have the same email
     * @param string $email is the email from the input field in the users/edit
     * @param integer $user_id is the selected users id
	 * @return bool
	 */
    public function emailCheck($email,$user_id){
		if(empty($email)){
			die;
		}
		$this->db->select('user_profile.email');
		$this->db->from('user_profile');
		$this->db->join('users','user_profile.id = users.id','left');
		$this->db->where('user_profile.email',$email);
		$this->db->where_not_in('users.id',$user_id);
		$this->db->get()->result_array();
			
		$i = $this->db->affected_rows();
		if($i > 0 ){
			return true;
		}else{	
			return false;
		}
	}
	
	
	/**
     * userProfileId function -gives information about the selectet user
     * @param integer $user_id is the id of the selectet user
	 * @return array
	 */
	public function userProfileId($user_id){
		$this->db->select('users.profile_id as profile_id');
		$this->db->from('users');
		$this->db->where('users.id',$user_id);
		$result = $this->db->get()->row_array();
		return $result;
	}
	
	/**
     * cahgeUser function - make the update in the database with the changes about the selectet user
     * @param integer $user_id is the id of the selectet user
     * @param array $user_info are the post values that are coming from users/edit
	 * @return bool
	 */
    public function cahgeUser($user_id,$users_info){
		
		$user_info = $this->Users_model->usersLevel();
		if($user_info){
			if(!$user_id){
				die;
			}
			$id_profile = $this->userProfileId($user_id);
			$this->db->trans_begin();
			
			$change = array (
				'username'=>$this->input->post('username'),
				'profile_id'=>$id_profile['profile_id'],
				'level'=>$this->input->post('level'),
				'status'=>$this->input->post('status')
			);
			$this->db->where('users.id',$user_id);
			$this->db->update('users',$change);
			
			$users_edit = array(
				'username'=>$users_info['username'],
				'password'=>$users_info['password'],
				'user_id'=>$user_id,
				'level'=>$users_info['level'],
				'status'=>$users_info['status'],
				'email'=>$users_info['email'],
				'first_name'=>$users_info['first_name'],
				'last_name'=>$users_info['last_name']
			);
			$this->db->insert('users_edit',$users_edit);
			
			$change_user_profile = array(
				'first_name'=>$this->input->post('first_name'),
				'last_name'=>$this->input->post('last_name'),
				'email'=>$this->input->post('email')
				);
			$this->db->where('user_profile.id',$id_profile['profile_id']);
			$this->db->update('user_profile',$change_user_profile);
			
			if($this->db->trans_status() !== FALSE){
				$this->db->trans_commit();
				return true;
			}else{
				$this->db->trans_rollback();
				return false;
			}
		}
	}
    
}

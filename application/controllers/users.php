<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** 
* Users Class 
* 
* @package PaymentsTracker
* @subpackage Users 
* @category Users
* @author Tony Azmanova <layela@abv.bg>
* @link http://tonyarticles.com
*/ 
class Users extends MY_Controller {
	
	
	/**
	 * __construct function -loads the Statistics_model 
	 * @return void
	 */
	public function __construct(){
        parent::__construct();
       
        $this->load->model('Statistics_model');
		$this->output->enable_profiler(FALSE);
    }
    
    
	/**
	 * index function - the index function for the Users controller 
	 * where if the user_id is not empty it is save in the session
	 * @param integer $page number of page to begin 
	 * @return void|string if the curent user level is admin returns void else string with error 
	 */
	public function index($page=1){
		if(!empty($this->user_id)){
			$data['username'] = $data_session['username'];
		}
		if($this->Users_model->userloggedIn() ){
			$user_info = $this->Users_model->usersLevel();
			if($user_info){
				echo "Admin arеa!";
			}else{	
				echo "You can't accses this page unles you are the admin";
			}
		}	
		$users_result = $this->Users_model->countUsersList();
		$this->load->library("pagination");
		$config = array();
		$config["base_url"] = base_url('users/page/');
		$config["total_rows"] = $users_result;
		$config["per_page"] = 2;
		$config["uri_segment"] = 3;
		$config['use_page_numbers'] = TRUE;
		$this->pagination->initialize($config);

		$data['links']= $this->pagination->create_links();
		$all_users = $this->Users_model->getAllUsers($page,$config['per_page']);
		$data['all_users'] = $all_users;
		$this->loadView('users/list',$data);
	}
	 
	
	/**
	 * log_in function - check the username and password for the login 
	 * @return string if there is error
	 */
	public function log_in(){
		if($this->input->server('REQUEST_METHOD') =='POST'){
			$username= $this->input->post('username');
			$password= $this->input->post('password');
			$login = $this->Users_model->usersLogin($username,$password);
			if($login){
				redirect('invoices/index');
			}else{
				echo "Wrong username or password!";
			}
		}
	}
	
	
	/**
	 * registerUser function - registration of new user  
	 * @return void|string if it is succsesful returns void else string with error 
	 */
	public function registerUser(){
		
		if($this->Users_model->userloggedIn() ){
			redirect('invoices/index');
		}else{	
			$this->load->library('form_validation');
			$this->load->helper('form');
			$this->form_validation->set_rules('username', 'Username', 'required|alpha|is_unique[users.username]|xss_clean');
			$this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|xss_clean');
			$this->form_validation->set_rules('re_pass_input', 'Repeat Password', 'required|matches[password]|min_length[6]|xss_clean');
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[user_profile.email]|xss_clean');
			$this->form_validation->set_rules('first_name', 'First name', 'required|xss_clean');
			$this->form_validation->set_rules('last_name', 'Last name', 'required|xss_clean');

			if($this->form_validation->run() !== FALSE){
				$new_user = $this->Users_model->insertNewUser();
				if($new_user){
					$data['succsesfully'] = "Yey";
					redirect('invoices/index');
				}else{
					echo "Error!!";
				}		
			}else{
				$this->load->view('users/register');
			}
		}
	}
	
	
	/**
	 * allUsers function - get all users 
	 * @return void|string if the curent user level is admin returns void else string with error 
	 */
	public function allUsers(){
		if($this->Users_model->userloggedIn() ){
			$user_info = $this->Users_model->usersLevel();
			if($user_info){
				echo "Admin arеa!";
			}else{	
				echo "You can't accses this page unles you are the admin";
				die;
			}
		}	
		$all_users = $this->Users_model->getAllUers();
		$data['all_users'] = $all_users;
		$this->loadView('users/list',$data);
	}
	
	
	/**
	 * changeProfile- changing the profile of the user
	 * @return void|string if the curent user level is admin returns void else string with error 
	 */
	public function changeProfile(){
		$user_id = $this->uri->segment(3);
		if($user_id){	
			$this->load->helper('form');
			$this->load->library('form_validation');
			$data['status'] = $this->Users_model->getStatusUsers();
			$data['levels'] = $this->Users_model->getLevelsUsers();
			$users_info = $this->Users_model->userInfo($user_id);
			$data['users_info'] = $users_info;
			$data['user_id'] = $user_id;
			$user_profile = $this->Users_model->userProfile();
			if($this->input->server('REQUEST_METHOD') =='POST'){
				$this->setRulesForUser();
				if($this->form_validation->run() !== FALSE){
					$edit_user = $this->Users_model->cahgeUser($user_id,$users_info);
					
					if($edit_user){
						$data['success'] = "Yey";
					}else{
						echo "Error!";	
					}
				}
			}
			$this->loadView('users/edit',$data);
		}
	}
	
	
	/**
	 * check_username- callback function that check if the username is avaliable
	 * @return bool
	 */
	public function check_username(){
		$user_id = $this->uri->segment(3);
		$username = $this->input->post('username');
		$check = $this->Users_model->usernameCheck($username,$user_id);
		if($check){
			$this->form_validation->set_message('check_username','This username alredy exists!');
			return FALSE;
		}else{
			return TRUE;
		}
	}
	
	
	/**
	 * check_email- callback function that check if the email is avaliable
	 * @return bool
	 */
	public function check_email(){
		$user_id = $this->uri->segment(3);
		$email = $this->input->post('email');
		$check_email = $this->Users_model->emailCheck($email,$user_id);
		if($check_email){
			$this->form_validation->set_message('check_email','This email alredy exists!');
			return FALSE;
		}else{
			return TRUE;
		}
	}
	
	
	/**
	 * setRulesForUser function - sets the form_validation rules 
	 * that are used in changeProfile function
	 * @return string|void if there is error else returns void
	 */
	public function setRulesForUser(){
		
		$user_info = $this->Users_model->usersLevel();
		$user_profile = $this->Users_model->userProfile();
		if($user_info){
			$this->form_validation->set_rules('username', 'Username','callback_check_username|alphanumeric|xss_clean');	
			$this->form_validation->set_rules('status', 'Status', 'required|numeric|xss_clean');
			$this->form_validation->set_rules('level', 'Level', 'required|numeric|xss_clean');
		}else{
			echo 'You can not edit this fields!';
		}
		if(($user_profile ) && $user_info){
			$this->form_validation->set_rules('email', 'Email', 'required|callback_check_email|valid_email|xss_clean');
			$this->form_validation->set_rules('first_name', 'First name', 'required|alpha|xss_clean');
			$this->form_validation->set_rules('last_name', 'Last name', 'required|alpha|xss_clean');	
		}else{
			echo "You can edit only your own profile!";
		}		
	}
	
	
	/**
	 * usersProfile function - gets all the information about the selected user
	 * @return void
	 */
	public function usersProfile(){
		if($this->Users_model->userloggedIn() ){
			$user_id = $this->uri->segment(3);
			if($user_id){
				$start_date =  date('Y-m-01');
				$end_date = date('Y-m-t'); 
				$users_info = $this->Users_model->userInfo($user_id);
				$statistics = $this->Statistics_model->getWholeStat($start_date,$end_date,$user_id);
				$top_items = $this->Statistics_model->getExpByItem($limit=10,$start_date,$end_date,$user_id);
				$top_shops = $this->Statistics_model->topExpByShop($limit=10,$start_date,$end_date,$user_id);
				$top_expenses = $this->Statistics_model->getTopExpenses($limit=10,$start_date,$end_date,$user_id);
				$top_incomes = $this->Statistics_model->getTopIncomes($limit=10,$start_date,$end_date,$user_id);
				$data['incomes'] = $statistics['total_incomes'];
				$data['expenses'] = $statistics['total_exspenses'];
	
				$data['top_expenses'] = $top_expenses;
				$data['top_incomes'] = $top_incomes;
				$data['top_shops'] = $top_shops;
				$data['users_info'] = $users_info;
				$data['top_items'] = $top_items;
				$data['user_id'] = $user_id;
				$this->loadView('users/profile',$data);
			}
		}
	}
	
	
	/**
	 * logOut function - destroyes the session of the user so that he can log out
	 * @return void
	 */
	public function logOut(){
		$this->session->sess_destroy();
		redirect('invoices/index');
	}	
	
}

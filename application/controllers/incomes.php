<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** 
* Incomes Class 
* 
* @package PaymentsTracker
* @subpackage Incomes 
* @category Incomes
* @author Tony Azmanova <layela@abv.bg>
* @link http://tonyarticles.com
*/ 
class Incomes extends MY_Controller {
	
	/**
	 * __construct function - loads the Incomes_model and Clients_model
	 * @return sring if the user is with status unactiv 
	 */
	public function __construct(){
        parent::__construct();
        $this->load->model('Incomes_model');
        $this->load->model('Clients_model');
        $user_stat = $this->Users_model->userStatus();
		if($user_stat){
			echo "You have to wait the admin to change your status to 'activ'!";
			die;
		}
        $this->output->enable_profiler(FALSE);  
    }
    
	/**
	 * index function - the index function for the Incomes controller 
	 * @param integer $page number of page to begin 
	 * @return void
	 */
    public function index($page=1){
		if(!$this->Users_model->userloggedIn() ){
			redirect('invoices/index');
			die;
		}
		$income_result = $this->Incomes_model->countIncomesList();
		$this->load->library("pagination");
		$config = array();
		$config["base_url"] = base_url('incomes/page/');
		$config["total_rows"] = $income_result;
		$config["per_page"] = 5;
		$config["uri_segment"] = 3;
		$config['use_page_numbers'] = TRUE;
		$this->pagination->initialize($config);
		
		$data['links']= $this->pagination->create_links();
		$data['income_list'] = $this->Incomes_model->getIncomes($page,$config['per_page']);	
		$this->loadView('incomes/list',$data);
		
	}
	
    
	/**
	 * incomeInfo function - get the information about the selected incomes
	 * @return void
	 */
    public function incomeInfo(){
		$income_id =  $this->uri->segment(3);
		if(!$this->Users_model->userloggedIn() ){
			redirect('incomes/index');
			die;
		}	
		$data['income_id'] = $income_id;
		$data['incomes_info'] = $this->Incomes_model->getInfoIncomes($income_id);
		$this->loadView('incomes/show',$data);
	
	}
	
	
	/**
	 * newIncome function - add new income
	 * @return void
	 */
	public function newIncome(){
		if(!$this->Users_model->userloggedIn() ){
			redirect('incomes/index');
			die;
		}
		$this->load->helper('form');
		$this->load->library('form_validation');
		$all_users = $this->Users_model->allUsers();
		$user_info = $this->Users_model->usersLevel();
		if($user_info ){
			$users = $this->Users_model->allUsers();
			$set_user = array();
			$set_user = $user_info;
		}else{
			$this_user = $this->Users_model->userProfile();
			$set_user = $this_user['user_id'];
			
		}
		$incomes = $this-> Incomes_model->getIncomes();
		$clients = $this->Clients_model->getClients();
		$set_date = date('Y-m-d');
		$data['set_date'] = $set_date;
		$data['all_users'] = $all_users;
		$data['set_user'] = $set_user;
		$data['incomes']= $incomes;
		$data['clients']= $clients;
		$data['categories'] =  $this->Incomes_model->getIncomesCategories();	
		if($this->input->server('REQUEST_METHOD') =='POST'){
			$this->setRulesForIncomes();
			if ($this->form_validation->run() !== FALSE) {
				$new_income = $this->Incomes_model->insertNewIncomes();
				if($new_income ){
					$data['success'] = "Yey";
				}else{
					echo "Error in database!";	
				}
			}
		}  
		$this->loadView('incomes/new',$data);
	}
	
	
	/**
	 * editIncome function - edit the alredy existing incomes 
	 * @return void|string returns void or if is not user with level admin 
	 */
	public function editIncome(){
		$income_id =  $this->uri->segment(3);
		if(!$this->Users_model->userloggedIn() ){
			redirect('incomes/index');
			die;
		}
		$user_info = $this->Users_model->usersLevel();
		if($user_info ){
			$this->load->helper('form');
			$this->load->library('form_validation');
			$all_users = $this->Users_model->getAllUsers();
			$incomes_info = $this->Incomes_model->getInfoIncomes($income_id);
			$data['incomes_info'] = $incomes_info;
			$data['all_users'] = $all_users;
			$clients = $this->Clients_model->getClients();
			if(!empty($incomes_info['date_incomes'])){
				$set_date = date("Y-m-d", strtotime($incomes_info['date_incomes']));
			}else{
				$set_date = date('Y-m-d');
			}
			$data['set_date'] = $set_date;
			$data['income_id'] = $income_id;
			$data['clients']= $clients;
			$data['categories'] =  $this->Incomes_model->getIncomesCategories();	
			if($this->input->server('REQUEST_METHOD') =='POST'){
				$this->setRulesForIncomes();
				if ($this->form_validation->run() !== FALSE) {
					$update_income = $this->Incomes_model->updateIncomes($income_id);
					if($update_income){
						$data['success'] = "Yey";
					}else{
						echo "Error in database!";	
					}
				}
			}  
			$this->loadView('incomes/edit',$data);
		}else{
			echo "You can't edit incomes, unles you are the admin!";
		}	
	}
	
	
	/**
	 * deleteIncome function - deletes the alredy existing incomes
	 * @return void|string returns void else sting if it is not user with level admin 
	 */
	public function deleteIncome(){
		$user_info = $this->Users_model->usersLevel();
		if($user_info){ 
			$income_id =  $this->uri->segment(3);
			$deleted_income = $this->Incomes_model->removeIncomes($income_id);
			if($deleted_income){
				redirect("incomes/index");
			}
		}else{
			echo "You can't delete income, unles you are the admin!";
		} 			
	}
	
	
	/**
	 * setRulesForIncomes function - sets the form_validation rules 
	 * that are used in newIncome and editIncome functions
	 * @return void
	 */
    public function setRulesForIncomes(){
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('income_date', 'Income date', 'required|xss_clean');
		$this->form_validation->set_rules('income_name', 'Income name', 'required|xss_clean');
		$this->form_validation->set_rules('income_category', 'Category', 'required|numeric');
		$this->form_validation->set_rules('clients', 'Clients/company', 'required|xss_clean');
		$this->form_validation->set_rules('total_income', 'Total income', 'required|numeric|xss_clean');
		$user_info = $this->Users_model->usersLevel();
		if(!$user_info ){
			$this->form_validation->set_rules('income_user', 'User', 'required|callback_username_check|xss_clean');
		}else{
			$this->form_validation->set_rules('income_user', 'User', 'required|xss_clean');
		}
	}
	
	
	/**
	 * username_check function - check if it is the same user that is editing the incomes 
	 * @return void|string returns void or if it is not user with level admin 
	 */
	public function username_check(){
		$user_info = $this->Users_model->usersLevel();
		$user_set =	$this->input->post('income_user');
		if(!$user_info ){
			$this_user = $this->Users_model->userProfile();
			$user_id = $this->Users_model->getUserId();
			if($user_set !== $user_id){
				$this->form_validation->set_message('username_check','You can not add incomes for another user!');
				return FALSE;
			}else{
				return TRUE;
			}
		}
	}
	
}    

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/** 
* Clients Class 
* 
* @package PaymentsTracker
* @subpackage Clients 
* @category Clients
* @author Tony Azmanova <layela@abv.bg>
* @link http://tonyarticles.com
*/ 
class Clients extends MY_Controller {
	
	/**
	 * __construct function - loads the Clients_model 
	 * @param array $user_stat check if the user is with activ status
	 * @return sring if the user is with status unactiv 
	 */
	public function __construct(){
        parent::__construct();
        $this->load->model('Clients_model');
        $user_stat = $this->Users_model->userStatus();
		if($user_stat){
			echo "You have to wait the admin to change your status to 'activ'!";
			die;
		}	
        $this->output->enable_profiler(FALSE);  
	}
    
   
	/**
	 * index function - the index function for the Clients controller 
	 * @param integer $page number of page to begin 
	 * @return void
	 */
	public function index($page=1){
		if(!$this->Users_model->userloggedIn() ){
			redirect('invoices/index');
			die;
		}
		$clients_result = $this->Clients_model->countClientsList();
		$this->load->library("pagination");
		$config = array();
		$config["base_url"] = base_url('clients/page/');
		$config["total_rows"] = $clients_result;
		$config["per_page"] = 5;
		$config["uri_segment"] = 3;
		$config['use_page_numbers'] = TRUE;
		$this->pagination->initialize($config);
		
		$data['links']= $this->pagination->create_links();
		$clients = $this->Clients_model->getClients($page,$config['per_page']);
		$data['clients'] = $clients;
		$this->loadView('clients/list',$data);
	}
	
	
	/**
	 * newClients function - add a new client or company 
	 * @return void
	 */
	public function newClients(){
		if(!$this->Users_model->userloggedIn() ){
			redirect('clients/index');
			die;
		}
		$data['clients'] = $this->Clients_model->getClients();
		$this->load->helper('form');
		$this->load->library('form_validation');
		if($this->input->server('REQUEST_METHOD') =='POST'){
			$this->setRulesForClients();
			if ($this->form_validation->run() !== FALSE) {
				$new_client = $this->Clients_model->insertNewClient();
				if($new_client){
					$data['success'] = "Yey";
					redirect("clients/editClients/".$new_client);
				}else{
					echo "Error in database!";	
				}
			}
		} 
		$this->loadView('clients/new',$data);
	}
	
	  
	/**
	 * clientInfo function - get the information about the selected client or company
	 * @return void 
	 */ 
	public function clientInfo(){
		$client_id =  $this->uri->segment(3);
		if(!$this->Users_model->userloggedIn() ){
			redirect('incomes/index');
			die;
		}
		$data['client_id'] = $client_id;
		$client_info = $this->Clients_model->getClientInfo($client_id);
		$data['client_info'] = $client_info;
		$this->loadView('clients/show',$data);
	}
	
	
	/**
	 * editClients function - editing the alredy existing client or company 
	 * @return void|string returns void or if is not user with level admin 
	 */
	public function editClients(){
		$client_id =  $this->uri->segment(3);
		if(!$this->Users_model->userloggedIn()){
			redirect('clients/index');
			die;
		}
		$user_info = $this->Users_model->usersLevel();
		if($user_info ){
			$data['client_id'] = $client_id;
			$client_info = $this->Clients_model->getClientInfo($client_id);
			$data['client_info'] = $client_info;
			
			$this->load->helper('form');
			$this->load->library('form_validation');
			if($this->input->server('REQUEST_METHOD') =='POST'){
				$this->setRulesForClients();
				if ($this->form_validation->run() !== FALSE) {
					$update_client = $this->Clients_model->updateClient($client_id);
					if($update_client){
						redirect('clients/index');
					}else{
						echo "Error in database!";	
					}
				}
			} 
			$this->loadView('clients/edit',$data);
		}else{
			echo "You can't edit client, unles you are the admin!";
		}	
	}
	
	
	/**
	 * deleteClient function - deletes the alredy existing client or company 
	 * @return void|string returns void or if is not user with level admin 
	 */
	public function deleteClient(){
		$user_info = $this->Users_model->usersLevel();
		
		if($user_info ){
			$client_id =  $this->uri->segment(3);
			$deleted_client = $this->Clients_model->removeClients($client_id);
			if($deleted_client){
				
				redirect('clients/index');
				
			}
		}else{
			echo "You can't delete client, unles you are the admin!";
		} 			
	}
	
	
	/**
	 * setRulesForClients function - sets the form_validation rules 
	 * that are used in newClients and editClients functions
	 * @return void
	 */
	public function setRulesForClients(){
		$this->load->library('form_validation');
		
		$company_name = $this->input->post('company_name');
		$client_first_name = $this->input->post('client_first_name');
		$client_last_name = $this->input->post('client_last_name');
		if(!empty($company_name)){
			$this->form_validation->set_rules('company_name', 'Company name', 'alphanumeric|xss_clean');
		}
		if(!empty($client_first_name) || !empty($client_last_name)){
			$this->form_validation->set_rules('client_first_name', 'Client first name', 'alpha|xss_clean');
			$this->form_validation->set_rules('client_last_name', 'Client last name', 'alpha|xss_clean');
		}	
		$this->form_validation->set_rules('client_phone', 'Client phone', 'required|numeric|xss_clean');
		$this->form_validation->set_rules('client_email', 'Client email', 'required|valid_email|xss_clean');
	}
}

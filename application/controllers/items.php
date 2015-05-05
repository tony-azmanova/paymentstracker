<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** 
* Items Class 
* 
* @package PaymentsTracker
* @subpackage Items 
* @category Items
* @author Tony Azmanova <layela@abv.bg>
* @link http://tonyarticles.com
*/  
class Items extends MY_Controller  {
	
	/**
	 * __construct function - loads the Items_model and Invoices_model
	 * @return sring if the user is with status unactiv 
	 */
	public function __construct(){
        parent::__construct();
        $this->load->model('Items_model');
        $this->load->model('Invoices_model');
        $user_stat = $this->Users_model->userStatus();
		if($user_stat){
			echo "You have to wait the admin to change your status to 'activ'!";
			die;
		}	
        $this->output->enable_profiler(FALSE);
    }
    
    
	/**
	 * index function - the index function for the Items controller 
	 * @param integer $page number of page to begin 
	 */
	public function index($page=1){
		if(!$this->Users_model->userloggedIn() ){
			redirect('invoices/index');
			die;
		}
		$items_result = $this->Items_model->countItemsList();
		$this->load->library("pagination");
		$config = array();
		$config["base_url"] = base_url('items/page/');
		$config["total_rows"] = $items_result;
		$config["per_page"] = 5;
		$config["uri_segment"] = 3;
		$config['use_page_numbers'] = TRUE;
		$this->pagination->initialize($config);
		
		$data['links']= $this->pagination->create_links();
		$data['items'] = $this->Items_model->getItems($page,$config['per_page']);
		$this->loadView('items/list',$data);
	}
	
	/**
	 * newItems function - add new items type
	 * @return void|string returns void else if there is error returns string
	 */
	public function newItems(){
		
		if(!$this->Users_model->userloggedIn() ){
			redirect('invoices/index');
			die;
		}else{
			$this->load->helper('form');
			$this->load->library('form_validation');
			$data['items'] = $this->Items_model->getItems();
			$data['categories'] = $this->Invoices_model->getCategory();
			
			if($this->input->server('REQUEST_METHOD') =='POST'){
				$this->form_validation->set_rules('product_type', 'Type', 'required|min_length[3]|alpha');
				$this->form_validation->set_rules('category', 'Category', 'required|numeric');
				if ($this->form_validation->run() !== FALSE) {
					$new_product = $this->Items_model->insertNewItem();
					if($new_product){
						$data['success'] = "Yey";
					}else{
						echo "Error!";	
					}
				}
			}		
			$this->loadView('items/type',$data);	
		}
	}
	
	/**
	 * deleteItemType function - delete the alredy existing items type 
	 * @return void|string returns void else if is not user with level admin
	 */
	public function deleteItemType(){
		$user_info = $this->Users_model->usersLevel();
		if($user_info){ 
			$type_id =  $this->uri->segment(3);
			$deleted_item_type = $this->Items_model->removeItemType($type_id);
			if($deleted_item_type){
				redirect("items/index");
			}
		}else{
			echo "You can't delete invoice unles you are the admin!";
		} 		
	}
	
	
	/**
	 * editItems function - edit the alredy existing items type 
	 * @returnvoid|string returns void else if is not user with level admin 
	 */
	public function editItems(){
		if(!$this->Users_model->userloggedIn() ){
			redirect('items/index');
			die;
		}
		$user_info = $this->Users_model->usersLevel();
		if($user_info){	
			$type_id =  $this->uri->segment(3);
			$this->load->helper('form');
			$this->load->library('form_validation');
			$data['items_info'] = $this->Items_model->itemsInfo($type_id);
			$data['items'] = $this->Items_model->getItems();
			$data['categories'] = $this->Invoices_model->getCategory();
			$data['type_id'] = $type_id;			
			if($this->input->server('REQUEST_METHOD') =='POST'){
				$this->form_validation->set_rules('product_type', 'Type', 'required|min_length[3]|alpha');
					$this->form_validation->set_rules('category', 'Category', 'required|numeric');
				if ($this->form_validation->run() !== FALSE) {
					$updated_item_type = $this->Items_model->updateItemType($type_id);
					if($updated_item_type == TRUE){
						$data['success'] = "yey";
					}else{
						echo "Error!";	
					}
				}
			}  
			$this->loadView('items/edit',$data);
		}else{
			echo "You can't edit items unles you are the admin!";
		}	
	}
    
}    

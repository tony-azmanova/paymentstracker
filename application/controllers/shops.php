<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** 
* Shops Class 
* 
* @package PaymentsTracker
* @subpackage Shops
* @category Shops
* @author Tony Azmanova <layela@abv.bg>
* @link http://tonyarticles.com
*/ 
class Shops extends MY_Controller  {
	
	/**
	 * __construct function - loads the Shops_model and Invoices_model
	 * @return sring if the user is with status unactiv 
	 */
	public function __construct(){
        parent::__construct();
        $this->load->model('Shops_model');
        $this->load->model('Invoices_model');
        $user_stat = $this->Users_model->userStatus();
		if($user_stat){
			echo "You have to wait the admin to change your status to 'activ'!";
			die;
		}	
        $this->output->enable_profiler(TRUE);
    }
    
    
	/**
	 * index function - the index function for the Shops controller 
	 * @param integer $page number of page to begin 
	 */
	public function index($page=1){
		if(!$this->Users_model->userloggedIn() ){
			redirect('invoices/index');
			die;
		}
		$shops_result = $this->Shops_model->countShopsList();
		$this->load->library("pagination");
		$config = array();
		$config["base_url"] = base_url('shops/page/');
		$config["total_rows"] = $shops_result;
		$config["per_page"] = 5;
		$config["uri_segment"] = 3;
		$config['use_page_numbers'] = TRUE;
		
		$this->pagination->initialize($config);
		$data['links']= $this->pagination->create_links();
		$data['shops'] =  $this->Shops_model->getShops($page,$config['per_page']);
		$this->loadView('shops/list',$data);
	}

	/**
	 * newShop function - add new shop
	 * @return void|string returns void else if there is error returns string
	 */
	public function newShop(){
		$this->load->helper('form');
		$this->load->library('form_validation');
		$data['categories'] = $this->Invoices_model->getCategory();
		$data['cities'] = $this->Invoices_model->getCity();
		
		if($this->input->server('REQUEST_METHOD') =='POST'){
			$this->setRulesForShops();
			if ($this->form_validation->run() !== FALSE) {
				$new_shop = $this->Shops_model->insertNewShop();
				if($new_shop){
					redirect("shops/index");
				}else{
					echo "Error in database!";	
				}
			}
		}	
		$this->loadView('shops/new',$data);
	}
	
	
	/**
	 * deleteShop function - delete the alredy existing shop
	 * @return void|string returns void else if is not user with level admin 
	 */	
	public function deleteShop(){
		$user_info = $this->Users_model->usersLevel();
		if($user_info){ 
			$shop_id =  $this->uri->segment(3);
			$deleted_shop = $this->Shops_model->removeShop($shop_id);
			if($deleted_shop){
				redirect("shops/index");
			}
		}else{
			echo "You can't delete shop, unles you are the admin!";
		} 		
	}
	
	
	/**
	 * editShop function - edit the alredy existing shop 
	 * @return void|string returns void else if is not user with level admin 
	 *
	 */
	public function editShop(){
		if(!$this->Users_model->userloggedIn() ){
			redirect('items/index');
			die;
		}
		$user_info = $this->Users_model->usersLevel();
		if($user_info){	
			$this->load->helper(array('form', 'url'));
			$this->load->library('form_validation');
			$shop_id =  $this->uri->segment(3);
			$data['shop_id'] = $shop_id;
			$data['categories'] = $this->Invoices_model->getCategory();
			$data['cities'] = $this->Invoices_model->getCity();
			$data['shop_info'] = $this->Shops_model->getForEditShops($shop_id);
			
			if($this->input->server('REQUEST_METHOD') =='POST'){
				$this->setRulesForShops();
				if ($this->form_validation->run() !== FALSE) {
					$edit_shop = $this->Shops_model->updateShop($shop_id);
					if($edit_shop == TRUE){
						$data['success'] = "YeeeeeehoOoo";
					}else{
						echo "Error in database!";	
					}
				}
			}  
			$this->loadView('shops/edit',$data);
		}else{
			echo "You can't edit shop, unles you are the admin!";
		}
	}  
	
	
	/**
	 * shopInfo function - get the information about the selected shop
	 * @return void
	 */
	public function shopInfo(){
		$shop_id =  $this->uri->segment(3);
		if(!$this->Users_model->userloggedIn() ){
			redirect('shops/index');
			die;
		}	
		$data['shop_id'] = $shop_id;	
		$data['shop_info'] = $this->Shops_model->getForEditShops($shop_id);
		$this->loadView('shops/show',$data);
	}
	
	/**
	 * setRulesForShops function - sets the form_validation rules 
	 * that are used in newShop and editShop functions
	 */
	public function setRulesForShops(){
		$this->form_validation->set_rules('shop_name', 'Name', 'required');
		$this->form_validation->set_rules('shop_addres', 'Addres', 'required');
		$this->form_validation->set_rules('shop_phone', 'Phone', 'required|numeric');
		$this->form_validation->set_rules('city', 'City', 'required|numeric');
		$this->form_validation->set_rules('category', 'Category', 'required|numeric');
	}
}

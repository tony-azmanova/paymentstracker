<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** 
* Invoices Class 
* 
* @package PaymentsTracker
* @subpackage Invoices 
* @category Invoices
* @author Tony Azmanova <layela@abv.bg>
* @link http://tonyarticles.com
*/ 
class Invoices extends MY_Controller {
	
	/**
	 * __construct function - loads the Invoices_model, Items_model and Incomes_model
	 * @return sring if the user is with status unactiv 
	 */
	public function __construct(){
		
        parent::__construct();
        $this->load->model('Invoices_model');
        $this->load->model('Items_model');
        $this->load->model('Incomes_model');
        $this->output->enable_profiler(TRUE);
       
    }
    
    /**
	 * index function - the index function for the Invoices controller 
	 * @param integer $page number of page to begin 
	 * @return void
	 */
	public function index($page=1){
		
		$user_profile = $this->Users_model->userProfile();
		$invoice_result = $this->Invoices_model->countInvoicesList();
		$this->load->library("pagination");
		$config = array();
		$config["base_url"] =base_url('invoices/page/');
		$config["total_rows"] = $invoice_result;
		$config["per_page"] = 11;
		$config["uri_segment"] = 3;
		$config['use_page_numbers'] = TRUE;
		$this->pagination->initialize($config);
		
		$start =  date('Y-m-01');
		$end = date('Y-m-t'); 
		$data['start_date_more_previos'] = date('Y-m-d', strtotime("first day of -2 month"));
		$data['end_date_more_previos'] = date('Y-m-d', strtotime("last day of -2 month"));
		$data['start_date_privios'] = date('Y-m-d', strtotime("first day of -1 month"));
		$data['end_date_privios'] = date('Y-m-d', strtotime("last day of -1 month")); 
		$data['start_date_this'] = $start;
		$data['end_date_this'] = $end;
		$data['invoice'] = $this->Invoices_model->getAllInvoice( date('Y-m-01'),$end);
		$data['incomes'] = $this->Incomes_model->getAllIncomes($start,$end);
		$data['links']= $this->pagination->create_links();
		$data['invoce_list'] = $this->Invoices_model->getAllInvoicesList($page,$config['per_page']);
		$this->loadView('invoices/list',$data);
	} 

	/**
	 * newInvoice function - add new invoice
	 * @return void|string returns void else if there is error returns string
	 */
	public function newInvoice(){

		if(!$this->Users_model->userloggedIn() ){
			redirect('invoices/index');
			die;
		}
		$this->load->helper('form');
		$data['categories'] = $this->Invoices_model->getCategory();
		$data['types'] = $this->Invoices_model->getType();
		$data['shops'] = $this->Invoices_model->getShop();
		$data['items'] = $this->Items_model->getItems();
		$data['statuses'] = $this->Invoices_model->getStatus();

		$data['action'] = __FUNCTION__;	
		$invoice_items = array();
		$data['invoice_info'] = null;
		$data['invoice_id'] = null;
		$data['invoice_items'] = null;
		if(!empty($invoice_info['invoice_date'])){
			$set_date = date("Y-m-d", strtotime($invoice_info['date_invoices']));
		}else{
			$set_date = date('Y-m-d');
		}
		$data['set_date'] = $set_date;
		if($this->input->server('REQUEST_METHOD') =='POST'){
			$invoice_items = $this->setRulesForInvoice ();
			$data['invoice_items'] = $invoice_items;
		
			if ($this->form_validation->run() !== FALSE) {
				$new_invoice = $this->Invoices_model->insertNewInvoice($invoice_items);
				if(!empty($new_invoice)){
					$data['success'] ="yey";
					redirect("invoices/editInvoice/".$new_invoice);
				}else{
					echo "error";
				}	
			} else {
				$data['errors'] = TRUE;	
			}	
		}	
		$data['js_header'] = array('invoices/invoice.js');
		$views = array('invoices/new','invoices/js_new_item');
		$this->loadView($views,$data);
		
	}
	
	/**
	 * getCharts function - the index function for the Invoices controller 
	 * @param string $start start date for the chart
	 * @param string $end end date for the chart
	 * @return string 
	 */
	public function getCharts($start,$end){
		
		$this->output->enable_profiler(FALSE);
		
		$invoices = $this->Invoices_model->getAllInvoice($start,$end);
		$invoices_total = $invoices['this_month'];
		$incomes = $this->Incomes_model->getAllIncomes($start,$end);
		$income_total = $incomes['income_total'];
		
		echo "From ".date('d.m.Y', strtotime($start)). " to ".date('d.m.Y', strtotime($end))."
		the incomes are ".$income_total." and expenses are ".$invoices_total;
		
	}
	
	/**
	 * invoiceInfo function - get the information about the selected invoice
	 * @return void
	 */
	public function invoiceInfo(){
		$invoice_id =  $this->uri->segment(3);
		if(!$this->Users_model->userloggedIn() ){
			redirect('invoices/index');
			die;
		}
			
		$data['items_info'] = $this->Items_model->itemInfo($invoice_id);
		$data['total'] = $this->Invoices_model->totalInvoice($invoice_id);	
		$data['invoice_info'] = $this->Invoices_model->getInvoiceInfo($invoice_id);
		$this->loadView('invoices/show',$data);
	}
	
	
	/**
	 * deleteInvoice function - delete the alredy existing invoice 
	 * @return void|string returns void else if is not user with level admin 
	 */
	public function deleteInvoice(){
		$user_info = $this->Users_model->usersLevel();
		if($user_info){ 
			$invoice_id =  $this->uri->segment(3);
			$deleted_invoice = $this->Invoices_model->removeInvoice($invoice_id);
			if($deleted_invoice){
				redirect('invoices/index');
			}
		}else{
			echo "You can't delete invoice unles you are the admin!";
		} 			
	} 
	
	/**
	 * editInvoice function - edit the alredy existing invoice 
	 * @return void|string returns void else if is not user with level admin 
	 */
	public function editInvoice(){
		if(!$this->Users_model->userloggedIn() ){
			redirect('invoices/index');
			die;
		}
		$user_info = $this->Users_model->usersLevel();
		if($user_info){ 	
			$this->load->helper('form');
			$invoice_id =  $this->uri->segment(3);
			$data['categories'] = $this->Invoices_model->getCategory();
			$data['types'] =  $this->Invoices_model->getType();
			$data['shops'] = $this->Invoices_model->getShop();
			$data['items'] = $this->Items_model->getItems();
			$data['statuses'] = $this->Invoices_model->getStatus();
			$data['action'] = __FUNCTION__;	
			$invoice_items = array();
			if($invoice_id) {
				$invoice_info = $this->Invoices_model->getInvoiceInfo($invoice_id);
				if(!empty($invoice_info['date_invoices'])){
					$set_date = date("Y-m-d", strtotime($invoice_info['date_invoices']));
				}else{
					$set_date = date('Y-m-d');
				}
				$data['set_date'] = $set_date;
				$data['invoice_id'] = $invoice_id;
				$invoice_items = $this->Items_model->itemInfo($invoice_id);
				$data['invoice_items'] = $invoice_items;
				$data['invoice_info'] = $invoice_info;
			} 
			if($this->input->server('REQUEST_METHOD') =='POST'){
				$invoice_items = $this->setRulesForInvoice();
				$data['invoice_items'] = $invoice_items;
				if ($this->form_validation->run() !== FALSE) {
					$updated_invoice = $this->Invoices_model->updateInvoice($invoice_items,$invoice_id);
					if($updated_invoice){
						$data['success'] ="yey";
					}else{
						$data['errors'] = TRUE;
					}	
				} else {
					$data['errors'] = TRUE;	
				}	
			}
			$data['js_header'] = array('invoices/invoice.js');
			$views = array('invoices/new','invoices/js_new_item');
			$this->loadView($views,$data);
		}else{
			echo "You can't edit invoice unles you are the admin!";	
		}	
	}
	
	
	/**
	 * setRulesForInvoice function - sets the form_validation rules 
	 * that are used in newIncome and editIncome functions
	 * @return array
	 */
	public function setRulesForInvoice(){
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
			
		$this->form_validation->set_rules('status', 'Status', 'required|numeric|xss_clean');
		$this->form_validation->set_rules('invoice_date', 'Invoice date', 'required|xss_clean');
		$this->form_validation->set_rules('category', 'Category', 'required|numeric|xss_clean');
		$this->form_validation->set_rules('transaction_type', 'Transaction', 'required|numeric|xss_clean');
		$this->form_validation->set_rules('shop', 'Shop', 'required|numeric|xss_clean');
		
		$field_properties = array(	
								array(
										'property'=>'type_id',
										'human_name'=>'Item type',
										'rules'=>'required|numeric'
									),	
								array(
										'property'=>'quantity',
										'human_name'=>'Quantity',
										'rules'=>'required|numeric'
									),
								array(
										'property'=>'item_price',
										'human_name'=>'Price',
										'rules'=>'required|numeric'
									),	
								array(
										'property'=>'item_name',
										'human_name'=>'Item name',
										'rules'=>'xss_clean'
									)
							);	
		$field = 'items';
		$field_human_name="Items";
		$field_rules = 'required|numeric';
		$field_error = "Please add at least one item";
		$items_array = $this->generateValidation($field,$field_properties,$field_human_name,$field_rules,$field_error);
		
		return $items_array;
	}
	
}

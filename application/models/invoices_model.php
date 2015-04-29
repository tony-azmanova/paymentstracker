<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
/** 
 * Invoices_model Class
 *  
 * @package Package Name 
 * @subpackage Subpackage 
 * @category Category 
 * @author Tony Azmanova 
 * @link http://localhost/payments/clients/index
 */ 
	
class Invoices_model extends CI_Model {
	
	/**
	 * __construct function -function that loads the database 
	 * 
	 */
	 
	public function __construct(){
        parent::__construct();
        
        $this->load->database();
    }
    
    /**
     * buildSelect function - build  a select to be used in more than one function 
	 * 
	 */
    
    public function buildSelect(){
		$subquery = '(CASE WHEN 
						SUM(items.item_price * items.quantity) > 
							0 
						THEN SUM(items.item_price * items.quantity)	
						ELSE 
							0 
						END)
			as total_invoice';
		
		$this->db->select('invoices.id,shops.shop_name,invoices.date_invoices,
		transactions.transaction_name,categories.category_name,
		statuses.status_name,users.username, '. $subquery);

		$this->db->from('invoices');
		$this->db->join('shops','shops.id = invoices.shop_id','left');
		$this->db->join('transactions','invoices.transaction = transactions.id','left');
		$this->db->join('categories','categories.id = invoices.category_id','left');
		$this->db->join('statuses','statuses.id = invoices.status_id','left');
		$this->db->join('items','invoices.id = items.invoice_id','left');
		$this->db->join('items_type','items.type = items_type.id','left');
		$this->db->join('users','invoices.created_by_id = users.id','left');
		$this->db->where('invoices.deleted','0');
	}
	
	/**
     * getAllInvoicesList function - get all the items for the pagination
	 * @param intiger $page is null
	 * @param intiger $limit is null
	 * @return array
	 */

	public function getAllInvoicesList($page=null,$limit=null){
		$this->buildSelect();
		$this->db->group_by('invoices.id');
		if(!empty($page)) {
			$start = ($page-1)*$limit;
			$this->db->limit($limit,$start);
		}
		$results = $this->db->get()->result_array();
		return $results;	
	}
	
	/**
     * countIncomesList function - count the result for the pagination
     * @return intiger
	 */
	public function countInvoiseList(){
		$this->db->select('COUNT(*) as count',FALSE);
		$this->db->where('invoices.deleted','0');
		$result = $this->db->get('invoices')->row_array();
		return $result['count'];	
	}
	
	/**
     * getStatistics function - get the two functions
	 * @return void
	 */
	public function getStatistics(){
		$this->getAllInvoice();
		$this->getAllIncomes();
	
	}
	
	
	/**
     * getAllInvoice function - get all the invoices for the pagination by date
	 * @param string $start_date is null
	 * @param string $end_date is null
	 * @return array
	 */
	 
	public function getAllInvoice($start_date=null,$end_date=null){
		$this->db->select('SUM(items.item_price* items.quantity) as this_month');
		$this->db->from('items');
		$this->db->join('invoices','items.invoice_id = invoices.id');
		if(!empty($start_date) && !empty($end_date)){
			$this->db->where('invoices.date_invoices BETWEEN "'. date('Y-m-d', strtotime($start_date)). '" and "'. date('Y-m-d', strtotime($end_date)).'"');
		}
		$this->db->where('invoices.deleted','0');
		$result = $this->db->get()->row_array();
		return $result;
	}
	
	
	/**
     * getCategory function - get all categories
	 * @return array
	 */
	public function getCategory(){
		$this->db->select('categories.category_name,categories.id');
		$this->db->from('categories');
		$result = $this->db->get()->result_array();
		return $result;
	}
	
	
	/**
     * getType function - get all transactions 
	 * @return array
	 */
	 
	public function getType(){
		$this->db->select('transactions.transaction_name,transactions.id');
		$this->db->from('transactions');
		$result = $this->db->get()->result_array();
		return $result;
		
	}
	
	/**
     * getShop function - get all shops
	 * @return array
	 */
	 
	public function getShop(){
		$this->db->select('shops.shop_name,shops.id');
		$this->db->from('shops');
		$this->db->where('shops.deleted','0');
		$results = $this->db->get()->result_array();
		return $results;
		
	}
	
	
	/**
     * getStatus function - get all status
	 * @return array
	 */
	 
	public function getStatus(){
		$this->db->select('statuses.status_name,statuses.id');
		$this->db->from('statuses');
		$result = $this->db->get()->result_array();
		return $result;
		
	}
	
	/**
     * getCity function - get all cities
	 * @return array
	 */
	 
	public function getCity(){
		
		$this->db->select('cities.city_name,cities.id');
		$this->db->from('cities');
		$result = $this->db->get()->result_array();
		return $result;
	}
	/**
     * insertNewInvoice function - insert in the database the new invoice
	 * @param array $invoise_items the posted fields
	 * @return bool
	 */
	
	public function insertNewInvoice($invoice_items){
		
		$this->db->trans_begin();
		
		$invoice = array(
			'shop_id'=>$this->input->post('shop'),
			'date_invoices'=>$this->input->post('invoice_date'),
			'transaction'=>$this->input->post('transaction_type'),
			'category_id'=>$this->input->post('category'),
			'created_by_id'=>$this->session->userdata('user_id'),
			'status_id'=>$this->input->post('status'),
			'deleted'=>'0'
		);
	
		$this->db->insert('invoices',$invoice);
		
		$invoice_id = $this->db->insert_id();
	
		$items_insert = array();
		foreach($invoice_items as $item){	
			$items_insert[] = array(
				'type'=>$item['type_id'],
				'quantity'=>$item['quantity'],
				'item_price'=>$item['item_price'],
				'item_name'=>$item['item_name'],
				'invoice_id'=>$invoice_id,
				'deleted'=>'0'
			);
		}
		
		$this->db->insert_batch('items',$items_insert);
		
		if ($this->db->trans_status() !== FALSE) {
			$this->db->trans_commit();
			return $invoice_id;
		}
		$this->db->trans_rollback();
		return false;
	}
	
	
	/**
     * getInvoiceInfo function - get all the information about the selected invoice
	 * @param integer $invoice_id is the invoice id
	 * @return array
	 */
	
	public function getInvoiceInfo($invoice_id){ 
	
		$this->db->select('invoices.id,shops.shop_name,invoices.date_invoices,
		transactions.transaction_name,transactions.id as transaction_id,categories.category_name,categories.id as category_id,
		statuses.status_name,statuses.id as status_id,users.username,shops.shop_addres,shops.id as shop_id,shops.shop_phone,cities.city_name,
		user_profile.first_name,user_profile.last_name,user_profile.email');

		$this->db->from('invoices');
		$this->db->join('shops','shops.id = invoices.shop_id','left');
		$this->db->join('cities','shops.shop_city = cities.id','left');
		$this->db->join('transactions','invoices.transaction = transactions.id','left');
		$this->db->join('categories','categories.id = invoices.category_id','left');
		$this->db->join('statuses','statuses.id = invoices.status_id','left');
		//$this->db->join('items','invoices.id = items.invoice_id','left');
		//$this->db->join('items_type','items.type = items_type.id','left');
		$this->db->join('users','invoices.created_by_id = users.id','left');
		$this->db->join('user_profile','users.profile_id = user_profile.id','left');
		$this->db->where('invoices.deleted','0');
		if($invoice_id){
			$this->db->where('invoices.id',$invoice_id);
		}	
		$results = $this->db->get()->row_array();
		return $results;
	}
	
	
	
	/**
     * totalInvoice function - get total sum of the selected invoice
	 * @param integer $invoice_id is the invoice id
	 * @return array
	 */
	
	public function totalInvoice($invoice_id){
		$this->db->select('
			(CASE 
				WHEN SUM(items.item_price * items.quantity) > 0 
					THEN SUM(items.item_price * items.quantity)
				ELSE 0
			END) as total_invoice');
		$this->db->from('items');
		$this->db->join('invoices','items.invoice_id = invoices.id');
		$this->db->where('invoices.id',$invoice_id);
		$result = $this->db->get()->row_array();
		return $result;
	}
	
	/**
     * removeInvoices function - changes invoice to a deleted 
	 * @param integer $invoice_id is the invoice id
	 * @return bool
	 */
	 
	public function removeInvoice($invoice_id){
		if($invoice_id){
			$delete = array(
				'deleted'=>'1'
			);
			$this->db->where('invoices.id',$invoice_id);
			$this->db->update('invoices',$delete);
			$deleted = array(
				'deleted'=>'1'
			);
			$this->db->where('items.invoice_id',$invoice_id);
			$this->db->update('items',$deleted);
			return true;
		}else{
			return false;
		}
	}
	
	
	/**
     * updateInvoice function - insert in the database the changed invoice
	 * @param integer $invoice_id is the invoice id
	 * @param array $invoice_items
	 * @return bool 
	 */
	 
	public function updateInvoice($invoice_items,$invoice_id){
		$this->db->trans_begin();
		
		$this->db->where('items.invoice_id',$invoice_id);
		$this->db->delete('items');
		
		$items_insert = array();
		foreach($invoice_items as $item){	
			$items_insert[] = array(
				'type'=>$item['type_id'],
				'quantity'=>$item['quantity'],
				'item_price'=>$item['item_price'],
				'item_name'=>$item['item_name'],
				'invoice_id'=>$invoice_id
			);
		}
		
		$invoice = array(
			'shop_id'=>$this->input->post('shop'),
			'date_invoices'=>$this->input->post('invoice_date'),
			'transaction'=>$this->input->post('transaction_type'),
			'category_id'=>$this->input->post('category'),
			'status_id'=>$this->input->post('status'),
			'deleted'=>'0'
		);	
		$this->db->where('invoices.id',$invoice_id);
		$this->db->update('invoices',$invoice);
		
		$this->db->insert_batch('items', $items_insert); 
		
		if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
				return false;
		} else 	{
			$this->db->trans_commit();
			return true;
		}
	}
	
}

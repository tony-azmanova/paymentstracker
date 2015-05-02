<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** 
* Items_model Class 
* 
* @package PaymentsTracker
* @subpackage Items_model
* @category Items
* @author Tony Azmanova <layela@abv.bg>
* @link http://tonyarticles.com
*/  
class Items_model extends CI_Model {
	
	/**
	 * __construct function -function that loads the database
	 */
	public function __construct(){
        parent::__construct();
        
        $this->load->database();
    }
    
    
	/**
     * insertNewItem function -insert in the database the new items
	 * @return bool
	 */
	public function insertNewItem(){
		$items = array(
			'type_name'=>$this->input->post('product_type'),
			'category_id'=>$this->input->post('category'),
			'deleted'=>'0'
			);
		$this->db->insert('items_type',$items);
		
		$i = $this->db->affected_rows();
		if($i > 0 ){
			return true;
		}else{	
			return false;
		}
	}
	
	/**
     * removeInvoicesItems function - delete the items from the selected invoice
	 * @param integer $invoice_id is the invoice id
	 * @return bool
	 */
	public function removeInvoicesItems($invoice_id){
		if($invoice_id){
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
     * ItemType function - delete the items type 
	 * @param integer $type_id is the items type id
	 * @return bool
	 */
	public function removeItemType($type_id){
		if($type_id){
			$deleted = array(
				'deleted'=>'1'
			);
			$this->db->where('items_type.id',$type_id);
			$this->db->update('items_type',$deleted);
			return true;	
		}else{
			return false;
		}
	}
	
	
	
	/**
     * getItems function - get all the items for the pagination
	 * @param integer|null $page is null if it is not defined else is the number of 
	 * the current page of the pagination
	 * @param integer|null $limit is null if it is not defined else is the 
	 * limit of results shown on the page 
	 * @return array
	 */
    public function getItems($page=null,$limit=null){
		
		$this->db->select('items_type.type_name,items_type.id,categories.category_name');
		$this->db->from('items_type');
		$this->db->join('categories','items_type.category_id = categories.id','left');
		$this->db->where('items_type.deleted','0');
		if(!empty($page)) {
			$start = ($page-1)*$limit;
			$this->db->limit($limit,$start);
		}
		$this->db->where('items_type.deleted','0');
		$result = $this->db->get()->result_array();
		return $result;
	}
	
	
	/**
     * countIncomesList function - count the result for the pagination
     * @return integer
	 */
	public function countItemsList(){
		$this->db->select('COUNT(*) as count',FALSE);
		$this->db->where('items_type.deleted','0');
		$result = $this->db->get('items_type')->row_array();
		return $result['count'];	
	}
	
	
	/**
     * itemsInfo function - get the information about the selected item type
	 * @param integer $type_id is the item type id
	 * @return array
	 */
	public function itemsInfo($type_id){
		if($type_id){
			$this->db->select('items_type.type_name,items_type.id,categories.category_name,categories.id as category_id');
			$this->db->from('items_type');
			$this->db->join('categories','items_type.category_id = categories.id','left');
			$this->db->where('items_type.id',$type_id);
			$this->db->where('items_type.deleted','0');
			$result = $this->db->get()->row_array();
			return $result;	
		}
	}
	
	/**
     * updateItemType function - insert in the database the changes in the edited item type
	 * @param integer $type_id is the item type id
	 * @return bool
	 */
	public function updateItemType($type_id){
		if(!$type_id){
			die;
		}else{
			$this->db->trans_begin();
			$update_items = array(
				'type_name'=>$this->input->post('product_type'),
				'category_id'=>$this->input->post('category'),
				'deleted'=>'0'
			);
			$this->db->where('items_type.id',$type_id);
			$this->db->update('items_type',$update_items);
			
			if($this->db->trans_status() !== FALSE){
				$this->db->trans_commit();
			}else{
				$this->db->trans_rollback();
				return false;
			}
		}
	}
	
    
	/**
     * itemInfo function - get the full details about the items in the selected invoice 
	 * @param string $invoice_id is the invoice id 
	 * @return array
	 */
	public function itemInfo($invoice_id){
		if(!$invoice_id){
			die;
		}	
		$subquery = 'SUM(items.item_price * items.quantity) as subtotal';	
		$this->db->select('items.item_price,items.quantity,items_type.id as type_id,
		items.invoice_id,items.item_name,items_type.type_name, '.$subquery);
		$this->db->from('items');
		$this->db->join('invoices','items.invoice_id= invoices.id ','left');
		$this->db->join('items_type','items.type = items_type.id','left');
		$this->db->where('items.invoice_id',$invoice_id);
		$this->db->where('items_type.deleted','0');
		$this->db->group_by('items.id');
		$results = $this->db->get()->result_array();
		return $results;
	}

}    

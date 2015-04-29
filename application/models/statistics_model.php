<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** 
 * Statistics_model Class 
 * 
 * @package Package Name 
 * @subpackage Subpackage 
 * @category Category 
 * @author Tony Azmanova 
 * @link http://localhost/payments/clients/index
 */ 
class Statistics_model extends CI_Model {
	
	/**
	 * __construct function -function that loads the database 
	 * 
	 */
	public function __construct(){
        parent::__construct();
        
        $this->load->database();
    
    }
    /**
     * getWholeStat function - get full statistics about the incomes and expenses. 
     * If the $start_date and $end_date are not null then get statistics for the selected range of dates.
     * If the $user_id is not null then show the statistics of the selected user
	 * @param string $start_date is null
	 * @param string $end_date is null
	 * @param integer $user_id is the id of the user 
	 * @return array
	 */
	 
    public function getWholeStat($start_date=null,$end_date=null,$user_id=null){
		
		if(empty($start_date) && empty($end_date)){
			$where_expenses = null;
		}else{
			$this->db->where('incomes.date_incomes BETWEEN "'. date('Y-m-d', strtotime($start_date)). '" and "'. date('Y-m-d', strtotime($end_date)).'"');
			$where_expenses = ' AND invoices.date_invoices BETWEEN "'. date('Y-m-d', strtotime($start_date)). '" and "'. date('Y-m-d', strtotime($end_date)).'"';
		}
		if($user_id){
			$user = ' AND users.id ='.(int)$user_id ; 	
		}else{
			$user = null;
		}
			
		$this->db->select('
		(CASE WHEN SUM(incomes.total_income) > 0
			THEN
				SUM(incomes.total_income)
			ELSE
				0
		END) as total_incomes,
			(SELECT 
				(CASE 
					WHEN SUM(items.item_price * items.quantity) > 0
						THEN
							SUM(items.item_price * items.quantity)
					ELSE
							0
				END) as total_exspenses
				FROM items 
				JOIN invoices ON items.invoice_id = invoices.id
				JOIN users ON users.id = invoices.created_by_id
				WHERE invoices.deleted = 0'.
				$where_expenses. $user. '
			) as total_exspenses
		');
		$this->db->from('incomes');
		$this->db->where('incomes.deleted','0');
		$results = $this->db->get()->row_array();
		return $results;
	}
    
    
    
    /**
     * getTopExpenses function - get full statistics about the  expenses. 
     * If the $start_date and $end_date are not null then get statistics for the selected range of dates
     * If the $user_id is not null then show the statistics of the selected user
     * @parem integer $limit is the number of the expenses that it has to return
	 * @param string $start_date is null
	 * @param string $end_date is null
	 * @param integer $user_id is the id of the user 
	 * @return array
	 */
    
    public function getTopExpenses($limit=10,$start_date=null,$end_date=null,$user_id=null){
		
		if(!empty($start_date) && !empty($end_date)){
			
			$where_expenses = ' AND invoices.date_invoices BETWEEN "'. date('Y-m-d', strtotime($start_date)). '" and "'. date('Y-m-d', strtotime($end_date)).'"';
		} else {
			$where_expenses = null;
		}	
		if($user_id){
			$user = ' AND users.id ='. (int)$user_id ; 	
		}else{
			$user = null;
		}
			
		$this->db->select('users.username,
			(SELECT 
				(CASE 
					WHEN SUM(items.item_price * items.quantity) > 0
					THEN 
						SUM(items.item_price * items.quantity) 
					ELSE 0
				END) as total_exspenses
			FROM items 
            JOIN invoices 
            ON items.invoice_id = invoices.id
			WHERE users.id = invoices.created_by_id
			AND invoices.deleted = 0'.
			$where_expenses. $user . '
			) as total_exspenses
		
		',FALSE);
		$this->db->from('users');
		
		$this->db->limit($limit);
		$this->db->order_by('total_exspenses','desc'); 
		
		$results = $this->db->get()->result_array();
		return $results;
	}
	
	/**
     * getTopIncomes function - get full statistics about the incomes. 
     * If the $start_date and $end_date are not null then get statistics for the selected range of dates
     * If the $user_id is not null then show the statistics of the selected user
     * @parem integer $limit is the number of the incomes that it has to return
	 * @param string $start_date is null
	 * @param string $end_date is null
	 * @param integer $user_id is the id of the user 
	 * @return array
	 */
	 
	public function getTopIncomes($limit=10,$start_date=null,$end_date=null,$user_id=null){
			
		$this->db->select('users.username,
			(CASE 
				WHEN SUM(incomes.total_income) > 0
					THEN SUM(incomes.total_income) 
				ELSE 0
			END) as top_incomes
		',FALSE);
		$this->db->from('users');
		$this->db->join('incomes','users.id = incomes.income_user');
		if(!empty($start_date) && !empty($end_date)){
			//$this->db->where('incomes.income_user','users.id');
			$this->db->where('incomes.date_incomes BETWEEN "'. date('Y-m-d', strtotime($start_date)). '" and "'. date('Y-m-d', strtotime($end_date)).'"');
		}
		if($user_id){
			$this->db->where('users.id',(int)$user_id); 	
		}
		$this->db->where('incomes.deleted','0');
		$this->db->limit($limit);
		$this->db->group_by('users.id');
		$this->db->order_by('top_incomes','desc');
		
		$result = $this->db->get()->result_array();
		
		return $result;
	}
	

    /**
     * getTopExpByShop function - get full statistics about the expenses by shop. 
     * If the $start_date and $end_date are not null then get statistics for the selected range of dates
	 * If the $user_id is not null then show the statistics of the selected user
     * @parem integer $limit is the number of the expenses by shop that it has to return
	 * @param string $start_date is null
	 * @param string $end_date is null
	 * @param integer $user_id is the id of the user 
	 * @return array
	 */
	 
    public function topExpByShop($limit=10,$start_date=null,$end_date=null,$user_id=null){
		$this->db->distinct();
		$this->db->select('shops.shop_name,
			(SELECT (CASE WHEN SUM(items.item_price * items.quantity) >0 
					THEN SUM(items.item_price * items.quantity) 
					ELSE 0 
				END) as total_exspenses
				FROM items 
				JOIN invoices ON items.invoice_id = invoices.id
				WHERE shops.id = invoices.shop_id
				AND invoices.deleted = 0
			) as total_invoice');
		$this->db->from('shops');
		$this->db->join('invoices','invoices.shop_id = shops.id');
		if(!empty($start_date) && !empty($end_date)){
			$this->db->where('invoices.date_invoices BETWEEN "'. date('Y-m-d', strtotime($start_date)). '" and "'. date('Y-m-d', strtotime($end_date)).'"');
		}
		if($user_id){
			$this->db->join('users','invoices.created_by_id = users.id');
			$this->db->where('users.id',(int)$user_id); 	
		}
		$this->db->where('shops.deleted','0');
		$this->db->limit($limit);
		$this->db->order_by('total_invoice','desc');
		
		$results = $this->db->get()->result_array();
		return $results;
	}

    /**
     * getExpByItem function - get full statistics about the expenses by item. 
     * If the $start_date and $end_date are not null then get statistics for the selected range of dates
     * If the $user_id is not null then show the statistics of the selected user
     * @parem integer $limit is the number of the expenses by item that it has to return
	 * @param string $start_date is null
	 * @param string $end_date is null
	 * @param integer $user_id is the id of the user 
	 * @return array
	 */
	 
    public function getExpByItem($limit=10,$start_date=null,$end_date=null,$user_id=null){
		if(!empty($start_date) && !empty($end_date)){
			$where_expenses = ' AND invoices.date_invoices BETWEEN "'. date('Y-m-d', strtotime($start_date)). '" and "'. date('Y-m-d', strtotime($end_date)).'"';
			
		} else {
			$where_expenses = null;
		}
		if($user_id){
			$user = ' AND users.id ='. (int)$user_id; 	
		}else{
			$user = null;
		}
			
		$this->db->distinct();
		$this->db->select('items_type.type_name,
			(SELECT 
				(CASE WHEN SUM(items.item_price * items.quantity) >0 
					THEN SUM(items.item_price * items.quantity) 
					ELSE 0 
				END)as total_exspenses
				FROM items 
				JOIN invoices ON items.invoice_id = invoices.id
				JOIN users ON users.id = invoices.created_by_id
				WHERE items.type = items_type.id 
				AND items.deleted = 0 '.
				$where_expenses .$user .'
			) as subtotal');
		$this->db->from('items');
		$this->db->join('items_type','items.type = items_type.id');
		
		$this->db->limit($limit);
		$this->db->order_by('subtotal','desc');
		
		$results = $this->db->get()->result_array();
		return $results;
	}
	
	
	/**
     * getExpByCategory function - get full statistics about the expenses by cytegory. 
     * If the $start_date and $end_date are not null then get statistics for the selected range of dates
     * If the $user_id is not null then show the statistics of the selected user
     * @parem integer $limit is the number of the expenses by category that it has to return
	 * @param string $start_date is null
	 * @param string $end_date is null
	 * @param integer $user_id is the id of the user 
	 * @return array
	 */
	 
	public function getExpByCategory($limit=10,$start_date=null,$end_date=null,$user_id=null){
		$this->db->distinct();
		$this->db->select('categories.category_name,
			(SELECT 
				(CASE WHEN SUM(items.item_price * items.quantity) >0 
					THEN SUM(items.item_price * items.quantity) 
					ELSE 0 
				END) as total_invoice
				FROM items 
				JOIN invoices ON items.invoice_id = invoices.id
				WHERE categories.id = invoices.category_id
			) as total_invoice');
		$this->db->from('categories');
		$this->db->join('invoices','categories.id = invoices.category_id');
		if(!empty($start_date) && !empty($end_date)){
			$this->db->where('invoices.date_invoices BETWEEN "'. date('Y-m-d', strtotime($start_date)). '" and "'. date('Y-m-d', strtotime($end_date)).'"');
		}
		if($user_id){
			$this->db->join('users','invoices.created_by_id = users.id');
			$this->db->where('users.id',(int)$user_id); 	
		}
		$this->db->where('invoices.deleted','0');
		$this->db->limit($limit);
		$this->db->order_by('total_invoice','desc');
		
		$results = $this->db->get()->result_array();
		return $results;
	
	}
}

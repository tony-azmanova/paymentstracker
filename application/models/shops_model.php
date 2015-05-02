<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** 
* Shops_model Class 
* 
* @package PaymentsTracker
* @subpackage Shops_model
* @category Shops
* @author Tony Azmanova <layela@abv.bg>
* @link http://tonyarticles.com
*/  
class Shops_model extends CI_Model {
	
	/**
	 * __construct function - loads the database 
	 */
	public function __construct(){
        parent::__construct();
        
        $this->load->database();
    }
    
	/**
     * getShops function - get all shops for the pagination
	 * @param integer|null $page is null if it is not defined else is the number of 
	 * the current page of the pagination
	 * @param integer|null $limit is null if it is not defined else is the 
	 * limit of results shown on the page 
	 * @return array
	 */
	public function getShops($page=null,$limit=null){
	
		$this->db->select('shops.id,shops.shop_name,shops.shop_addres,
		shops.shop_phone,categories.category_name,cities.city_name,
		');
		$this->db->from('shops');
		$this->db->join('cities','shops.shop_city = cities.id','left');
		$this->db->join('categories','shops.shop_category = categories.id','left');
		$this->db->where('shops.deleted','0');
		if(!empty($page)) {
			$start = ($page-1)*$limit;
			$this->db->limit($limit,$start);
		}
		$this->db->where('shops.deleted','0');
		$result = $this->db->get()->result_array();
		return $result;
	}
	
	
	/**
     * countShopsList function - count the result for the pagination
     * @return integer
	 */
	public function countShopsList(){
		$this->db->select('COUNT(*) as count',FALSE);
		$this->db->where('shops.deleted','0');
		$result = $this->db->get('shops')->row_array();
		return $result['count'];	
	}
	
	/**
     * getForEditShops function - get the full information about the selected shop 
	 * @param integer $shop_id is the id of the selected shop 
	 * @return array
	 */
	public function getForEditShops($shop_id){
	
		$this->db->select('shops.id,shops.shop_name,shops.shop_addres,
		shops.shop_phone,categories.category_name,cities.city_name,cities.id as city_id,categories.id as category_id');
		$this->db->from('shops');
		$this->db->join('cities','shops.shop_city = cities.id','left');
		$this->db->join('categories','shops.shop_category = categories.id','left');
		$this->db->where('shops.deleted','0');
		if($shop_id){
			$this->db->where('shops.id',$shop_id);
		}
		$result = $this->db->get()->row_array();
		return $result;
	}
	
	/**
     * updateShop function - insert in the database the new shop
	 * @param integer $shop_id is the id of the selected shop 
	 * @return bool
	 */
    public function insertNewShop(){
		
		$shops= array(
			'shop_name'=>$this->input->post('shop_name'),
			'shop_addres'=>$this->input->post('shop_addres'),
			'shop_phone'=>$this->input->post('shop_phone'),
			'shop_city'=>$this->input->post('city'),
			'shop_category'=>$this->input->post('category'),
			'deleted'=>'0'
			);
			
		$this->db->insert('shops',$shops);
		
		$i = $this->db->affected_rows();
		if($i > 0 ){
			return true;
		}else{	
			return false;
		}
	}

	/**
     * updateShop function - insert in the database the changes that were made on the selected shop
	 * @param integer $shop_id is the id of the selected shop 
	 * @return bool
	 */
	public function updateShop($shop_id){
		$this->db->trans_begin();
		
		if(!$shop_id){
			die;
		}else{
			$update_shops = array(
				'shop_name'=>$this->input->post('shop_name'),
				'shop_addres'=>$this->input->post('shop_addres'),
				'shop_phone'=>$this->input->post('shop_phone'),
				'shop_city'=>$this->input->post('city'),
				'shop_category'=>$this->input->post('category'),
				'deleted'=>'0'
				);
				
			$this->db->where('shops.id',$shop_id);
			
			$this->db->update('shops',$update_shops);	
			
			if($this->db->trans_status() !== FALSE){
				$this->db->trans_commit();
			}else{
				$this->db->trans_rollback();
				return false;
			}
		}
	}
	
	/**
     * removeShop function -changes shop to a deleted 
	 * @param integer $shop_id is the id of the selected shop 
	 */
	public function removeShop($shop_id){
		if($shop_id){
			$deleted = array(
				'deleted'=>'1'
			);
			$this->db->where('shops.id',$shop_id);
			$this->db->update('shops',$deleted);
			return true;
		}else{
			return false;
		}
	}
    
}    

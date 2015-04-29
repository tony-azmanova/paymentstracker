<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** 
 * Incomes_model Class 
 * 
 * @package Package Name 
 * @subpackage Subpackage 
 * @category Category 
 * @author Tony Azmanova 
 * @link http://localhost/payments/clients/index
 */ 
class Incomes_model extends CI_Model {

	/**
	 * __construct function -function that loads the database 
	 * 
	 */
	 
	public function __construct(){
        parent::__construct();
        
        $this->load->database();
    
    }
    
    /**
     * getIncomes function - get all the incomes for the pagination
	 * @param intiger $page is null
	 * @param intiger $limit is null
	 */
    
    public function getIncomes($page=null,$limit=null){
		
		$this->db->select('
			incomes.id,incomes.date_incomes,incomes_categories.category_name,
			incomes_client.company_name,users.username,incomes_client.first_name,incomes_client.last_name,
			incomes.income_name,incomes.total_income, 
				(CASE WHEN incomes_client.company_name is NULL THEN
					"-" ELSE incomes_client.company_name
				END) as company,
				(CASE WHEN first_name is NULL THEN 
				"-" ELSE 
				first_name
				END) as client_first_name,
				(CASE WHEN last_name is NULL THEN 
					"-" ELSE 
					last_name
				END) as client_last_name
			',FALSE);
		$this->db->from('incomes');
		$this->db->join('incomes_categories','incomes.income_category = incomes_categories.id','left');
		$this->db->join('incomes_client','incomes.income_client = incomes_client.id','left');
		$this->db->join('users','incomes.income_user = users.id','left');
		$this->db->where('incomes.deleted','0');
		if(!empty($page)) {
			$start = ($page-1)*$limit;
			$this->db->limit($limit,$start);
		}
		
		$results = $this->db->get()->result_array();
        return $results;
		
	}
	/**
     * countIncomesList function - count the incomes for the pagination
     * @return intiger
	 */
	 
	public function countIncomesList(){
		$this->db->select('COUNT(*) as count',FALSE);
		$this->db->where('incomes.deleted','0');
		$result = $this->db->get('incomes')->row_array();
		return $result['count'];	
	}
	
	/**
     * getIncomesCategories function - get all categories
     * @return array
	 */
	 
	public function getIncomesCategories(){
		
		$this->db->select('incomes_categories.id,incomes_categories.category_name');
		$this->db->from('incomes_categories');
		
		$results = $this->db->get()->result_array();
        return $results;
	}
	
	/**
     * getAllIncomes function - get all the incomes for the pagination by date
	 * @param string $start_date is null
	 * @param string $end_date is null
	 * @return array
	 */
	 
	public function getAllIncomes($start_date=null,$end_date=null){
	
		$this->db->select('SUM(incomes.total_income) as income_total');
		$this->db->from('incomes');
		if(!empty($start) && !empty($end)){
			$this->db->where('incomes.date_incomes BETWEEN "'. date('Y-m-d', strtotime($start_date)). '" and "'. date('Y-m-d', strtotime($end_date)).'"');
		}
		if(!empty($start_date_privios) && !empty($end_date_privios)){
			$this->db->where('incomes.date_incomes BETWEEN "'. date('Y-m-d', strtotime($start_date_privios)). '" and "'. date('Y-m-d', strtotime($end_date_privios)).'"');
		}
		$this->db->where('incomes.deleted','0');
		$results = $this->db->get()->row_array();
        return $results;
	}
	
	
	
	/**
     * getInfoIncomes function - get the full details about the selected income 
	 * @param string $income_id is the income id 
	 * @return array
	 */
	 
	public function getInfoIncomes($income_id){
		$this->db->select('incomes.id,incomes.date_incomes,incomes_categories.category_name,incomes_categories.id as category_id,
		incomes_client.company_name,users.username,users.id as user_id,
		incomes.income_name,incomes.total_income,incomes_client.id as clients_id,
		incomes_client.last_name,incomes_client.first_name,
		incomes_client.email,incomes_client.phone,
			(CASE WHEN incomes_client.company_name is NULL THEN
				"-" ELSE incomes_client.company_name
			END) as company,
			(CASE WHEN first_name is NULL THEN 
				"-" ELSE 
				first_name
			END) as client_first_name,
			(CASE WHEN last_name is NULL THEN 
				"-" ELSE 
				last_name
			END) as client_last_name
				
			',FALSE);
		$this->db->from('incomes');
		$this->db->join('incomes_categories','incomes.income_category = incomes_categories.id','left');
		$this->db->join('incomes_client','incomes.income_client = incomes_client.id','left');
		$this->db->join('users','incomes.income_user = users.id','left');
		$this->db->where('incomes.deleted','0');
		if($income_id){
			$this->db->where('incomes.id',$income_id);
		}
		$this->db->group_by('incomes.id');
		$results = $this->db->get()->row_array();
        return $results;
	}
	
	
	/**
     * getTotalIncomeByUser function - get the total incomes about the selected user
	 * @return array
	 */
	 
	public function getTotalIncomeByUser(){
		$this->db->select('SUM(incomes.total_income) as total_income');
		$this->db->from('incomes');
		$this->db->join('users','incomes.income_user = users.id','left');
		$this->db->where('incomes.deleted','0');
		$this->db->group_by('incomes.income_user');
		
		$results = $this->db->get()->result_array();
        return $results;
		
	}
	
	/**
     * insertNewIncomes function - insert in the database the new income
	 * @return bool
	 */
	 
	public function insertNewIncomes(){
		$this->db->trans_begin();
		
		$incomes= array(
			'date_incomes'=>$this->input->post('income_date'),
			'income_category'=>$this->input->post('income_category'),
			'income_user'=>$this->input->post('income_user'),
			'income_client'=> $this->input->post('clients'),
			'income_name'=>$this->input->post('income_name'),
			'total_income'=>$this->input->post('total_income'),
			'deleted'=>'0'
			);
		
		$this->db->insert('incomes',$incomes);
		
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return false;
		} else {
			$this->db->trans_commit();
			return true;
		}
	}
	
	
	
	
	/**
     * updateIncomes function - insert in the database the changed income
	 * @param integer $income_id is the income id
	 * @return bool
	 */
	 
	public function updateIncomes($income_id){
		if($income_id){
			$incomes= array(
						'date_incomes'=>$this->input->post('income_date'),
						'income_category'=>$this->input->post('income_category'),
						'income_user'=>$this->input->post('income_user'),
						'income_client'=> $this->input->post('clients'),
						'income_name'=>$this->input->post('income_name'),
						'total_income'=>$this->input->post('total_income'),
						'deleted'=>'0'
					);
					
			$this->db->where('incomes.id',$income_id);
			$this->db->update('incomes',$incomes);
			return true;
		}else{
			return false;
		}
	}
	
	
	/**
     * removeIncomes function - changes income to a deleted 
	 * @param integer $income_id is the income id
	 * @return bool
	 */
	 
	public function removeIncomes($income_id){
		if($income_id){
			$deleted = array(
				'deleted'=>'1'
			);
			
			$this->db->where('incomes.id',$income_id);
			$this->db->update('incomes',$deleted);
			
			return true;
		}else{
			return false;
		}
	}
	
}    

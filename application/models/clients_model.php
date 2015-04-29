<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/** 
 * Clients_model Class 
 * 
 * @package Package Name 
 * @subpackage Subpackage 
 * @category Category 
 * @author Tony Azmanova 
 * @link http://localhost/payments/clients/index
 */ 
class Clients_model extends CI_Model {
	
	/**
	 * __construct function -function that loads the database 
	 * 
	 **/
	 
	public function __construct(){
        parent::__construct();
        
        $this->load->database();
    }
    
    
    /**
     * getClients function - get all clients/companies for the pagination
	 * @param intiger $page is null
	 * @param intiger $limit is null
	 * @return array
	 */
	 
    public function getClients($page=null,$limit=null){
		
		$this->db->select('incomes_client.id,incomes_client.company_name,
		incomes_client.first_name,incomes_client.last_name,
		incomes_client.email,incomes_client.phone,
			(CASE 
				WHEN company_name IS NULL 
					THEN ""	
				ELSE company_name 
			END) as company_name,
			(CASE 
				WHEN first_name IS NULL 
					THEN ""
				ELSE GROUP_CONCAT(company_name,",",first_name,",",last_name)  
			END) as client,
			(CASE 
				WHEN last_name IS NULL 
					THEN "" 
				ELSE GROUP_CONCAT(company_name,",",first_name,",",last_name)  
			END) as client
		',FALSE);
		$this->db->from('incomes_client');
		
		if(!empty($page)) {
			$start = ($page-1)*$limit;
			$this->db->limit($limit,$start);
		}
		$this->db->where('incomes_client.deleted','0');
		$this->db->group_by('incomes_client.id');
		$results = $this->db->get()->result_array();
		return $results;	
		
	}
	
	
	/**
     * countClientsList function - count the result for the pagination
     * @return integer
	 */
	 
	public function countClientsList(){
		$this->db->select('COUNT(*) as count',FALSE);
		$this->db->where('incomes_client.deleted','0');
		$result = $this->db->get('incomes_client')->row_array();
		return $result['count'];	
	}
	
	
	/**
     * insertNewClient function - insert in the database the new client/company
	 * @return integer 
	 */
	 
	public function insertNewClient(){
		
		$clients = array(
				'company_name'=>$this->input->post('company_name'),
				'first_name'=>$this->input->post('client_first_name'),
				'last_name'=>$this->input->post('client_last_name'),
				'email'=>$this->input->post('client_email'),
				'phone'=>$this->input->post('client_phone'),
				'deleted'=>'0'
				);
		$results = $this->db->insert('incomes_client',$clients);
		
		return $results;
	}
	
	
	/**
     * getClientsInfo function - get the full details about the selected client/company 
	 * @param string $client_id is the client/company id 
	 * @return array
	 */
	 
	public function getClientInfo($client_id){
		$this->db->select('incomes_client.id,incomes_client.company_name,
		incomes_client.first_name,incomes_client.last_name,
		incomes_client.email,incomes_client.phone,
		');
		$this->db->from('incomes_client');
		if($client_id){
			$this->db->where('incomes_client.id',$client_id);
		}
		$this->db->where('incomes_client.deleted','0');
		$results = $this->db->get()->row_array();
		return $results;	
	
	}
	
	/**
     * updateClient function - update in the database the changed client/company
	 * @param string $client_id is the client/company id 
	 * @return bool 
	 */
	 
	public function updateClient($client_id){
		if($client_id){
			$clients = array(
						'company_name'=>$this->input->post('company_name'),
						'first_name'=>$this->input->post('client_first_name'),
						'last_name'=>$this->input->post('client_last_name'),
						'email'=>$this->input->post('client_email'),
						'phone'=>$this->input->post('client_phone'),
						'deleted'=>'0'
						);
			$this->db->where('incomes_client.id',$client_id);	
			$this->db->update('incomes_client',$clients);
			return true;
		}else{
			return false;
		}	
    }
    
    /**
     * removeClients function - delete cliens  
	 * @param integer $client_id is the client id
	 * @return bool
	 */
	 
    public function removeClients($client_id){
		if($client_id){
		$deleted = array(
				'deleted'=>'1'
			);	
			
			$this->db->where('incomes_client.id',$client_id);
			$this->db->update('incomes_client',$deleted);
			return true;
		}else{
			return false;
		}
	}

}

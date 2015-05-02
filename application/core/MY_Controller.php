<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** 
 * MY_Controller Class 
 * 
 * @package MY_Controller
 * @subpackage MY_Controller 
 * @category CodeIgniter Common 
 * @author Evtimiy Mihaylov
 * @link http://neatlogos.com
 */ 
class MY_Controller extends CI_Controller {
	
	protected $user;
	/**
	 * __construct function -function that loads the User_model
	 * 
	 */
	public function __construct(){
		parent::__construct();
        $this->user = $this->Users_model->userProfile();
  
    }
        
	/**
	 * Loads  the header, central(one or more) and footer partials
	 * @param array $views are the views that can be loaded 
	 * @param array $data is the information that is passed to the view
	 * @return 
	 *
	 **/
	public function loadView($views,$data){
		$data['user']= $this->user;
		$this->load->view('common/header',$data);
		
		if(is_array($views)) {
			foreach($views as $view) {
				$this->load->view($view,$data);
			}
		} else {
			$this->load->view($views,$data);
		}	
		
		$this->load->view('common/footer',$data);
		
	}
	
	
	/**
	 * Custom validation rules for separate array field validation and separate error messages
	 * @param array $field the names of the field
	 * @param array $properties
	 * @param array $field_human_name human name of the field used on error
	 * @param       $rules
	 * @param       $field_error
	 * @return array
	 *
	 **/
	public function generateValidation($field,$properties,$field_human_name,$rules,$field_error=null) {
		$this->load->library('form_validation');
		$fields = $this->input->post($field);
		$items_array = array();
		if($fields) {
			$i=0;
			foreach($fields as $field_param=>$field_items) {
				foreach($field_items as $field_item=>$item_value) {
					$items_array[$field_item][$field_param] = $item_value;
				}
				
			$i++;
			}
			$i=0;
			foreach($items_array as $item) {
				foreach($properties as $property) {
					$this->form_validation->set_rules($field.'['.$property['property'].']['. $i .']',$property['human_name'], $property['rules']);
				}
			$i++; 	
			}	
		}else{
			
			if(!empty($field_error)){
				$this->form_validation->set_rules($field, $field_human_name, 'callback_required_items['.$field_error.']');
			}	
		}
		
		return $items_array;
	}
	 
	 /**
	 * Custom required form items function for form validation
	 * @param array $str
	 * @param array $field_error is the custom message 
	 * @return bool
	 *
	 **/
	public function required_items($str,$field_error) {
		$this->form_validation->set_message('required_items', $field_error);
		return false;
	}	
	
}	

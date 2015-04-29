<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	/** 
	* Statistics Class 
	* 
	* @package Package Name 
	* @subpackage Subpackage 
	* @category Category 
	* @author Tony Azmanova 
	* @link http://localhost/payments/statistics/index
	*/ 
class Statistics extends MY_Controller {
	
	/**
	 * __construct function -function that loads the
	 * Statistics_model for the Shops controller 
	 * @param array $user_stat check if the user is with activ status
	 * @return sring if the user is with status inactiv 
	 * 
	 */
	 
	public function __construct(){
        parent::__construct();
        $this->load->model('Statistics_model');
        $user_stat = $this->Users_model->userStatus();
		if($user_stat){
			echo "You have to wait the admin to change your status to 'activ'!";
			die;
		}	
        $this->output->enable_profiler(TRUE);  
    }
    
    
     /**
	 * index function - the index function for the Statistics controller 
	 * @return void
	 */
	 
    public function index(){
		if(!$this->Users_model->userloggedIn() ){
			redirect('invoices/index');
			die;
		}
		
		$start =  date('Y-m-01');
		$end = date('Y-m-t'); 
		$data['start_date_more_previos'] = date('Y-m-d', strtotime("first day of -2 month"));
		$data['end_date_more_previos'] = date('Y-m-d', strtotime("last day of -2 month"));
		$data['start_date_privios'] = date('Y-m-d', strtotime("first day of -1 month"));
		$data['end_date_privios'] = date('Y-m-d', strtotime("last day of -1 month")); 
		$data['start_date_this'] = $start;
		$data['end_date_this'] = $end;
		$statistics = $this->Statistics_model->getWholeStat();
		/*$top_expenses = $this->Statistics_model->getTopExpenses();
		$top_incomes = $this->Statistics_model->getTopIncomes();
		$top_shops = $this->Statistics_model->topExpByShop();
		$top_items = $this->Statistics_model->getExpByItem();
		$top_categories = $this->Statistics_model->getExpByCategory();
		$data['top_expenses'] = $top_expenses;
		$data['top_incomes'] = $top_incomes;
		$data['top_shops'] = $top_shops;
		$data['top_items'] = $top_items;
		$data['top_categories'] = $top_categories;*/
		$data['statistics'] = $statistics;
		
		$this->loadView('statistics/statistics',$data);
	}
	
	
	 /**
	 * stats function - this function builds up the chart 
	 * @param string $start_date start date for the chart
	 * @param string $end_date end date for the chart
	 * @return void 
	 */
	public function stats($start_date,$end_date) {
		
		$statistics = $this->Statistics_model->getWholeStat($start_date,$end_date);
		$top_expenses = $this->Statistics_model->getTopExpenses($limit=10,$start_date,$end_date);
		$top_incomes = $this->Statistics_model->getTopIncomes($limit=10,$start_date,$end_date);
		$top_shops = $this->Statistics_model->topExpByShop($limit=10,$start_date,$end_date);
		$top_items = $this->Statistics_model->getExpByItem($limit=10,$start_date,$end_date);
		$top_categories = $this->Statistics_model->getExpByCategory($limit=10,$start_date,$end_date);
		$data['top_expenses'] = $top_expenses;
		$data['top_incomes'] = $top_incomes;
		$data['top_shops'] = $top_shops;
		$data['top_items'] = $top_items;
		$data['top_categories'] = $top_categories;	
		$data['incomes'] = $statistics['total_incomes'];
		$data['expenses'] = $statistics['total_exspenses'];
		$this->load->view('statistics/graph',$data);
	}	
	/**
	 * graph function - the function that creates the chart
	 * @param string $incomes total incomes for the chart
	 * @param string $expenses total expenses for the chart
	 * @return void 
	 */
	public function graph($incomes,$expenses){
		require_once(APPPATH.'/libraries/chart/pChart/pChart.class');
		require_once(APPPATH.'/libraries/chart/pChart/pData.class');
		$font_path = APPPATH.'/libraries/chart/';
		
		$DataSet = new pData;  
		$DataSet->AddPoint(array($incomes,$expenses),"Serie1");  
		$DataSet->AddPoint(array("Incomes","Expenses"),"Serie2");
		$DataSet->AddAllSeries();  
		$DataSet->SetAbsciseLabelSerie("Serie2");
		$Test = new pChart(500,200);  
		$Test->drawFilledRoundedRectangle(7,7,373,193,5,240,240,240);  
		$Test->drawRoundedRectangle(5,5,375,195,5,230,230,230);    
		$Test->setFontProperties($font_path."Fonts/tahoma.ttf",8);  
		$Test->drawPieGraph($DataSet->GetData(),$DataSet->GetDataDescription(),200,90,110,PIE_PERCENTAGE,TRUE,60,30,10);  
		$Test->drawPieLegend(310,15,$DataSet->GetData(),$DataSet->GetDataDescription(),25,250,25);  
		 
		$Test->Stroke();
		
		
		
	}
    
	/*public function myChart($incomes,$expenses){
		$statistics = $this->Statistics_model->getWholeStat();
		
		//print_r($statistics); //die;
		require_once(APPPATH.'/libraries/chart/pChart/pChart.class');
		require_once(APPPATH.'/libraries/chart/pChart/pData.class');
		$font_path = APPPATH.'/libraries/chart/';
		
		// Dataset definition   
		$DataSet = new pData;  
		$DataSet->AddPoint(array($incomes,$expenses),"Serie1");  
		$DataSet->AddPoint(array("Incomes","Expenses"),"Serie2");  
		$DataSet->AddAllSeries();  
		$DataSet->SetAbsciseLabelSerie("Serie2");  
		 
		// Initialise the graph  
		$Test = new pChart(500,200);  
		$Test->drawFilledRoundedRectangle(7,7,373,193,5,240,240,240);  
		$Test->drawRoundedRectangle(5,5,375,195,5,230,230,230);  
		 
		// Draw the pie chart  
		$Test->setFontProperties($font_path."Fonts/tahoma.ttf",8);  
		$Test->drawPieGraph($DataSet->GetData(),$DataSet->GetDataDescription(),200,90,110,PIE_PERCENTAGE,TRUE,60,30,10);  
		$Test->drawPieLegend(310,15,$DataSet->GetData(),$DataSet->GetDataDescription(),25,250,25);  
		 
		$Test->Stroke();
	}*/
    
}    

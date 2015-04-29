<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tony extends CI_Controller {


	public function index() {
		
		echo "This is my first controller - this is the index";
	
	}

	
	public function myNextPage($title) {
	
		$data['title'] = $title;
		$data['my_page_content'] = 'This is my view content';
		$this->load->view('tony/mynextpage',$data);
		
	}
	
	public function getUserFromDB($id) {
	
		$this->load->model('Tony_model');
		
		$user_data = $this->Tony_model->getUser($id);
		
		$this->load->view('tony/getuserfromdb',$user_data);
		
	}
	
	public function myChart() {
	
		require_once(APPPATH.'/libraries/charts/pChart/pChart.class');
		require_once(APPPATH.'/libraries/charts/pChart/pData.class');
		$font_path = APPPATH.'/libraries/charts/';
		
		// Dataset definition   
		$DataSet = new pData;  
		$DataSet->AddPoint(array(800,500),"Serie1");  
		$DataSet->AddPoint(array("Incomes","Expenses"),"Serie2");  
		$DataSet->AddAllSeries();  
		$DataSet->SetAbsciseLabelSerie("Serie2");  
		 
		// Initialise the graph  
		$Test = new pChart(380,200);  
		$Test->drawFilledRoundedRectangle(7,7,373,193,5,240,240,240);  
		$Test->drawRoundedRectangle(5,5,375,195,5,230,230,230);  
		 
		// Draw the pie chart  
		$Test->setFontProperties($font_path."Fonts/tahoma.ttf",8);  
		$Test->drawPieGraph($DataSet->GetData(),$DataSet->GetDataDescription(),150,90,110,PIE_PERCENTAGE,TRUE,50,20,5);  
		$Test->drawPieLegend(310,15,$DataSet->GetData(),$DataSet->GetDataDescription(),250,250,250);  
		 
		$Test->Stroke("example10.png");
		
		
	
	}


}


?>
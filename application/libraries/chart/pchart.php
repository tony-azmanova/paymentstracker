<?php

class Pchart
{
    public function __construct() // or any other method
    {
        require_once APPPATH.'third_party/chart/class/pData.class.php';
        require_once APPPATH.'third_party/chart/class/pDraw.class.php';
        require_once APPPATH.'third_party/chart/class/pImage.class.php';
    }
    function pData(){
        return new pData();    
    }
    function pImage($n,$i,$data=NULL,$trans=FALSE){
        return new pImage($n,$i,$data,$trans);
    }
} 

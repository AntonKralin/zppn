<?php 
	
	function parce_exel_file($filename){
		require_once dirname(__FILE__).'/Classes/PHPExcel.php';
		
		$result = array();
		
		//получаем тип файла (xls, xlsx), чтобы правильно его выбрать
		$file_type = PHPExcel_IOFactory::identify ($filename);
		
		$objReader = PHPExcel_IOFactory::createReader ($file_type);
		$objPHPExcel = $objReader->load( $filename );
		$result = $objPHPExcel->getActiveSheet()->toArray();
		
		return $result;
	}

?>
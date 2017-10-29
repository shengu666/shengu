<?php
namespace Home\Controller;
use Think\Controller;
Vendor('PHPExcel.PHPExcel');
Vendor('PHPExcel.PHPExcel.Writer.Excel2007');

class DaoChuExcelController extends Controller {
	public $res = [
                'code' => 1,
                'msg' => ''
        	];
    public function index(){
    	// 数字转字母
	    function getLetter($num) {
	        $str = "$num";
	        $num = intval($num);
	        if ($num <= 26){
	            $ret = chr(ord('A') + intval($str) - 1);
	        } else {
	            $first_str = chr(ord('A') + intval(floor($num / 26)) - 1);
	            $second_str = chr(ord('A') + intval($num % 26) - 1);
	            if ($num % 26 == 0){
	                $first_str = chr(ord('A') + intval(floor($num / 26)) - 2);
	                $second_str = chr(ord('A') + intval($num % 26) + 25);
	            }
	            $ret = $first_str.$second_str;
	        }
	        return $ret;
	    }
    }

    public function excelExport($data, $title=null, $name=null){
    	$PHPExcel = new \PHPExcel();
		if(!is_null($title)){
            array_unshift($data, $title);
        }
        
        if(is_null($name)){
            $name = time();
        }
            
        foreach ($data as $k => $v) {
            for ($i = 1; $i <= count($v); $i++){
                $tr = getLetter($i).($k+1);
                if ($value == null) {
                    $value = '';
                }
                $buffer[$tr]=array_values($v)[$i-1];
                $PHPExcel->getActiveSheet()->setCellValue($tr, array_values($v)[$i-1]);
            }        
        }
        
        $PHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.ms-excel'); 
        header('Content-Disposition: attachment;filename="' . $name . '.xls"'); //文件名称 
        header('Cache-Control: max-age=0');
        $result = PHPExcel_IOFactory::createWriter($PHPExcel, 'Excel2007');
        $result->save('php://output');
    }
}
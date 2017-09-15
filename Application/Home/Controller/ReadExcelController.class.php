<?php
namespace Home\Controller;
use Think\Controller;
Vendor('PHPExcel.PHPExcel');
Vendor('PHPExcel.PHPExcel.Writer.Excel2007');

class ReadExcelController extends Controller {
    public function index(){
    	$data = [];
    	$d = $this->init($this->readExcel(0),1);
    	//array_push($data,$this->init($this->readExcel(0),1));
    	/*$blog = M('blog');
    	$blogPro = M('blogproviders');
*/    	/*$blog->addAll($d[0]);
    	$blogPro->addAll($d[1]);*/
    	//array_push($data,$this->init($this->readExcel(1),2));
    	//array_push($data,$this->init($this->readExcel(2),3));
    	echo json_encode($d);
    }

    public function init($data,$type){
    	$item = [];
    	$item2 = [];
    	$result = [];
    	if($type == 1){				//微博
    		foreach ($data as $value) {
	    		$t['name'] = $value[0];
	    		$t['url'] = $value[1];
	    		$t['fans'] = $value[2];
	    		$t['type'] = $value[10];

	    		$d['firstPri'] = $value[3];
	    		$d['secondPri'] = $value[4];
	    		$d['proFirstPri'] = $value[5];
	    		$d['proSecondPri'] = $value[6];
	    		$d['disFirstPri'] = $value[5] * $value[9];
	    		$d['disSecondPri'] = $value[6] * $value[9];
	    		$d['discount'] = $value[9];
	    		$d['validTime'] = $value[11];
	    		$d['provider'] = $value[12];
	    		$d['note'] = $value[13];
	    		$d['pid'] = $value[0]."_".$value[12];
	    		array_push($item, $t);
	    		array_push($item2, $d);
	    	}
    	}else if($type == 2){		//微信
    		foreach ($data as $value) {
	    		$t['name'] = $value[0];
	    		$t['account'] = $value[1];
	    		$t['fans'] = $value[2];
	    		$t['firstReadNum'] = $value[3];
	    		$t['type'] = $value[13];
	    		
	    		$d['firstReadPri'] = $value[4];
	    		$d['secondReadPri'] = $value[5];
	    		$d['otherReadPri'] = $value[6];
	    		$d['disFirstReadPri'] = $value[4] * $value[10];
	    		$d['disSecondReadPri'] = $value[5] * $value[10];
	    		$d['disOtherReadPri'] = $value[6] * $value[10];
	    		$d['discount'] = $value[10];
	    		$d['publicNum'] = $value[11];
	    		$d['publicTime'] = $value[12];
	    		$d['validTime'] = $value[14];
	    		$d['provider'] = $value[15];
	    		$d['note'] = $value[16];
	    		$d['pid'] = $value[0]."_".$value[15];
	    		array_push($item, $t);
	    		array_push($item2, $d);
	    	}
    	}else if($type == 3){		//头条
	    	foreach ($data as $value) {
	    		$t['name'] = $value[0];
	    		$t['url'] = $value[1];
	    		$t['allReadNum'] = $value[2];
	    		$t['averReadNum'] = $value[3];
	    		$t['type'] = $value[7];
	    		
	    		$d['price'] = $value[4];
	    		$d['discountPrice'] = $value[4] * $value[6];
	    		$d['discount'] = $value[6];
	    		$d['validTime'] = $value[8];
	    		$d['provider'] = $value[9];
	    		$d['note'] = $value[10];
	    		$d['pid'] = $value[0]."_".$value[9];
	    		array_push($item, $t);
	    		array_push($item2, $d);
	    	}
    	}
    	array_push($result, $item);
    	array_push($result, $item2);
	    return $result;
    }

    public function readExcel($sheet){
    	$PHPExcel = new \PHPExcel();
		/**默认用excel2007读取excel，若格式不对，则用之前的版本进行读取*/
		$PHPReader = new \PHPExcel_Reader_Excel2007();
    	if(!$sheet){
    		$sheet = 0;
    	}

    	/**对excel里的日期进行格式转化*/
		

		$filePath = './Public/Uploads/test.xlsx';

		if(!$PHPReader->canRead($filePath)){
		    $PHPReader = new PHPExcel_Reader_Excel5();
		    if(!$PHPReader->canRead($filePath)){
		        echo 'no Excel';
		        return ;
		    }
		}

		$PHPExcel = $PHPReader->load($filePath);
		/**读取excel文件中的第一个工作表*/
		$currentSheet = $PHPExcel->getSheet($sheet);
		/**取得最大的列号*/
		$allColumn = $currentSheet->getHighestColumn();
		/**取得一共有多少行*/
		$allRow = $currentSheet->getHighestRow();
		/**从第二行开始输出，因为excel表中第一行为列名*/
		$data = [];
		for($currentRow = 2;$currentRow <= $allRow;$currentRow++){
		/**从第A列开始输出*/
			$item = [];
			for($currentColumn = 'A';$currentColumn <= $allColumn; $currentColumn++){
		    	$val = $currentSheet->getCellByColumnAndRow(ord($currentColumn) - 65,$currentRow)->getValue();/**ord()将字符转为十进制数*/
		    	/*if(empty($val)){
		    		break;
		    	}*/
		    	if($currentColumn == 'N'){
		    		break;
		    	}
		    	array_push($item, $val);
		    	/*if($currentColumn == 'A') {
		        	//echo date("Y-m-d H:i:s", PHPExcel_Shared_Date::ExcelToPHP($val));

				}*/
			}
			if(empty($item[0])){
		    	break;
		    }
			array_push($data, $item);
		}
		return $data;
    }
}
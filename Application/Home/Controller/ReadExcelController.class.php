<?php
namespace Home\Controller;
use Think\Controller;
Vendor('PHPExcel.PHPExcel');
Vendor('PHPExcel.PHPExcel.Writer.Excel2007');

class ReadExcelController extends Controller {
	public $res = [
                'data' => [
                        'list' => [],
                        'pageInfo' => [
                                'page' => 1,
                                'cost' => 0,
                                'pageSize' => 10
                        ],
                ],
                'code' => 1,
                'msg' => ''
        ];
    public function index(){
    	$res = $this->res;
    	$plat = $_GET['plat'];
    	$type = $_GET['type'];
    	$file = $_GET['file'];
    	$data = [];
    	
    	if($type == 0){
	    	if($plat == 'weibo'){
	    		$data = $this->init($this->readExcel(0,'N',$file),1);
	    	}else if($plat == 'weixin'){
	    		$data = $this->init($this->readExcel(0,'Q',$file),2);
	    	}else if($plat == 'toutiao'){
	    		$data = $this->init($this->readExcel(0,'K',$file),3);
	    	}

	    	if(count($data) == 0){
	            $res['code'] = 0;
	            $res['msg'] = '没有数据';
	            echo json_encode($res);
	            return;
	        }else{
	            $res['code'] = 1;
	            $res['data']['list'] = $data[2];         
	            $res['msg'] = 'success';
	            $res['plat'] = $plat;
	            echo json_encode($res);
	        }
    	}else if($type == 1){
    		if($plat == 'weibo'){
	    		$data = $this->init($this->readExcel(0,'N',$file),1);
	    		$M = M('blog');
		    	$P = M('blogproviders');
		    	$MD = "delete from blog where id not in (select id from (select max(b.id) as id from blog b group by b.name) b)";
		    	$PD = "delete from blogproviders where cid not in (select cid from (select max(b.cid) as cid from blogproviders b group by b.pid) b)";
	    	}else if($plat == 'weixin'){
	    		$data = $this->init($this->readExcel(0,'Q',$file),2);
	    		$M = M('wechat');
		    	$P = M('wechatproviders');

		    	$MD = "delete from wechat where id not in (select id from (select max(b.id) as id from wechat b group by b.name) b)";
		    	$PD = "delete from wechatproviders where cid not in (select cid from (select max(b.cid) as cid from wechatproviders b group by b.pid) b)";
	    	}else if($plat == 'toutiao'){
	    		$data = $this->init($this->readExcel(0,'K',$file),3);
	    		$M = M('toutiao');
		    	$P = M('toutiaoproviders');

		    	$MD = "delete from toutiao where id not in (select id from (select max(b.id) as id from toutiao b group by b.name) b)";
		    	$PD = "delete from toutiaoproviders where cid not in (select cid from (select max(b.cid) as cid from toutiaoproviders b group by b.pid) b)";
	    	}
	    	$M->startTrans();	//开启事务
	    	try{
		    	$result1 = $M->addAll($data[0]);
		    	$result2 = $P->addAll($data[1]);
		    	$result3 = $M->execute($MD);
		    	$result4 = $P->execute($PD);
		    	if($result1 >= 0 && $result2 >= 0 && $result3 >= 0 && $result4 >= 0){
		    		$M->commit();
		    		$res['code'] = 1;
		    		$res['msg'] = 'success';
		    		echo json_encode($res);
		    	}else{
		    		$M->rollback();
		    		$res['code'] = 0;
		    		$res['msg'] = '数据库写入失败';
		    		echo json_encode($res);
		    	}
	    	}catch(\Exception $e){
	    		$res['code'] = -1;
	    		$res['msg'] = '数据有误，请检查。注意：excel请用微软雅黑字体。';
	    		echo json_encode($res);
	    	}


    	}

    }

    public function init($data,$type){
    	$item = [];
    	$item2 = [];
    	$item3 = [];
    	$result = [];
    	if($type == 1){				//微博
    		foreach ($data as $value) {
	    		$t['name'] = $value[0];
	    		$t['url'] = $value[1];
	    		$t['fans'] = $value[2];
	    		$t['type'] = $value[10];

	    		$d['firstpri'] = $value[3];
	    		$d['secondpri'] = $value[4];
	    		$d['profirstpri'] = $value[5];
	    		$d['prosecondpri'] = $value[6];
	    		$d['disfirstpri'] = $value[5] * $value[9];
	    		$d['dissecondpri'] = $value[6] * $value[9];
	    		$d['discount'] = $value[9];
	    		$d['validtime'] = $value[11];
	    		$d['provider'] = $value[12];
	    		$d['note'] = $value[13];
	    		$d['pid'] = $value[0]."_".$value[12];
	    		$d['fid'] = $value[0];
	    		array_push($item, $t);
	    		array_push($item2, $d);
	    		array_push($item3, array_merge($t,$d));
	    	}
    	}else if($type == 2){		//微信
    		foreach ($data as $value) {
	    		$t['name'] = $value[0];
	    		$t['account'] = $value[1];
	    		$t['fans'] = $value[2];
	    		$t['firstreadnum'] = $value[3];
	    		$t['type'] = $value[13];
	    		
	    		$d['firstreadpri'] = $value[4];
	    		$d['secondreadpri'] = $value[5];
	    		$d['otherreadpri'] = $value[5] * 0.8;
	    		$d['disfirstreadpri'] = $value[4] * $value[10];
	    		$d['dissecondreadpri'] = $value[5] * $value[10];
	    		$d['disotherreadpri'] = $value[5] * 0.8 * $value[10];
	    		$d['discount'] = $value[10];
	    		$d['publicnum'] = $value[11];
	    		$d['publictime'] = $value[12];
	    		$d['validtime'] = $value[14];
	    		$d['provider'] = $value[15];
	    		$d['note'] = $value[16];
	    		$d['pid'] = $value[0]."_".$value[15];
	    		$d['fid'] = $value[0];
	    		array_push($item, $t);
	    		array_push($item2, $d);
	    		array_push($item3, array_merge($t,$d));
	    	}
    	}else if($type == 3){		//头条
	    	foreach ($data as $value) {
	    		$t['name'] = $value[0];
	    		$t['url'] = $value[1];
	    		$t['allreadnum'] = $value[2];
	    		$t['averreadnum'] = $value[3];
	    		$t['type'] = $value[7];
	    		
	    		$d['price'] = $value[4];
	    		$d['discountprice'] = $value[4] * $value[6];
	    		$d['discount'] = $value[6];
	    		$d['validtime'] = $value[8];
	    		$d['provider'] = $value[9];
	    		$d['note'] = $value[10];
	    		$d['pid'] = $value[0]."_".$value[9];
	    		$d['fid'] = $value[0];
	    		array_push($item, $t);
	    		array_push($item2, $d);
	    		array_push($item3, array_merge($t,$d));
	    	}
    	}
    	array_push($result, $item);
    	array_push($result, $item2);
    	array_push($result, $item3);
	    return $result;
    }

    public function readExcel($sheet,$end,$file){
    	$PHPExcel = new \PHPExcel();
		/**默认用excel2007读取excel，若格式不对，则用之前的版本进行读取*/
		$PHPReader = new \PHPExcel_Reader_Excel2007();
    	if(!$sheet){
    		$sheet = 0;
    	}
		
		$filePath = "./Public/Uploads/".$file;

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
		    	if($currentColumn == $end){
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
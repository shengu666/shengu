<?php
namespace Home\Controller;
use Think\Controller;
Vendor('PHPExcel.PHPExcel');
Vendor('PHPExcel.PHPExcel.Writer.Excel2007');

class ExportExcelController extends Controller {
    public $res = [
                'code' => 1,
                'msg' => ''
            ];
    public function index(){
        $plat = $_GET['plat'];
        $price = $_GET['price'];
        $time = $_GET['time'];
        $user = $_GET['user'];

        $where = "";

        if($plat && $plat != "all"){
            $where .= " and plat = '".$plat."'";
        }
        if($user && $user != "all"){
            $where .= " and user = '".$user."'";
        }
        if($price && $price != "all"){
            $pnum = explode('a', $price);
            if($pnum[1] == "inify"){
                $where .= " and pay > ".$pnum[0];
            }else{
                $where .= " and pay > ".$pnum[0]." and pay < ".$pnum[1];
            }
        }
        if($time && $time != "all"){
            preg_match('/\d+/',$time,$item);
            if(preg_match('/y/',$time)){
                $time = strtotime("-".$item[0]." year");
            }else if(preg_match('/m/',$time)){
                $time = strtotime("-".$item[0]." month");
            }else if(preg_match('/d/',$time)){
                $time = strtotime("-".$item[0]." day");
            }
            $where .= " and time > '".$time."'";
        }
        $M = M('shopcar');
        $sql = "select * from shopcar where status=2 ".$where." order by time desc";
        $list = M()->query($sql);
        $data = [];
        foreach ($list as $key => $value) {
            $item = [];
            $item['proj'] = $value['proj'];
            $item['oid'] = $value['oid']." ";
            $item['mid'] = $value['mid'];
            $item['mid'] = $value['mid'];
            $item['plat'] = $value['plat'];
            $item['time'] = date("Y-m-d",$value['time']);
            $item['url'] = $value['url'];
            $item['actype'] = $value['actype'];
            $item['endprice'] = $value['endprice'];
            $item['pay'] = $value['pay'];
            $item['discount'] = $value['discount'];
            $item['ispay'] = $value['ispay'];
            array_push($data, $item);
        }
        $title = [
                    "proj"=>"项目名称",
                    "oid"=>"采购ID",
                    "mid"=>"账号名称",
                    "mid"=>"账号ID",
                    "plat"=>"平台",
                    "time"=>"发布时间",
                    "url"=>"发布链接",
                    "actype"=>"活动类型",
                    "endprice"=>"报价",
                    "pay"=>"成交价",
                    "discount"=>"折扣",
                    "ispay"=>"支付状况"
                ];
        $name = "订单_".date("Ymd",time());
        $this->excelExport($data,$title,$name);
        exit();
    }

    // 数字转字母
    public function getLetter($num) {
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
                $tr = $this->getLetter($i).($k+1);
                if ($value == null) {
                    $value = '';
                }
                $buffer[$tr]=array_values($v)[$i-1];
                $PHPExcel->getActiveSheet()->setCellValue($tr, array_values($v)[$i-1]);
            }        
        }
        
        $PHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.ms-excel'); 
        header('Content-Disposition: attachment;filename="' . $name . '.xlsx"'); //文件名称 
        header('Cache-Control: max-age=0');
        $result = \PHPExcel_IOFactory::createWriter($PHPExcel, 'Excel2007');
        $result->save('php://output');
    }
}
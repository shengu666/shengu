<?php
namespace Home\Controller;
use Think\Controller;

class AddCarController extends Controller {
	public $res = [
                'code' => 1,
                'msg' => ''
            ];
    public function index(){
        $res = $this->res;
        $data = [];
        $list = $_POST['list'];
        $user = cookie('shengu_user');
        $time = time();
        $oid = date("Ymd",time()).rand(1000,9999);
        if(count($list) > 0){
            $item = [];
            $M = M('shopcar');
            foreach ($list as $key => $value) {
                $item['user'] = $user;
                $item['time'] = $time;
                $item['status'] = 1;
                $item['mid'] = $value['name'];
                $item['pid'] = $value['pid'];
                $item['plat'] = $value['plat'];
                $item['ispay'] = 0;
                $item['actype'] = "直发";
                $item['oid'] = $oid;
                $item['provider'] = $value['provider'];
                $item['endprice'] = $value['endprice'];
                $item['url'] = $value['url'];
                $item['pay'] = $value['endprice'];
                $item['discount'] = $value['discount'];
                array_push($data, $item);
            }
            $result = $M->addAll($data);
            if($result){
                $res['code'] = 1;
                $res['msg'] = 'success';
                echo json_encode($res);
                exit; 
            }else{
                $res['code'] = 0;
                $res['msg'] = '失败';
                echo json_encode($res);
                exit;
            }
        }else{
            $res['code'] = 0;
            $res['msg'] = '失败';
            echo json_encode($res);
            exit;
        }
        if($result){
            $res['code'] = 1;                     
            $res['msg'] = 'success';
            echo json_encode($res);
            exit;
        }else{
            $res['code'] = 0;
            $res['msg'] = '失败';
            echo json_encode($res);
            exit;
        }
    }
}
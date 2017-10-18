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
        $user = M('shopcar');
        $list = $_POST['list'];
        if(count($list) > 0){
            $item = [];
            $user = M('shopcar');
            $time = time();
            /*foreach ($list as $key => $value) {
                if($value['pid'] && $value['plat']){
                    $item['user'] = "root";
                    $item['goods'] = $value['pid'];
                    $item['time'] = $time;
                    $item['status'] = 1;
                    $item['type'] = $value['plat'];
                    array_push($data, $item);
                }
            }*/
            $data['user'] = cookie('shengu_user');
            $data['time'] = time();
            $data['status'] = 1;
            $data['goods'] = json_encode($list);
            $result = $user->add($data);
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
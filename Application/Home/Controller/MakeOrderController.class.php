<?php
namespace Home\Controller;
use Think\Controller;

class MakeOrderController extends Controller {
	public $res = [
                'code' => 1,
                'msg' => ''
            ];
    public function index(){
        $res = $this->res;
        $data = [];

        if($_POST['oid'] && $_POST['proj']){
            $M = M('shopcar');
            $id['oid'] = $_POST['oid'];
            $data['proj'] = $_POST['proj'];
            $data['status'] = 2;
            $result = $M->where($id)->save($data);
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
    }
}
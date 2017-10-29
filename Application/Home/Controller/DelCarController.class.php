<?php
namespace Home\Controller;
use Think\Controller;

class DelCarController extends Controller {
	public $res = [
                'code' => 1,
                'msg' => ''
            ];
    public function index(){
        $res = $this->res;
        $data = [];  

        if($_POST['oid']){
            $M = M('shopcar');
            $oid['oid'] = $_POST['oid'];
            $result = $M->where($oid)->delete();
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
<?php
namespace Home\Controller;
use Think\Controller;

class ProjListController extends Controller {
	public $res = [
                'code' => 1,
                'msg' => ''
            ];
    public function index(){
        $res = $this->res;

        $M = M('proj');
        $where['status'] = 1;
        $result = $M->where($where)->select();

        if($result){
            $res['code'] = 1;                     
            $res['msg'] = 'success';
            $res['data'] = $result;
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
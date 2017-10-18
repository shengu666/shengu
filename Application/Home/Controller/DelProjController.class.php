<?php
namespace Home\Controller;
use Think\Controller;

class DelProjController extends Controller {
	public $res = [
                'code' => 1,
                'msg' => ''
            ];
    public function index(){
        $res = $this->res;
        $data = [];
        if($_POST['name']){
            $M = M('proj');
            $where['name'] = $_POST['name'];
            $data['status'] = "-1";
            $result = $M->where($where)->save($data);
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
}
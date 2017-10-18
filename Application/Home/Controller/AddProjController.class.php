<?php
namespace Home\Controller;
use Think\Controller;

class AddProjController extends Controller {
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
            $d = $M->where($where)->select();
            if(!$d){
                $data['name'] = $_POST['name'];
                $data['status'] = 1;
                $data['time'] = time();
                $data['user'] = cookie("shengu_user");
                $result = $M->add($data);
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
                $res['msg'] = '项目名已存在';
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
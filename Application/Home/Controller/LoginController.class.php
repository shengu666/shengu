<?php
namespace Home\Controller;
use Think\Controller;

class LoginController extends Controller {
    public $res = [
                'status' => '',
                'data' => [
                    'code' => 1,
                    'info' => [
                        'userName' => '',
                        'passWord' => '',
                        'type' => ''
                ],
                'msg' => ''
                ]
            ];
    public function index(){
        $res = $this->res;
        $user = M('User');
    	$item = $_POST;
        $data['user'] = $item['user'];
        $a = $user->where($data)->select(); 
        if(count($a) == 0){
            $res['data']['code'] = 0;
            $res['msg'] = '用户名不存在';
            echo json_encode($res);
            return;
        }
    	if($a[0]['pswd'] == $item['pswd']){
            $res['data']['code'] = 1;
            $res['msg'] = '登录成功';
        }else{
            $res['data']['code'] = 0;
            $res['msg'] = '密码错误！';
        }
           	
    	echo json_encode($res);
    }
}
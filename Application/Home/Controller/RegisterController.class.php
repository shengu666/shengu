<?php
namespace Home\Controller;
use Think\Controller;

class RegisterController extends Controller {
    public function index(){
    	$item = $_POST;
        $res = [
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
        $item = [
            'user' => $item['user'],
            'pass' => $item['pswd']
        ];
        $data = [
            ['id' => 1,
            'user' => 'root',
            'pass' => md5("root"),
            'time' => time(),
            'type' => 1],
            ['id' => 2,
            'user' => 'user1',
            'pass' => md5("user1"),
            'time' => time(),
            'type' => 2],
            ['id' => 3,
            'user' => 'user2',
            'pass' => md5("user2"),
            'time' => time(),
            'type' => 2],
        ];
        for($i=0;$i<count($data);$i++){
            if($data[$i]['user'] == $item['user']){
                $res['data']['code'] = 0;
                $res['msg'] = '用户名已存在！';
                break;
            }else{
                $res['data']['code'] = 1;
                $res['msg'] = '注册成功';
            }
        }
        echo json_encode($res);
    }
}
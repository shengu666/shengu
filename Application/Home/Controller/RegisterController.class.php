<?php
namespace Home\Controller;
use Home\Controller\MiddleController;

class RegisterController extends MiddleController {
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
        $item = $_POST;
        $res = $this->res;
        $user = M('user');
        $username = $user->where("user='%s'",$item['user'])->select();

        if(count($username) > 0){
            $res['data']['code'] = 0;
            $res['msg'] = '用户名已存在！';
            echo json_encode($res);
            return;
        }

        $data['user'] = $item['user'];
        $data['pswd'] = $item['pswd'];
        $data['time'] = time();
        $data['type'] = 2;
        $data['checked'] = 0;
        $result = $user->add($data);

        if($result > 0){
            $res['data']['code'] = 1;
            $res['data']['info']['type'] = 2;
            $res['data']['info']['checked'] = 0;
            $res['msg'] = '注册成功,等待审核';
        }else{
            $res['data']['code'] = 0;
            $res['msg'] = '注册失败！';
        }

        echo json_encode($res);
    }
}
<?php
namespace Home\Controller;
use Think\Controller;

class LoginController extends Controller {
    public $res = [
                'status' => '',
                'data' => [
                    'code' => 1,
                    'info' => [
                        'user' => '',
                        'pswd' => '',
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
        $result = $user->where($data)->select(); 
        if(!$result){
            $res['data']['code'] = 0;
            $res['msg'] = '用户名不存在';
            exit(json_encode($res));
        }
    	if($result[0]['pswd'] == $item['pswd']){
            if($result[0]['checked'] == 1){
                $res['data']['code'] = 1;
                $res['data']['info']['user'] = $result[0]['user'];
                $res['data']['info']['pswd'] = $result[0]['pswd'];
                $res['data']['info']['type'] = $result[0]['type'];
                $res['msg'] = '登录成功';

                session("shengu_user",'');
                cookie("shengu_user",'');
                cookie("shengu_pswd",'');

                session("shengu_user",$item['user']);
                cookie("shengu_user",$item['user']);
                cookie("shengu_pswd",$item['pswd']);
            }else{
                $res['data']['code'] = 0;
                $res['msg'] = '账户暂未通过审核！';
            }
        }else{
            $res['data']['code'] = 0;
            $res['msg'] = '密码错误！';
        }
    	exit(json_encode($res));
    }
}
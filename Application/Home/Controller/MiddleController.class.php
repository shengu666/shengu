<?php
namespace Home\Controller;
use Think\Controller;

class MiddleController extends Controller {
    public function __construct(){	//覆盖了父类构造函数
        $res = [
                'code' => -1,
                'msg' => '失败'
        ];
    	parent::__construct();
        if(session('?shengu_user')){
            if(cookie('shengu_user') && cookie('shengu_pswd')){
                $user = M('User');
                $data['user'] = cookie('shengu_user');
                $data['pswd'] = cookie('shengu_pswd');
                $result = $user->where($data)->select();
                if($result){
                    
                }else{
                    exit(json_encode($res));
                }
            }else{
                exit(json_encode($res));
            }
        }else{
            exit(json_encode($res));
        }
    }
}
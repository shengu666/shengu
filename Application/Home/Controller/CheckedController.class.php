<?php
namespace Home\Controller;
use Think\Controller;

class CheckedController extends Controller {
	public $res = [
                'code' => 1,
                'msg' => ''
        ];
    public function index(){
        $res = $this->res;
        $user = $_POST['user'];
        $type = $_POST['type'];

        if(strlen($user) > 0){
            $M = M('user');
            if($type == 1){
                $sel_sql = "select * from user where user = '".$user."'";
                $sel = M()->query($sel_sql);
                if(count($sel) > 0){
                    $checked['checked'] = 1;
                    $result = $M->where("user='%s'",$user)->save($checked);
                    if($result){
                        $res['code'] = 1;
                        $res['msg'] = 'success';    
                        echo json_encode($res);
                    }else{
                        $res['code'] = 0;
                        $res['msg'] = '失败';    
                        echo json_encode($res);
                    }
                }else{
                    return;
                }
            }else
                $result = $M->where("user='%s'",$user)->delete();
                if($result){
                    $res['code'] = 1;
                    $res['msg'] = 'success';    
                    echo json_encode($res);
                }else{
                    $res['code'] = 0;
                    $res['msg'] = '失败';    
                    echo json_encode($res);
                }
            }
        }else{
            return;
        }

    }
}
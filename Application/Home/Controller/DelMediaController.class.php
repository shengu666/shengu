<?php
namespace Home\Controller;
use Think\Controller;

class DelMediaController extends Controller {
	public $res = [
                'code' => 1,
                'msg' => ''
            ];
    public function index(){
        $res = $this->res;
        if($_POST['plat'] && strlen($_POST['plat']) > 0){
            $plat = $_POST['plat'];
            $item['pid'] = $_POST['pid'];
            if($item['pid'] && strlen($item['pid']) > 0){
                if($plat == 'weibo'){
                    //$M = M('blog');
                    $P = M('blogproviders');
                }else if($plat == 'weixin'){
                    //$M = M('wechat');
                    $P = M('wechatproviders');
                }else if($plat == 'toutiao'){
                    //$M = M('toutiao');
                    $P = M('toutiaoproviders');
                }
                $result = $P->where($item)->delete();
                if($result){
                    $res['code'] = 1;
                    $res['msg'] = 'success';
                    echo json_encode($res);
                }else{
                    $res['code'] = 0;
                    $res['msg'] = '删除失败';
                    echo json_encode($res);
                }
            }else{
               exit; 
            }
        }else{
            exit;
        }
    }
}
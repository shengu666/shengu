<?php
namespace Home\Controller;
use Think\Controller;

class CarListController extends Controller {
	public $res = [
                'data' => [
                        'list' => [],
                ],
                'code' => 1,
                'msg' => ''
        ];
    public function index(){
        $res = $this->res;
        cookie('shengu_user','root');
        if(cookie('shengu_user')){
            $item['user'] = cookie('shengu_user');
            $M = M('shopcar');
            $data = $M->where($item)->order('id desc')->select();
        }
        if(count($data) == 0){
            $res['code'] = 0;
            $res['msg'] = '没有数据';
            echo json_encode($res);
            exit;
        }else{
            $res['code'] = 1;        
            $res['data']['list'] = $data;                            
            $res['msg'] = 'success';
            echo json_encode($res);
            exit;
        }
    }
}

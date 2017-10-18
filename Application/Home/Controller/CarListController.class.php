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
        if(cookie('shengu_user')){
            $item['user'] = cookie('shengu_user');
            //$item['status'] = 1;
            $M = M('shopcar');
            $data = $M->where("status != -1")->order('id desc')->select();
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

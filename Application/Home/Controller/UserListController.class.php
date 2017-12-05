<?php
namespace Home\Controller;
use Think\Controller;

class UserListController extends Controller {
	public $res = [
                'data' => [
                        'list' => [],
                        'pageInfo' => [
                                'page' => 1,
                                'cost' => 0,
                                'pageSize' => 10
                        ],
                ],
                'code' => 1,
                'msg' => ''
        ];
    public function index(){
        $res = $this->res;
        $user_sql = "select user,time,type,checked from user order by id desc";
        $data = M()->query($user_sql);
        foreach ($data as $key=>$value) {
            $data[$key]['time'] = date('Y/m/d',$value['time']);
        }
            
        if(count($data) == 0){
            $res['code'] = 0;
            $res['msg'] = '没有数据';
            echo json_encode($res);
            return;
        }else{
            if($_GET['page']){
                $page = $_GET['page'];
                $pageItem = ($page - 1) * 10;
            }else{
                $page = 1;
                $pageItem = 0;
            }
            $res['code'] = 1;
            $res['data']['list'] = array_slice($data,$pageItem,10);            
            $res['data']['pageInfo']['page'] = $page;            
            $res['data']['pageInfo']['cost'] = count($data);            
            $res['msg'] = 'success';
            echo json_encode($res);
        }
    }
}
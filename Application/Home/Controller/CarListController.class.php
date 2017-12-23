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
            $M = M('shopcar');
            $sql = "select * from shopcar where status=1 group by oid order by time desc";
            $words = M()->query($sql);
            $list = $M->where("status = 1")->select();
            $data = [];
            foreach ($words as $key => $value) {
                $item['oid'] = $value['oid'];
                $item['user'] = $value['user'];
                $item['time'] = $value['time'];
                $item['children'] = [];
                foreach ($list as $key2 => $value2) {
                    if($value['oid'] == $value2['oid']){
                        array_push($item['children'], $value2);
                    }
                }
                array_push($data, $item);
            }

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

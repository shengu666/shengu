<?php
namespace Home\Controller;
use Think\Controller;

class ListController extends Controller {
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
    	$model = M('blog');
    	$sql = "select * from blog a,blogproviders b where b.pid like concat('%',a.name,'_%') group by a.name order by a.fans desc,b.disFirstPri asc";
    	$a = M()->query($sql);
    	//$list = $model->order('fans desc')->limit(20)->select();

    	var_dump($a);


    	// /echo json_encode($res);
    }
}
/*	select * from blog a,blogproviders b where b.pid like concat('%',a.name) group by a.name order by a.fans desc,b.disFirstPri asc;*/
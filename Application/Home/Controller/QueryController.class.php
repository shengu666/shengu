<?php
namespace Home\Controller;
use Think\Controller;

class QueryController extends Controller {
    public $res = [
                'data' => [
                        'list' => [],
                ],
                'code' => 1,
                'msg' => ''
        ];
    public function index(){
        $res = $this->res;
        $_GET['plat'] = ['ss'];
        if(count($_GET['plat']) > 0){
            $plat = $_GET['plat'];
            $name = $_GET['name'];
            $name = '娱';
            $plat = 'weibo';
            $where = "";

            if(strlen($name) > 0){
                $where .= " name like concat('%','".$name."','%') ";
            }else{
                return;
            }

            if($plat == 'weibo'){
                $blog_sql = "select name from blog where ".$where." order by id desc";
                
                $data = M()->query($blog_sql);
            }else if($plat == 'weixin'){
                $wechat_sql = "select name from wechat where ".$where." order by id desc";
                $data = M()->query($wechat_sql);
            }else if($plat == 'toutiao'){
                $toutiao_sql = "select name from toutiao where ".$where." order by id desc";
                $data = M()->query($toutiao_sql);
            }
        }else{
            return;
        }
        if(count($data) == 0){
            $res['code'] = 0;
            $res['msg'] = '没有数据';
            echo json_encode($res);
        }else{
            $res['code'] = 1;
            $res['data']['list'] = $data;                     
            $res['msg'] = 'success';
            echo json_encode($res);
        }
    }
}
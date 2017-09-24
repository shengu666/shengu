<?php
namespace Home\Controller;
use Think\Controller;

class SingleController extends Controller {
	public $res = [
                'data' => [
                    'list' => [],
                ],
                'code' => 1,
                'msg' => ''
        ];
    public function index(){
        $res = $this->res;
        $data = [];
        if(count($_GET['plat']) > 0){
            $plat = $_GET['plat'];
            $name = $_GET['name'];
            $provider = $_GET['provider'];
            if($name && strlen($name) > 0){
                if($plat == 'weibo'){
                    $blog_sql = "select * from blog a,blogproviders b where a.name='".$name."' and b.pid like concat('%','".$name."','_%') group by b.pid order by b.disFirstPri asc";
                    $data = M()->query($blog_sql);
                }else if($plat == 'weixin'){
                    $wechat_sql = "select * from wechat a,wechatproviders b where a.name='".$name."' and b.pid like concat('%','".$name."','_%') group by b.pid order by b.disFirstReadPri asc";
                    $data = M()->query($wechat_sql);
                }else if($plat == 'toutiao'){
                    $toutiao_sql = "select * from toutiao a,toutiaoproviders b where a.name='".$name."' and b.pid like concat('%','".$name."','_%') group by b.pid order by b.discountPrice asc";
                    $data = M()->query($toutiao_sql);
                }
                foreach ($data as $key=>$value) {
                    if($value['provider'] == $provider){
                        array_splice($data,$key,1); 
                    }
                }
            }
        }else{
            return;
        }
        if(count($data) == 0){
            $res['code'] = 0;
            $res['msg'] = '没有数据';
            echo json_encode($res);
            return;
        }else{
            $res['code'] = 1;
            $res['data']['list'] = $data;                     
            $res['msg'] = 'success';
            echo json_encode($res);
        }
    }
}
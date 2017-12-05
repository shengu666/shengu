<?php
namespace Home\Controller;
use Think\Controller;
use Home\Controller\MiddleController;

class List2Controller extends MiddleController {
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
        if($_GET['page']){
            $page = $_GET['page'];
            $pageItem = ($page - 1) * 10;
        }else{
            $page = 1;
            $pageItem = 0;
        }
        if(count($_GET['plat']) > 0){
            $plat = $_GET['plat'];
            $chlid = $_GET['chlid'];
            $price = $_GET['price'];
            $weight = $_GET['weight'];
            $name = $_GET['name'];

            /*$plat = 'weixin';
            $chlid = '娱评人';
            $price = '0a3500';
            $weight = '0a100';*/
            $where = "";

            if($chlid && $chlid != "all"){
                $where .= " and type = '".$chlid."'";
            }
            if($name && $name != 'all'){
                $where .= " and a.name like concat('%','".$name."','%') ";
            }

            if($plat == 'weibo'){
                if($price && $price != "all"){
                    $pnum = explode('a', $price);
                    if($pnum[1] == "inify"){
                        $where .= " and disFirstPri > ".$pnum[0];
                    }else{
                        $where .= " and disFirstPri > ".$pnum[0]." and disFirstPri < ".$pnum[1];
                    }
                }
                if($weight && $weight != "all"){
                    $wnum = explode('a', $weight);
                    if($wnum[1] == 'max'){
                        $where .= " and fans > ".$wnum[0];
                    }else{
                        $where .= " and fans > ".$wnum[0]." and fans < ".$wnum[1];
                    }
                }

                $blog_sql = "select * from temp a,blogproviders b where b.disFirstPri = (select min(c.disFirstPri) from blogproviders c where c.pid like concat('%',a.name,'_%')) and b.pid like concat('%',a.name,'_%') ".$where." group by a.name order by a.id desc limit ".$pageItem.",10";
                $count_sql = "select count(*) as num from (select * from blog a,blogproviders b where b.disFirstPri = (select min(c.disFirstPri) from blogproviders c where c.pid like concat('%',a.name,'_%')) and b.pid like concat('%',a.name,'_%') ".$where." group by a.name) num";
                $temp = "CREATE TEMPORARY TABLE temp select * from blog order by id desc limit ".$pageItem.",10";
                M()->execute($temp);
                $data = M()->query($blog_sql);
                $count = M()->query($count_sql);
            }else if($plat == 'weixin'){
                if($price && $price != "all"){
                    $pnum = explode('a', $price);
                    if($pnum[1] == "inify"){
                        $where .= " and disFirstReadPri > ".$pnum[0];
                    }else{
                        $where .= " and disFirstReadPri > ".$pnum[0]." and disFirstReadPri < ".$pnum[1];
                    }
                }
                if($weight && $weight != "all"){
                    $wnum = explode('a', $weight);
                    if($wnum[1] == 'max'){
                        $where .= " and fans > ".$wnum[0];
                    }else{
                        $where .= " and fans > ".$wnum[0]." and fans < ".$wnum[1];
                    }
                }

                $wechat_sql = "select * from temp a,wechatproviders b where b.disFirstReadPri = (select min(c.disFirstReadPri) from wechatproviders c where c.pid like concat('%',a.name,'_%')) and b.pid like concat('%',a.name,'_%') ".$where." group by a.name order by a.id desc limit ".$pageItem.",10";
                $count_sql = "select count(*) as num from (select * from wechat a,wechatproviders b where b.disFirstReadPri = (select min(c.disFirstReadPri) from wechatproviders c where c.pid like concat('%',a.name,'_%')) and b.pid like concat('%',a.name,'_%') ".$where." group by a.name) num";
                $temp = "CREATE TEMPORARY TABLE temp select * from blog order by id desc limit ".$pageItem.",10";
                M()->execute($temp);
                $data = M()->query($wechat_sql);
                $count = M()->query($count_sql);
            }else if($plat == 'toutiao'){
                if($price && $price != "all"){
                    $pnum = explode('a', $price);
                    if($pnum[1] == "inify"){
                        $where .= " and discountPrice > ".$pnum[0];
                    }else{
                        $where .= " and discountPrice > ".$pnum[0]." and discountPrice < ".$pnum[1];
                    }
                }
                if($weight && $weight != "all"){
                    $wnum = explode('a', $weight);
                    if($wnum[1] == 'max'){
                        $where .= " and averReadNum > ".$wnum[0];
                    }else{
                        $where .= " and averReadNum > ".$wnum[0]." and averReadNum < ".$wnum[1];
                    }
                    $where .= " and averReadNum > ".$wnum[0]." and averReadNum < ".$wnum[1];
                }

                $toutiao_sql = "select * from temp a,toutiaoproviders b where b.discountPrice = (select min(c.discountPrice) from toutiaoproviders c where c.pid like concat('%',a.name,'_%')) and b.pid like concat('%',a.name,'_%') ".$where." group by a.name order by a.id desc limit ".$pageItem.",10";
                $count_sql = "select count(*) as num from (select * from toutiao a,toutiaoproviders b where b.discountPrice = (select min(c.discountPrice) from toutiaoproviders c where c.pid like concat('%',a.name,'_%')) and b.pid like concat('%',a.name,'_%') ".$where." group by a.name) num";
                $temp = "CREATE TEMPORARY TABLE temp select * from blog order by id desc limit ".$pageItem.",10";
                M()->execute($temp);
                $data = M()->query($toutiao_sql);
                $count = M()->query($count_sql);
            }
        }else{
            $blog_sql = "select * from temp a,blogproviders b where b.disFirstPri = (select min(c.disFirstPri) from blogproviders c where c.pid like concat('%',a.name,'_%')) and b.pid like concat('%',a.name,'_%') group by a.name";
            $count_sql = "select count(*) as num from blog";
            $temp = "CREATE TEMPORARY TABLE temp select * from blog order by id desc limit ".$pageItem.",10";
            M()->execute($temp);

            $data = M()->query($blog_sql);
            $count = M()->query($count_sql);
            $plat = "weibo";
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
            foreach ($data as $key => $value) {
                $data[$key]['plat'] = $plat;
                if($plat == "weibo"){
                    $data[$key]['endprice'] = $value['disfirstpri'];
                }else if($plat == "wexin"){
                    $data[$key]['endprice'] = $value['disfirstreadpri'];
                }else if($plat == "toutiao"){
                    $data[$key]['endprice'] = $value['discountprice'];
                }
            }
            $res['code'] = 1;        
            $res['data']['list'] = $data;            
            $res['data']['pageInfo']['page'] = intval($page);            
            $res['data']['pageInfo']['cost'] = intval($count[0]['num']);            
            $res['msg'] = 'success';
            echo json_encode($res);
        }
    }
}


//delete from blog where id not in (select id from(select max(b.id) as id from blog b group by b.name) b);
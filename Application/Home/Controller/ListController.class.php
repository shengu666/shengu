<?php
namespace Home\Controller;
use Think\Controller;
use Home\Controller\MiddleController;

class ListController extends MiddleController {
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

            $whereC = "";
            $whereF = "";
            $wf = [];
            $wc = [];

            if($chlid && $chlid != "all"){
                array_push($wf,"type = '".$chlid."'");
            }
            if($name && $name != 'all'){
                array_push($wf,"name like concat('%','".$name."','%')");
            }
            if($wf){
                $whereF = " where ".implode(' and ',$wf);
            }

            if($plat == 'weibo'){
                if($price && $price != "all"){
                    $pnum = explode('a', $price);
                    if($pnum[1] == "inify"){
                        array_push($wc,"disFirstPri > ".$pnum[0]);
                    }else{
                        array_push($wc,"disFirstPri > ".$pnum[0]." and disFirstPri < ".$pnum[1]);
                    }
                }
                if($weight && $weight != "all"){
                    $wnum = explode('a', $weight);
                    if($wnum[1] == 'inify'){
                        array_push($wf,"fans > ".$wnum[0]);
                    }else{
                        array_push($wf,"fans > ".$wnum[0]." and fans < ".$wnum[1]);
                    }
                }
                if($wc){
                    $whereC = ' where '.implode(' and ',$wc);
                }
                if($wf){
                    $whereF = " where ".implode(' and ',$wf);
                }

                $blog_sql = "select SQL_CALC_FOUND_ROWS * from temp a,temp2 b where a.name = b.fid order by a.id desc limit ".$pageItem.",10";

                $temp = "CREATE TEMPORARY TABLE temp select * from blog ".$whereF;  
                $temp2 = "CREATE TEMPORARY TABLE temp2 select min(disfirstpri) minpri,fid,firstpri,secondpri,profirstpri,prosecondpri,disfirstpri,dissecondpri,discount,validtime,provider,note,pid,updatetime from blogproviders ".$whereC." group by fid";
                M()->execute($temp);
                M()->execute($temp2);
                $data = M()->query($blog_sql);
                $count = M()->query("select FOUND_ROWS() num");
                //$count = M()->query($count_sql);
            }else if($plat == 'weixin'){
                if($price && $price != "all"){
                    $pnum = explode('a', $price);
                    if($pnum[1] == "inify"){
                        array_push($wc,"disFirstReadPri > ".$pnum[0]);
                    }else{
                        array_push($wc,"disFirstReadPri > ".$pnum[0]." and disFirstReadPri < ".$pnum[1]);
                    }
                }
                if($weight && $weight != "all"){
                    $wnum = explode('a', $weight);
                    if($wnum[1] == 'inify'){
                        array_push($wf,"fans > ".$wnum[0]);
                    }else{
                        array_push($wf,"fans > ".$wnum[0]." and fans < ".$wnum[1]);
                    }
                }
                if($wc){
                    $whereC = ' where '.implode(' and ',$wc);
                }
                if($wf){
                    $whereF = " where ".implode(' and ',$wf);
                }
                $wechat_sql = "select SQL_CALC_FOUND_ROWS * from temp a,temp2 b where a.name = b.fid order by a.id desc limit ".$pageItem.",10";
                $temp = "CREATE TEMPORARY TABLE temp select * from wechat ".$whereF;                
                $temp2 = "CREATE TEMPORARY TABLE temp2 select min(disfirstreadpri) minpri,fid,firstreadpri,secondreadpri,otherreadpri,disfirstreadpri,dissecondreadpri,disotherreadpri,discount,publicnum,publictime,validtime,provider,note,pid,updatetime from wechatproviders ".$whereC." group by fid";
                M()->execute($temp);
                M()->execute($temp2);
                $data = M()->query($wechat_sql);
                $count = M()->query("select FOUND_ROWS() num");
                //$count = M()->query($count_sql);
            }else if($plat == 'toutiao'){
                if($price && $price != "all"){
                    $pnum = explode('a', $price);
                    if($pnum[1] == "inify"){
                        array_push($wc,"discountPrice > ".$pnum[0]);
                    }else{
                        array_push($wc,"discountPrice > ".$pnum[0]." and discountPrice < ".$pnum[1]);
                    }
                }
                if($weight && $weight != "all"){
                    $wnum = explode('a', $weight);
                    if($wnum[1] == 'inify'){
                        array_push($wf,"averReadNum > ".$wnum[0]);
                    }else{
                        array_push($wf,"averReadNum > ".$wnum[0]." and averReadNum < ".$wnum[1]);
                    }
                }
                if($wc){
                    $whereC = ' where '.implode(' and ',$wc);
                }
                if($wf){
                    $whereF = " where ".implode(' and ',$wf);
                }

                $toutiao_sql = "select SQL_CALC_FOUND_ROWS * from temp a,temp2 b where a.name = b.fid order by a.id desc limit ".$pageItem.",10";
                $temp = "CREATE TEMPORARY TABLE temp select * from toutiao ".$whereF;  
                $temp2 = "CREATE TEMPORARY TABLE temp2 select min(discountprice) minpri,fid,price,discountprice,discount,validtime,provider,note,pid,updatetime from toutiaoproviders ".$whereC." group by fid";
                M()->execute($temp);
                M()->execute($temp2);
                $data = M()->query($toutiao_sql);
                $count = M()->query("select FOUND_ROWS() num");
                //$count = M()->query($count_sql);
            }
        }else{
            $blog_sql = "select SQL_CALC_FOUND_ROWS * from temp a,temp2 b where a.name = b.fid order by a.id desc limit ".$pageItem.",10";
            $temp = "CREATE TEMPORARY TABLE temp select * from blog";  
            $temp2 = "CREATE TEMPORARY TABLE temp2 select min(disfirstpri) minpri,fid,firstpri,secondpri,profirstpri,prosecondpri,disfirstpri,dissecondpri,discount,validtime,provider,note,pid,updatetime from blogproviders group by fid";
            M()->execute($temp);
            M()->execute($temp2);
            $data = M()->query($blog_sql);
            $count = M()->query("select FOUND_ROWS() num");
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
<?php
namespace Home\Controller;
use Think\Controller;

class OrderListController extends Controller {
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
        if(cookie('shengu_user')){
            if($_GET['page']){
                $page = $_GET['page'];
                $pageItem = ($page - 1) * 10;
            }else{
                $page = 1;
                $pageItem = 0;
            }
            $plat = $_GET['plat'];
            $price = $_GET['price'];
            $time = $_GET['time'];
            $user = $_GET['user'];
            $name = $_GET['name'];

            $where = "";

            if($plat && $plat != "all"){
                $where .= " and plat = '".$plat."'";
            }
            if($user && $user != "all"){
                $where .= " and user = '".$user."'";
            }
            if($price && $price != "all"){
                $pnum = explode('a', $price);
                if($pnum[1] == "inify"){
                    $where .= " and pay > ".$pnum[0];
                }else{
                    $where .= " and pay > ".$pnum[0]." and pay < ".$pnum[1];
                }
            }
            if($name && $name != 'all'){
                $where .= " and proj like concat('%','".$name."','%') ";
            }

            if($time && $time != "all"){
                preg_match('/\d+/',$time,$item);
                if(preg_match('/y/',$time)){
                    $time = strtotime("-".$item[0]." year");
                }else if(preg_match('/m/',$time)){
                    $time = strtotime("-".$item[0]." month");
                }else if(preg_match('/d/',$time)){
                    $time = strtotime("-".$item[0]." day");
                }
                $where .= " and time > '".$time."'";
            }
            $M = M('shopcar');
            $sql = "select * from shopcar where status=2 ".$where." order by time desc limit ".$pageItem.",10";
            $count_sql = "select count(*) as num from shopcar where status=2 ".$where;
            $data = M()->query($sql);
            $count = M()->query($count_sql);
        }
        if(count($data) == 0){
            $res['code'] = 0;
            $res['msg'] = '没有数据';
            echo json_encode($res);
            exit;
        }else{
            $res['code'] = 1;        
            $res['data']['list'] = $data;            
            $res['data']['pageInfo']['page'] = intval($page);            
            $res['data']['pageInfo']['cost'] = intval($count[0]['num']);            
            $res['msg'] = 'success';
            exit(json_encode($res));
        }
    }
}

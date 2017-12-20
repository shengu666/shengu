<?php
namespace Home\Controller;
use Think\Controller;

class UpdateOrderController extends Controller {
    public $res = [
                'code' => 1,
                'msg' => ''
        ];
    public function index(){
        $res = $this->res;
        if($_POST['param']){
            $param = $_POST['param'];
            $id['id'] = $param['id'];
            $M = M('shopcar');
            $order = $M->where($id)->select();
            $plat = $order[0]['plat'];
            $pid['pid'] = $order[0]['pid'];

            $shopcar['actype'] = $param['actype'];
            $shopcar['pay'] = $param['pay'];
            $shopcar['endprice'] = $param['endprice'];
            $shopcar['ispay'] = $param['ispay'];
            $shopcar['isfapiao'] = $param['isfapiao'];
            $shopcar['url'] = $param['url'];
            $shopcar['updatetime'] = time();
            $shopcar['discount'] = $param['discount'];
            $shopcar['note'] = $param['note'];
            $prod['updatetime'] = time();
            $prod['discount'] = $param['discount'];
            $prod['url'] = $param['url'];
            $M->startTrans();   //开启事务
            $result1 = $M->where($id)->save($shopcar);
            if($plat == "weibo"){
                $P = M('blogproviders');
                $prod['disfirstpri'] = $param['endprice'];
                $result2 = $P->where($pid)->save($prod);
            }else if($plat == "weixin"){
                $P = M('wechatproviders');
                $prod['disfirstreadpri'] = $param['endprice'];
                $result2 = $P->where($pid)->save($prod);
            }else if($plat == "toutiao"){
                $P = M('toutiaoproviders');
                $prod['discountprice'] = $param['endprice'];
                $result2 = $P->where($pid)->save($prod);
            }
            if($result1 && $result2){
                $M->commit();
                $res['code'] = 1;
                $res['msg'] = 'success';
                echo json_encode($res);
            }else{
                $M->rollback();
                $res['code'] = 0;
                $res['msg'] = '数据库写入失败';
                echo json_encode($res);
            }
        }else{
            $res['code'] = 0;
            $res['msg'] = '参数非法';
            echo json_encode($res);
        }
    }
}

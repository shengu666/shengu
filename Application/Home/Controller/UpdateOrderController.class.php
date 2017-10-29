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
        if($_POST['param'] && $_POST['id']){
            $id['id'] = $_POST['id'];
            $param = $_POST['param'];
            $M = M('shopcar');
            $order = $M->where($id)->select();
            $plat = $order[0]['plat'];
            $pid['pid'] = $order[0]['pid'];

            $shopcar['actype'] = $param['actype'];
            $shopcar['pay'] = $param['pay'];
            $shopcar['ispay'] = $param['ispay'];
            $prod['discount'] = $param['discount'];

            $M->startTrans();   //开启事务
            $result1 = $M->where($pid)->save($shopcar);
            if($plat == "weibo"){
                $P = M('blogproviders');
                $prod['disFirstPri'] = $param['endprice'];
                $result2 = $P->where($pid)->save($prod);
            }else if($palt == "weixin"){
                $P = M('wechatproviders');
                $prod['disFirstReadPri'] = $param['endprice'];
                $result2 = $P->where($pid)->save($prod);
            }else if($plat == "toutiao"){
                $P = M('toutiaoproviders');
                $prod['discountPrice'] = $param['endprice'];
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
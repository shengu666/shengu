<?php
namespace Home\Controller;
use Think\Controller;

class ListController extends Controller {
    public function index(){
    	$res = [
    		'data' => [
    			'list' => [],
	    		'pageInfo' => [
	    			'page' => 1,
	    			'cost' => 25,
	    			'pageSize' => 20
	    		],
    		],
    		'code' => 1,
    		'msg' => ''
    	];
    	$data = [];
    	$item = [];
    	/*array_push($data, $this->readExcel(0));
    	array_push($data, $this->readExcel(1));*/
    	// /array_push($data, $this->readExcel(2));
    	$item = [
	    		'id' => 1,
	    		'name' => '速途网',
	    		'url' => 'http://weibo.com/12051005',
	    		'allReadNum' => '3314W',
	    		'averReadNum' => '156153',
	    		'price' => '5500',
	    		'discountPrice' => '4400',
	    		'discount' => '0.8',
	    		'type' => '互联网类',
	    		'validTime' => '42996',
	    		'provider' => '鼓山',
	    		'note' => '聚集互联网10万行业精英'
    	];
    	$item2 = [
	    		'id' => 1,
	    		'name' => '速途网',
	    		'url' => 'http://weibo.com/12051005',
	    		'allReadNum' => '3314W',
	    		'averReadNum' => '156153',
	    		'price' => '5500',
	    		'discountPrice' => '4400',
	    		'discount' => '0.8',
	    		'type' => '互联网类',
	    		'validTime' => '42996',
	    		'provider' => '鼓山',
	    		'note' => '聚集互联网10万行业精英',
	    		'children' => [
	    			$item,
	    			$item,
	    			$item
	    		]
    	];
		for($i=0;$i<25;$i++){
			array_push($res['data']['list'], $item2);
		};
    	echo json_encode($res);
    }
}
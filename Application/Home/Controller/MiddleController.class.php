<?php
namespace Home\Controller;
use Think\Controller;

class MiddleController extends Controller {
	public $res = [
                'code' => ,
                'msg' => ''
        ];
    public function __construct(){	//覆盖了父类构造函数
    	parent::__construct();
        if(session('?shengu_user')){

        }else{
        	echo 
            exit;
        }
    }
}
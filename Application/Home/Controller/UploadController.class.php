<?php
namespace Home\Controller;
use Think\Controller;

class UploadController extends Controller {
	public $res = [
                'data' => [
                    'file' => ''
                ],
                'code' => 1,
                'msg' => ''
        ];
    public function index(){
        $res = $this->res;
        if(count($_FILES['file']) > 0){
            $type = strrchr($_FILES['file']['name'], '.');
            if($type == '.xlsx'){
                $newFile = rand(1000000,9999999).".xlsx";
                $path = "./Public/Uploads/".$newFile;
                $a = move_uploaded_file($_FILES['file']['tmp_name'], $path);
                if($a){
                    $res['data']['file'] = $newFile;
                    $res['data']['plat'] = str_replace(".xlsx","",$_FILES['file']['name']);
                    $res['code'] = 1;
                    $res['msg'] = 'success';
                    echo json_encode($res);
                }
            }else{
                $res['code'] = 0;
                $res['msg'] = '文件类型非法';
                echo json_encode($res);
            }
        }else{
            return;
        }
    }
}
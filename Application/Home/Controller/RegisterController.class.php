<?php
namespace Home\Controller;
use Think\Controller;

class RegisterController extends Controller {
    public function index(){
    	//$item = $_POST[];
        //var_dump($item);
    	$data = [
    		['id' => 1,
    		'user' => 'root',
    		'pass' => md5("root"),
    		'time' => time(),
    		'type' => 1],
    		['id' => 2,
    		'user' => 'user1',
    		'pass' => md5("user1"),
    		'time' => time(),
    		'type' => 2],
    		['id' => 3,
    		'user' => 'user2',
    		'pass' => md5("user2"),
    		'time' => time(),
    		'type' => 2],
    	];
    	echo json_encode($data);
        //return $data;
		/*$db = "mysql:host=localhost;dbname=User";
		$user = "root";
		$pas = "";
    	$pdo = new PDO($db,$user,$pas);
    	$sql = "select * from User";
    	$result = $pdo->query($sql);
    	$rows = $result->fetchAll(PDO::FETCH_BOTH); */
    	/*$user = M("User");
    	$item = $user->select();
    	var_dump($item);*/
    	/*echo "test";*/
    }
}
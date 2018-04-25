<?php

//mysql 处理方式
$db=new mysqli('127.0.0.1','root','******','table','3306');
$db->query('set autocommit=0');
$db->query('begin');

list($code)=$db->query('select code from data where status=0 limit 1 for update')->fetch_array(MYSQLI_NUM);
if ($code) {
	if ($db->query("insert into orders (code) values ({$code})")){
		if ($db->query("update data set status=1 where code='{$code}'")) {
			$db->query('commit');
		}else{
			$db->query('rollback');
		}
	}else{
		$db->query('rollback');
	}
}else{
	$db->query('rollback');
	$end=true;
}



//redis 处理方式
// $redis = new Redis();
// $redis->connect('127.0.0.1', 6379);

// // $rs=$db->query('select code from data')->fetch_all(MYSQLI_NUM);
// // foreach ($rs as $key => $value) {
// //     $redis->sadd('code',$value[0]);
// // }
// // die;

// $code=$redis->spop('code');
// if ($code) {
//     $db->query("insert into orders (code) values ({$code})");
// }else{
// 	$end=true;
// }



if ($end) {
	file_put_contents('./index.html','<h1>抢号已结束！</h1>');
}
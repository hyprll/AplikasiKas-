<?php  

$HOST = 'localhost';
$username = 'root';
$password = '';
$db = 'kas';
$connect = mysqli_connect($HOST,$username,$password,$db);

$query = mysqli_query($connect, 'select * from user');
$data = [];

foreach ($query as $result) {
	$data[]= $result;
}
// var_dump($data);\

function query($sql) {
	$getData = $connect->query($sql);
	$data =  $connect->fetch_assoc($getData);
	
	var_dump($sql);
	die;
};

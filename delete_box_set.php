<?php 
# Соединямся с БД
include_once("sql_connect.php");

//подключаем проверку логина
// @return Bool 
include_once("check_login.php");

//если не залогинен 
if( !check_login($conn) )  die("GO AWAY");


$box_name = @stripslashes(htmlspecialchars($_POST["box_name"]));

$user_id = stripslashes(htmlspecialchars($_COOKIE['id']));


$query = "DELETE FROM `box` WHERE `box`.`box_name` = '".mysqli_real_escape_string($conn,$box_name)."' AND user_id='".mysqli_real_escape_string($conn,$user_id)."'";

	$result = mysqli_query($conn, $query);

	$res = isset($result) ? "success" : $result; 

	echo $res;

		


mysqli_close($conn);






?>
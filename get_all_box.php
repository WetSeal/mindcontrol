<?php 
# Соединямся с БД
include_once("sql_connect.php");

//подключаем проверку логина
// @return Bool 
include_once("check_login.php");

//если не залогинен 
if( !check_login($conn) )  die("GO AWAY");

$box_name = @stripslashes(htmlspecialchars($_POST["name"]));
$user_id = stripslashes(htmlspecialchars($_COOKIE['id']));

$query = "SELECT box_question, box_answer, box_status, box_id FROM box WHERE user_id='".mysqli_real_escape_string($conn,$user_id)."' AND box_name='".mysqli_real_escape_string($conn,$box_name)."'";


	$result = mysqli_query($conn, $query);
	$row = mysqli_fetch_all($result,MYSQLI_ASSOC);//берет все значения и превращает в асоц масив


	/* удаление выборки тупа па приколу*/
 	mysqli_free_result($result);

	echo json_encode($row);


mysqli_close($conn);


 ?>
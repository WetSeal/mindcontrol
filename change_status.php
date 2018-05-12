<?php 
# Соединямся с БД
include_once("sql_connect.php");

//подключаем проверку логина
// @return Bool 
include_once("check_login.php");

//если не залогинен 
if( !check_login($conn) )  die("GO AWAY");


$data = $_POST["data"];



$message = array( 'ok' => "", "err" => array() );

$box_name = @stripslashes(htmlspecialchars($data["box_name"]));
$box_id = @stripslashes(htmlspecialchars($data["box_id"]));

$box_status = @stripslashes(htmlspecialchars($data["box_status"]));

$box_status = preg_replace("/[^0-9]/", '', $box_status);

if( empty($box_status) ) $box_status = "everyday";


$box_date_change = @stripslashes(htmlspecialchars($data["box_date_change"]));



$user_id =stripslashes(htmlspecialchars( $_COOKIE['id']));


$query_update = "UPDATE `box` SET `box_status` ='".mysqli_real_escape_string($conn,$box_status)."', `box_date_change` ='".mysqli_real_escape_string($conn,$box_date_change)."'  WHERE box_id='".mysqli_real_escape_string($conn,$box_id)."' AND user_id='".mysqli_real_escape_string($conn,$user_id)."' AND box_name='".mysqli_real_escape_string($conn,$box_name)."'";


		//сам запрос
		$result = mysqli_query($conn, $query_update);

	    if($result){
	    	$message["ok"] = true;
	    }else{
	    	$message["ok"] = false;
	    	$message["err"][] = "траблы с upadate";
	    	
	    }




if($message["ok"]){
	echo "success";
}else{
	print_r( $message["err"] );
}




mysqli_close($conn);


?>
<?php 

# Соединямся с БД
include_once("../sql_connect.php");


//подключаем проверку логина
// @return Bool 
include_once("../check_login.php");



if( !check_login($conn) )  exit("GO AWAY");

	$user_id = stripslashes(htmlspecialchars($_COOKIE['id']));

	/*$user_name = $row['user_login'];*/
	
	$link = stripslashes(htmlspecialchars($_GET['link']));

	include_once("../view/view_head.php");

	//print_r($_GET);

	//БОЖЕ ЧТО ЗА КАЛ Я ПИШУ
	if(isset($link)){


    	switch($link){

    		case 'create_box': 
    			include_once("../view/view_create_box.php");

    		break;

    		case 'start_learn_box': 
    			include_once("../view/view_start_learn_box.php");
    		break;

    		case 'edit_box': 

    			//include_once("../get_box_name.php");

    			include_once("../view/view_edit_box.php");


    		break;

    		default: include_once("../view/view_box.php");
    	}

	}else{
		include_once("../view/view_box.php");
	}


	include_once("../view/view_footer.php");




mysqli_close($conn);

?>


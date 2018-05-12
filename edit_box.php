<?php 
# Соединямся с БД
include_once("sql_connect.php");

//подключаем проверку логина
// @return Bool 
include_once("check_login.php");

//если не залогинен 
if( !check_login($conn) )  die("GO AWAY");


$data = $_POST["data"];





$box_name = @stripslashes(htmlspecialchars($data["box_name"]));

$user_id = stripslashes(htmlspecialchars($_COOKIE['id']));


//функция для проверки есть ли карточка с таким вопросом, юером и названием карточки в бд
include_once("check_coincedence.php");




$arr_ = array();
//УБИРАЕМ ПОВТОРЯЮЩЕИСЯ ЗНАЧЕНИЯ
foreach ($data as $key => $value) {
    //создаем масив с названием вопроса как ключ и значение (какое то пофиг)
    if(@!$arr_[$data[$key]["box_question"]]){
         @$arr_[$data[$key]["box_question"]] = array();
        @$arr_[$data[$key]["box_question"]][] = $key;
    }else{
        @$arr_[$data[$key]["box_question"]][] = $key;
    }

    //echo count($arr_[$data[$key]["box_question"]]);

    //проверяем если в новом масиве больше 2х элементов то удаляем текущий с основного масива
  if(count(@$arr_[$data[$key]["box_question"]]) > 1){
        unset($data[$key]); 
    }
    
    
    
}

//==================================================
	$message = array( 'ok' => "", "err" => array() );

	$str_delete = "";
	$str_update = array('box_question' => "", 'box_answer' => "", 'box_status' => "");
	$str_insert = "";

    
   

    

    //       ФОРМИРУЕМ СТРОКИ ЗАПРОСА

    foreach ($data as $key => $value) {
    	if( empty($data[$key]["box_question"]) ) continue;

    	if(is_array($data[$key]) && $data[$key]["box_question"] && $data[$key]["box_answer"] && $data[$key]["box_action"]){

    		$box_question = stripslashes(htmlspecialchars($data[$key]["box_question"]));
    		$box_answer = stripslashes(htmlspecialchars($data[$key]["box_answer"]));
    		$box_status = stripslashes(htmlspecialchars($data[$key]["box_status"]));
    		$box_id = stripslashes(htmlspecialchars($data[$key]["box_id"]));
    		
    		// ДЛЯ DELETE
    		if($data[$key]["box_action"] == "delete"){
    			//если этот элемент для удаления то формируем строку с вопросами которые нужно удалить
    			$str_delete .= "'".mysqli_real_escape_string($conn,$box_question)."',";

    		}

    		// ДЛЯ UPDATE
    		if( $data[$key]["box_action"] == "update" && !empty($data[$key]["box_id"]) ){

    			$str_update["box_question"] .= "WHEN '".mysqli_real_escape_string($conn,$box_id)."' THEN '".mysqli_real_escape_string($conn,$box_question)."' ";
    			$str_update["box_answer"] .= "WHEN '".mysqli_real_escape_string($conn,$box_id)."' THEN '".mysqli_real_escape_string($conn,$box_answer)."' ";
    			$str_update["box_status"] .= "WHEN '".mysqli_real_escape_string($conn,$box_id)."' THEN '".mysqli_real_escape_string($conn,$box_status)."' ";

    		}elseif( $data[$key]["box_action"] == "update" ){
    			$message["err"][] = 'траблы с формированием сроки UPDATE для id'.$box_id;
    		}


    		// ДЛЯ INSERT
    		if($data[$key]["box_action"] == "insert" && check_coincidence($user_id,$box_name,$box_question,$conn)){
    			
    			$str_insert .= "('".mysqli_real_escape_string($conn,$box_name)."', '".mysqli_real_escape_string($conn,$user_id)."', '".mysqli_real_escape_string($conn,$box_question)."', '".mysqli_real_escape_string($conn,$box_answer)."', '".mysqli_real_escape_string($conn,$box_status)."'),";

    		}




    	}

    }




//================ ЗАПРОС НА УДАЛЕНИЕ =====================
     //удаляем запятую если она есть в конце строки c нашими вопросами которые нужно удалить
    if(!empty($str_delete) && $str_delete[strlen(rtrim ($str_delete)) - 1] == ","){
    	$str_delete = substr($str_delete,0,-1);

    	//формируем строку запроса 
		$query_delete = "DELETE FROM `box` WHERE `box`.`box_question` IN ({$str_delete}) AND user_id='".mysqli_real_escape_string($conn,$user_id)."' AND box_name='".mysqli_real_escape_string($conn,$box_name)."'";

		//сам запрос
		$result = mysqli_query($conn, $query_delete);
	    //echo $query_delete;
	    //echo $result;
	    if($result){
	    	$message["ok"] = true;
	    }else{
	    	$message["ok"] = false;
	    	$message["err"][] = "траблы с delete";
	    	
	    }

    }


//================ ЗАПРОС НА РЕДАКТИРОВАНИЕ =====================
    if( !empty($str_update["box_question"]) ){

    	
		//формируем строку запроса 
    	$query_update = "UPDATE `box` SET `box_question` = CASE `box_id` {$str_update["box_question"]} ELSE `box_question` END, `box_answer` = CASE `box_id` {$str_update["box_answer"]} ELSE `box_answer` END, `box_status` = CASE `box_id` {$str_update["box_status"]} ELSE `box_status` END WHERE  user_id='".mysqli_real_escape_string($conn,$user_id)."' AND box_name='".mysqli_real_escape_string($conn,$box_name)."'";


		//$query_update = "UPDATE `box` SET `box_question` = CASE `box_id` WHEN 20 THEN 'sdfsdf' ELSE `box_question` END, `box_answer` = CASE `box_id` WHEN 20 THEN 'sdfsdf' ELSE `box_answer` END, `box_status` = CASE `box_id` WHEN 20 THEN 'sdfsdf' ELSE `box_status` END WHERE  user_id='".mysqli_real_escape_string($conn,$user_id)."' AND box_name='".mysqli_real_escape_string($conn,$box_name)."'";
    	
		 

		//сам запрос
		$result = mysqli_query($conn, $query_update);
	    // echo $query_update;
	    // echo $result;
	    if($result){
	    	$message["ok"] = true;
	    }else{
	    	$message["ok"] = false;
	    	$message["err"][] = "траблы с upadate";
	    	
	    }

    }



//================ ЗАПРОС НА ДОБАВЛЕНИЕ =====================

     //удаляем запятую если она есть в конце строки c нашими вопросами которые нужно удалить
    if( !empty($str_insert) ){
    	

    	//формируем строку запроса 
 		$query_insert = "INSERT INTO box (box_name, user_id, box_question, box_answer, box_status) VALUES {$str_insert}";

	 	//удаляем запятую если она есть в конце строки запроса
	    if($query_insert[strlen(rtrim ($query_insert)) - 1] == ",") $query_insert = substr($query_insert,0,-1);
			
	    $result = mysqli_query($conn, $query_insert);


	    //echo $query_delete;
	    //echo $result;
	    if($result){
	    	$message["ok"] = true;
	    }else{
	    	$message["ok"] = false;
	    	$message["err"][] = "траблы с INSERT";
	    	
	    }

    }













if($message["ok"]){
	echo "success";
}else{
	print_r( $message["err"] );
}



mysqli_close($conn);


 ?>
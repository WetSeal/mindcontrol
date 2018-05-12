<?php 

# Соединямся с БД
include_once("sql_connect.php");

//подключаем проверку логина
// @return Bool 
include_once("check_login.php");

//если не залогинен 
if( !check_login($conn) )  die("GO AWAY");


//если не пришло название набора карточек
$data = $_POST["data"];


//var_dump($data);
$box_name = @stripslashes(htmlspecialchars($data["box_name"]));

$user_id = stripslashes(htmlspecialchars($_COOKIE['id']));

//echo 'box_name '.$box_name."\n";
if( empty($box_name) ) die("GO AWAY");

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


// var_dump(  $arr_ );
// var_dump(  $data );
// die();


    //добавляем в базу все карточки
    $query = "INSERT INTO box (box_name, user_id, box_question, box_answer) VALUES ";

    //дополняем нашу строку..... когда я начну писать что то нормальное а не кал ((
    foreach ($data as $key => $value) {

    	$str = "";
    	//если ключ это обьект то формируем строку с его ключа и значения и дописываем в наш запрос 
    	if( is_array($data[$key]) && $data[$key]["box_question"] && $data[$key]["box_answer"] && check_coincidence($user_id,$box_name,stripslashes(htmlspecialchars($data[$key]["box_question"])),$conn)){

           $box_question = stripslashes(htmlspecialchars($data[$key]["box_question"]));
           $box_answer = stripslashes(htmlspecialchars($data[$key]["box_answer"]));

    		$str .= "('".mysqli_real_escape_string($conn,$box_name)."', '".mysqli_real_escape_string($conn,$user_id)."', '".mysqli_real_escape_string($conn,$box_question)."', '".mysqli_real_escape_string($conn,$box_answer)."'),";
    		$query .= $str;

    	}
    }

    //удаляем запятую если она есть в конце строки запроса
    if($query[strlen(rtrim ($query)) - 1] == ",") $query = substr($query,0,-1);
	
    $result = mysqli_query($conn, $query);
    //echo $query;
    if($result){
    	echo "success";
    }else{
    	echo  "что то пошло не так(запрос не прошел)";
    }



// echo '<pre>';
// while ( $row = mysqli_fetch_row($result)) {
// 	print_r($row[0]) ;
// }

// print_r($result);




mysqli_close($conn);

?>
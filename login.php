<?php 

# Соединямся с БД
include_once("sql_connect.php");



//=========================================================

$login = stripslashes(htmlspecialchars($_POST['login']));
$pass = stripslashes(htmlspecialchars($_POST['pass']));

//=========================================================




# Функция для генерации случайной строки

function generateCode($length=10) {

    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHI JKLMNOPRQSTUVWXYZ0123456789";

    $code = "";

    $clen = strlen($chars) - 1;  
    while (strlen($code) < $length) {

            $code .= $chars[mt_rand(0,$clen)];  
    }

    return $code;

}


//проверяем что данные пришли правильно
if( (!empty($pass) && !empty($login)) &&  (strlen($login) > 3 && strlen($login) < 20 ) &&  (strlen($pass) > 3 && strlen($pass) < 20) ){


	$query = ("SELECT user_id, user_pass FROM user WHERE user_login='".mysqli_real_escape_string($conn,$login)."'");

	$result = mysqli_query($conn, $query);

	$row = mysqli_fetch_assoc($result);


	//если такой логин есть
	if($row){

		//если пароли верны
		if( $row['user_pass'] === md5(md5(trim($pass))) ){

	 		# Генерируем случайное число и шифруем его

	        $hash = md5(generateCode(10));


            # Записываем в БД новый хеш авторизации и IP

	        mysqli_query($conn, "UPDATE user SET user_hash='".$hash."' WHERE user_id='".$row['user_id']."'");

	        

	        # Ставим куки

	        setcookie("id", $row['user_id'], time()+60*60*24*30);

	        setcookie("hash", $hash, time()+60*60*24*30);

        

    	    /* удаление выборки */
   			 mysqli_free_result($result);



   			 header("Location: box/?link=create_box"); exit();
   			// echo 'success';
		}else{

			echo 'data incorrect';
		}




	}else{
		echo 'data incorrect';
	}
	//var_dump();
/*	while(){
		printf ("%s (%s)\n", $row["user_id"], $row["user_pass"]);
	}*/






}else{

	echo 'fail';

}


    	    /* удаление выборки */
   			 mysqli_free_result($result);

mysqli_close($conn);

 ?>
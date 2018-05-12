<?php 
//возвращает тру или фолс
function check_login($conn){

	$cookie_id = stripslashes(htmlspecialchars($_COOKIE['id']));
	$cookie_hash = stripslashes(htmlspecialchars($_COOKIE['hash']));
	//проверяем есть ли наши кукы
	if ( isset($cookie_id) && isset($cookie_hash) ){

		//выбираем всю строку с бд по юзер ид взятого с кук
		$query = ("SELECT * FROM user WHERE user_id = '".intval($cookie_id)."' LIMIT 1");

		$result = mysqli_query($conn, $query);

		$row = mysqli_fetch_assoc($result);


		//проверка на совпадение куки и бд
		 if( ($row['user_hash'] !== $cookie_hash) || ($row['user_id'] !== $cookie_id) ){

		 	//если они не совпадают то удаляем их
	        setcookie("id", "", time() - 3600*24*30*12, "/");

	        setcookie("hash", "", time() - 3600*24*30*12, "/");
	      //если логин или пароль не совпадает
	     	return false;

	    }else{

	    	//что то делаем если юзер залогинен
	    	return true;
	  		
	    }

	    

	}else{

		return false;

	}


}


 ?>
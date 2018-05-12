<?php 
//проверяем есть ли карточка с таким вопросом юером и названием карточки в бд
    function check_coincidence($user_id,$box_name,$box_question,$conn){

	    $query = "SELECT COUNT(box_question) FROM `box` WHERE `user_id`=\"".mysqli_real_escape_string($conn,$user_id)."\" AND `box_question`=\"".mysqli_real_escape_string($conn,$box_question)."\" AND `box_name`=\"".mysqli_real_escape_string($conn,$box_name)."\"";

	    $result = mysqli_query($conn, $query);
	    $row = mysqli_fetch_row($result);//функция вырезает 1й найденый элемент и возвращает его
	    
	    // echo $row[0];
	    //если что то нашло то будет значение больше 0
	    if( $row[0] ) {
	    	return false;
	    }else{
	    	return true;
	    }

    }

 ?>
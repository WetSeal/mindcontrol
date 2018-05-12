<?php

# Соединямся с БД
include_once("sql_connect.php");



$login = stripslashes(htmlspecialchars($_POST['login']));
$pass = stripslashes(htmlspecialchars($_POST['pass']));


//проверяем не пустые ли значения логина и пароля и >3 and < 10
if( (!empty($pass) && !empty($login)) &&  (strlen($login) > 3 && strlen($login) < 20 ) &&  (strlen($pass) > 3 && strlen($pass) < 20) ){

    //проверяем нет ли такого логина в бд
    $query = "SELECT COUNT(user_id) FROM user WHERE user_login='".mysqli_real_escape_string($conn,$login)."'";

    $result = mysqli_query($conn, $query);

    $row = mysqli_fetch_row($result);
    //var_dump(mysqli_fetch_row($result));
    //print_r($row);




        //если совпадений в бд нет
        if(!$row[0]){

         $pass = md5(md5(trim($pass)));

         $query = ("INSERT INTO user SET user_login='".mysqli_real_escape_string($conn,$login)."', user_pass='".mysqli_real_escape_string($conn,$pass)."'");

         $result = mysqli_query($conn, $query);

         //print_r($result);
         echo 'success';




        // sleep(4);
        }else{
            echo "fail";
        }
    
    



}else{
    echo 'fail';
}

mysqli_close($conn);
?>
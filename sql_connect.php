<?php 

$serv_name = 'mysql.zzz.com.ua';
$u_name = 'gg';
$pass = 'Kdjqi28Jalh';
$bd = 'gg';

$conn = mysqli_connect($serv_name, $u_name, $pass, $bd);
mysqli_set_charset($conn, "utf8");

?>
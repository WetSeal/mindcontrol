<?php 
# Соединямся с БД
include_once("sql_connect.php");


//подключаем проверку логина
// @return Bool 
include_once("check_login.php");



if( check_login($conn) )  {
	header("Location: box/?link=start_learn_box"); 
	exit();
}

	


?>
<!DOCTYPE html>
<html lang="ru">
<head>

	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Mind-control (*)> </title>
	<link rel="shortcut icon" href="icon.ico" type="image/png">
	<meta property="og:url" content="" />
	<meta property="og:type" content="website" />
	<meta property="og:title" content="" />
	<meta property="og:image" content="" />
	<meta property="og:site_name" content="2" />
	<meta property="og:description" content="1" />
	
	<link rel="stylesheet" href="css/auth.css">
	<script src="js/jq.js"></script>
</head>

<body>

	<div class="main_container flex">
		<div class="wrap_msg">
			<div class="msg error">ERROR!</div>
			<div class="msg success">SUCCESS!</div>
		</div>

		<div class="login_form form flex">
			<h1>LOGIN </h1>
			<form action="login.php" method="post" class="flex">



				<div class="block_input wrap_login">
					<input type="text" name="login" placeholder="your login" required>
				</div>

				<div class="block_input wrap_pass">
					<input type="password" name="pass" placeholder="your password" required>
				</div>

				<div class="block_input wrap_btn">
					<input type="submit" value="LOGIN">
				</div>
			</form>

		</div>


		<div class="registration_form form flex active" >
				<h1>REGISTRATION </h1>
			<form action="registration.php" method="post" class="flex">

				<div class="block_input wrap_login">
					<input type="text" name="login" placeholder="enter your login" required>
				</div>

				<div class="block_input wrap_pass">
					<input type="password" name="pass" placeholder="enter your password" required="">
				</div>

				<!-- <div>
					<input type="text" name="repeat_pass" placeholder="repeat your password" required>
				</div> -->

				<div class="block_input wrap_btn"> 
					<input type="submit" value="REGISTRATION">
				</div>

			</form>

		</div>

		<div class="axe">
			<span class="change reg" data-show=".registration_form">Registration</span>
			<span>or</span>
			<span class="change login" data-show=".login_form">Login</span>
		</div>

	</div>




<script>
	$(function(){
		$(".change").on("click", function(){
			var show_elem = $(this).attr('data-show');

			if(!($(show_elem).is(".active"))){
				$(".form").hide(10);
				$(".form").removeClass('active');
				$(".msg").hide();

				$(show_elem).fadeIn(300);
				$(show_elem).addClass('active');
			}

		});

		function onAjaxComplete(data, status){
			console.log(data,status);
			
			if(data == 'success'){
				$(".msg").hide(300);
				$(".success").show(300);
				$(".form").removeClass('active');
				$(".login_form").addClass('active');
			}else{
				$(".msg").hide(300);
				$(".error").show(300);
			}
		};



		$(".registration_form").on("submit", function(e){
			e.preventDefault();
			var this_ = $(this);
			var login = this_.find('[name="login"]').val(),
				pass = this_.find('[name="pass"]').val();


			if(this_.closest(".login_form").length){

				
				//$.post("login.php", {login: login, pass: pass}, onAjaxComplete);


			}else if(this_.closest(".registration_form").length){
				
				$.post("registration.php", {login: login, pass: pass}, onAjaxComplete);
			};
			

		});


		$(".cbalink").css({"display":"none"});

	});
</script>
</body>
</html>
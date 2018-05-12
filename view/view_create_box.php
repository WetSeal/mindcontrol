<div class="create_box">
	<form action="" method="post" data-container-for="" >


		<div class="name">

			<label for="box_name"> название набора</label>
			<input type="text" placeholder="" id="box_name" name="box_name">
			
		</div>


		<div class="container_box" id="main_box_form" data-container-for="" >
		



			<div class="wrap_card" data-card="card_0" data-changed="1">
			
				<div class="piece_card question">
					<label for="box_question"> Вопрос на карточке</label>
					<input class="for_change" type="text" id="box_question" name="box_question">
				</div>

				<div class="piece_card answer">
					<label for="box_answer"> Ответ на карточке</label>
					<textarea class="for_change" id="box_answer" cols="50" rows="5" name="box_answer"></textarea>
				</div>



			</div>


		</div>
		<div class="button_container flex" >

			<div class='send_data'>
				<input type="submit" value="КРЕАТЕ">
			</div>



			<div>
				<button class="add_card" type="button">добавить карточку</button>
			</div>



		</div>
		
		<div class="mess success">Набор создан</div>
		<div class="mess error">ААААААААА!!<br>Ошибка!</div>

		<div class="attention">
			<p>*Карточки с одинаковыми вопросами для 1го набора не защитуються</p>
			<p>**Если указать название набора которое уже существует, карточки будут добавлены к нему</p></div>
	</form>

</div>

<script>
	$(function(){
		$("#box_name").on("keyup", function(){
			$("[data-container-for]").attr("data-container-for", $(this).val());
		});
	});
</script>


<script src="../js/main.js?<?php echo rand(1,9999)?>"></script>


<!-- создаем новые карточки -->
<script src="../js/edit_card.js?<?php echo rand(1,9999)?>"></script>


<!-- дублирующим вопросам ставит класс дуппликете и возвращает фолс если есть дублирующие  -->
<script src="../js/coincedence.js?<?php echo rand(1,9999)?>"></script>



<!-- Формируем наше тело запроса  -->
<script src="../js/ajax_card.js?<?php echo rand(1,9999)?>"></script>




<script>
	
		function handle_response(data){
			if(data == "success"){
				$('.mess.success').fadeIn(400).fadeOut(4200);
			}else{
				$('.mess.error').fadeIn(400).fadeOut(4200);
			}
		};


	//аякс для редактирования карточек
		var data = {};
		var box_set_name;


		//создать набор
		$("form").on('submit', function(e){
			e.preventDefault();
			box_set_name =  $(this).closest("[data-container-for]").find('[name="box_name"]').val();

			if( !box_set_name ){ 

				alert('Укажите название набора карточек');
				return false;
			}

			data = {"box_name": box_set_name};


			//отсанавливаем скрипт если совпадения есть
			if(coincendence(box_set_name)){
				return false;
			};

			collect_data(box_set_name);

			$.post("../create_box.php", {data: data}, handle_response);

		});

</script>
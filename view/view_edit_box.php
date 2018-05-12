<?php 
	
	//                DISTINCT - выдает только не повторяющеися значения
	 $query = "SELECT DISTINCT box_name FROM box WHERE user_id='".mysqli_real_escape_string($conn,$user_id)."'";

	 $result = mysqli_query($conn, $query);

	 echo "<div class='edit_box'>";

		while($row = mysqli_fetch_row($result)){
	   	 	
	   	 	
	   	 	echo "<div class='set_name get_card' data-name-card='{$row[0]}'>{$row[0]}</div><form action=\"\" method=\"post\" data-container-for=\"{$row[0]}\"><div class=\"container_box\" data-container-for=\"{$row[0]}\"></div><div class=\"button_container flex\"></div></form>";
	   	 }



	echo "</div>";
	
 ?>



	<form action="" method="post" style="display: none;" id="for_clone">



		<div class="button_container flex">


			<div class='send_data btn'>
				<input type="submit" value="ПРИНЯТЬ ИЗМЕНЕНИЯ">
			</div>


			<div class="btn">
				<button class="add_card" type="button">добавить карточку</button>
			</div>


			<div class="btn">
				<button class="delete_all_box" type="button">Удалить набор</button>
			</div>

	<!-- 	<div class="btn">
				<button class="delete_all_box" type="button">Сбросить все статусы</button>
			</div> -->


		</div>
		
	</form>
	








<?php 
	//пишу код с температурой 38... прошу понять и простить..
	//== ВНИМАНИЕ ВОЗМОЖНОЕ ПОПАДАНИЯ КАЛА В ГЛАЗНИЦЫ ==
	//
?>
<script>

	$(function(){

		var next = false;

		$('.get_card').on("click", function(e){
			e.preventDefault();
			
			//аякс сработает только после предидущего
			if(next) return;
			next = true;

			var this_ = $(this);
			
			var name = $(this).attr('data-name-card');

			var tmp_str = ``;
			// клонируем кнопки без изменений
			var clone_button = $("#for_clone .button_container>.btn").clone(true, true);


			function handle_response(data){
				var data = JSON.parse(data);
				//console.log(data.length);
				//console.log(data);
				
				next = false;
			
				//название контейнера в который будут помещены записи
				var for_container = this_.closest("[data-name-card]").attr("data-name-card"),
					//количество будущих блоков
					count_box = data.length +"__"+ for_container;
					
					

				
				for (var i = 0; i < data.length; i++) {
					var elem_for_clone = 

						`<div class="wrap_card flex" data-changed="0" data-card="card_${i}__${name}">
					
						<div class="piece_card question flex">
							<label for="box_question_${i}__${name}"> Вопрос на карточке</label>
							<textarea class="for_change" id="box_question_${i}__${name}" cols="25" rows="2" name="box_question_${i}__${name}" >${data[i]["box_question"]}</textarea>
						</div>

						<div class="piece_card answer flex">
							<label for="box_answer_${i}__${name}"> Ответ на карточке</label>
							<textarea class="for_change" id="box_answer_${i}__${name}" cols="25" rows="2" name="box_answer_${i}__${name}" >${data[i]["box_answer"]}</textarea>
						</div>

						<div class="piece_card status flex">
							<label for="box_status_${i}__${name}"> Статус</label>
							<input class="for_change" type="text" name="box_status_${i}__${name}" id="box_status_${i}__${name}" value="${data[i]["box_status"]}">
						</div>
						
						<div class="piece_card delete">
							<label for="box_delete_${i}__${name}">Удалить карточку</label>
							<input type="checkbox" name="box_delete_${i}__${name}" id="box_delete_${i}__${name}" >
						</div>
					
						<!-- <div class="piece_card change">
							<label for="box_change_${i}__${name}">Изменить карточку</label>
							<input type="checkbox" name="box_change_${i}__${name}" id="box_change_${i}__${name}" >
						</div> -->

						<div class="hidden">
							<input type="hidden" class="hidden for_change"  name="box_id" value="${data[i]["box_id"]}">
							<input type="hidden" class="hidden"  name="box_name" value="${name}">
							<input type="hidden" class="for_change box_action" id="box_action" name="box_action" value="update" data-backup-action="update">
						</div>

					</div>`;
					
					tmp_str += elem_for_clone; 
					//console.log(tmp_str);


				}

				$('[data-container-for="'+name+'"] .container_box').html(tmp_str);
				$('[data-container-for="'+name+'"] .button_container').html(clone_button);
			}
				
				


				
				//$(this).after();
			


			
			$.post("../get_all_box.php",{name: name},handle_response);


			return false;

		});


		// ========== ============ ============ ============ 
		// ==========  Удаление набора карточка  ============ 


		$('.delete_all_box').on("click", function(e){

			var this_ = $(this),
				box_name = this_.closest("[data-container-for]").attr('data-container-for');
				

			function handle_response(data){
				if(data == "success"){

					$("[data-container-for='"+box_name+"']").remove();
					$("[data-name-card='"+box_name+"']").remove();

					
					/*alert('ВСЕ ОК, ВСЕ УДАЛИЛОСЬ,\nОЙ СТОП ИЛИ ЭТО НЕ ТО ЧЕГО ВЫ ХОТЕЛИ....');*/
				}else{
					alert('что то пошло не так');
				}
			}

			var confirm_ = confirm("Вы удаляете весь набор "+box_name.toUpperCase()+"\nВы уверены?? МММ??");
			
			if(!!confirm_){
				$.post("../delete_box_set.php", {box_name: box_name}, handle_response);
			}else{
				alert('Я так и знал что СЛАБО!!!!');
			}
			
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
	$(function(){
		$(".edit_box").on("change", ".delete>input", function(){
			var this_ = $(this),
				box_action_elem = this_.closest(".wrap_card").find(".box_action"),
				backup_action = this_.closest(".wrap_card").find("[data-backup-action]").attr("data-backup-action");

				//console.log(backup_action);
			if(this_.prop("checked")){
				box_action_elem.val("delete");
				//console.log("del");
			}else{
				box_action_elem.val(backup_action);
				//console.log("back");
			}
			
		});
	});
</script>



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

			$.post("../edit_box.php", {data: data}, handle_response);

		});

</script>
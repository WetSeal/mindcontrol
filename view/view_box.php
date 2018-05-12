<?php 

$box_name = @stripslashes(htmlspecialchars($_GET["name"]));

if(empty($box_name)) die("нет названия набора");



$query = "SELECT box_question, box_answer, box_status, box_id, box_date_change FROM box WHERE user_id='".mysqli_real_escape_string($conn,$user_id)."' AND box_name='".mysqli_real_escape_string($conn,$box_name)."'";


	$result = mysqli_query($conn, $query);
	
	$row = mysqli_fetch_all($result,MYSQLI_ASSOC);//берет все значения и превращает в асоц масив
/**/






function check_status($date_change, $box_status){

	if($box_status == "everyday") return true;

	$box_status = preg_replace("/[^0-9]/", '', $box_status);


	 $curr_date =  new DateTime("NOW");

	 $date_change =  new DateTime($date_change);

	$box_status = trim($box_status);

	 if( is_numeric( $box_status ) ){
	 	$date_change->modify( "+{$box_status} day" );
	 }elseif( empty($box_status) ){
	 	return true;
	 }

	 if( $date_change <= $curr_date )return true;

	 return false;

}




echo "<div class='learn_box flex'>";
	
//print_r($row);

foreach ($row as $i => $val) {

//проверяем есть ли ключевые данные	
if( empty($row[$i]['box_question']) || empty($row[$i]['box_answer']) || empty($row[$i]['box_status']) || empty($row[$i]['box_id'])) continue;

if( !check_status($row[$i]['box_date_change'], $row[$i]['box_status']) ) continue;

	$box_status = preg_replace("/[^0-9]/", '', $row[$i]['box_status']);

$str = <<<BOB
<div class="card_block" onselectstart="return false" data-box-name="{$box_name}" data-box-id="{$row[$i]['box_id']}" data-box-status="{$box_status}" data-box-datechange="{$row[$i]['box_date_change']}">

		<div class="card">

			<div class="answer side flex">
				<div class="answer_wrap">
					<p><strong>question:</strong> {$row[$i]['box_question']}</p>
					<p><h2 style="text-align:center;">Answer:</h2><br> <pre>{$row[$i]['box_answer']}</pre></p>
				</div>
				

				<div class="next_card"></div>
			</div>

			<div class="question side flex">
				<div class="question_wrap">
					<pre>{$row[$i]['box_question']}</pre>
				</div>
				<div class="wrap_submit flex">
					<div class="know submit_answer"></div>
					<div class="d_know submit_answer"></div>
				</div>

			</div>

		</div>
	

</div>
BOB;

echo $str;
}

echo "<div class=\"card_end flex\">УСЁ!<br>Карточки закончились</div>";
echo "</div>";




/* удаление выборки тупа па приколу*/
mysqli_free_result($result);

?>

<script>
	$(function(){

		var curr_date = "<?php echo date("Y-m-d");?>"

/*		$(".card_block").dblclick(function(){
			var this_ = $(this);
			this_.toggleClass("index");
			this_.find(".card").toggleClass("flip");
			this_.find(".side").toggleClass("index");
		});
*/


		$(".submit_answer").on("click",function(e){
			var this_ = $(this);
			var main_elem = this_.closest(".card_block"),
				data = {};

				
			data["box_id"] = main_elem.attr("data-box-id");
			data["box_name"] = main_elem.attr("data-box-name");

			data["box_date_change"] = curr_date;
			data["box_status"] = +(main_elem.attr("data-box-status"));


			//если нажали "незнаю" статус сбрасываеться на каждый день
			if( $(e.target).is(".d_know") ){
				data["box_status"] = "everyday";
			}

			if( $(e.target).is(".know") ){
				data["box_status"] += 2;
			}
		
			//console.log(data);
			$.post("../change_status.php", {data: data});

			main_elem.toggleClass("index");
			main_elem.find(".card").toggleClass("flip");
			main_elem.find(".side").toggleClass("index");

		});



		$(".next_card").on("click", function(){
			var this_ = $(this),
				all_block = $(".card_block"),
				main_elem = this_.closest(".card_block"),
				count_card = all_block.length,
				index_elem = main_elem.index();

			//console.log(count_card,index_elem);

			if(index_elem >= count_card-1){

			main_elem.css({"transition": "none"}).fadeOut(800,function(){
				//тут пишем что карточки закончились
				$(".card_end").fadeIn();
				main_elem.css({"transition": ""});
			});
				

				return;
			}
		
			//скрываем текущий блок
			main_elem.css({"transition": "none"}).fadeOut(800,function(){
				all_block.eq(index_elem+1).fadeIn(800);
				main_elem.css({"transition": ""});
			});

			
			//console.log(all_block.eq(index_elem+1));

		});






	})
</script>
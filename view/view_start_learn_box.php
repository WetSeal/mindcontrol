<?php 

	

	//                DISTINCT - выдает только не повторяющеися значения
	 $query = "SELECT DISTINCT box_name FROM box WHERE user_id='".mysqli_real_escape_string($conn,$user_id)."'";

	 $result = mysqli_query($conn, $query);
	 echo "<div class=\"wrap_search flex\"><div class=\"search\"><label for=\"search_field\">Search card:</label><input type=\"text\" id='search_field' name=\"search_field\"><span class=\"btn search_btn\"></span></div></div>";
	 echo "<div class='start_learn_box flex'>";

		while($row = mysqli_fetch_row($result)){
	   	 	
	   	 	
	   	 	echo "<div class=\"wrap_box\" data-name-card='{$row[0]}'>
	   	 			<div class=\"side side_top\"></div>
					<div class=\"side side_right\"></div>
					<div class=\"side side_bottom\"></div>
					<div class=\"side side_left\"></div>
					<div class='content_box flex' >
						{$row[0]}
					</div>
				 </div>";
	   	 }


	echo "</div>";

 ?>
 <script src="../js/jq.wheel.js"></script>
 <script>


 	$(function(){
 		$("[data-name-card]").on("click",function(){
 			var name_card = $(this).attr("data-name-card");
 			
 			window.location = "<?php echo $curr_location_href;?>?name="+name_card+"";

 		});



var scrolled = false;
//просто не хочу думать...
 		$(".start_learn_box").on("mousewheel", function(event){
 			if(scrolled) return false;
 			scrolled = true;
 			event.preventDefault();
 			var this_ = $(this),
 				scroll =   this_.scrollLeft() + event.deltaY*200*(-1) ;

			// console.log(this_.scrollLeft());
			// console.log(event.deltaX, event.deltaY, event.deltaFactor);

 			this_.animate({scrollLeft: scroll}, 300, function(){
 				scrolled = false;
 			});
 			 			
 		});	


 		$("#search_field").on("input",function(){

 			var timerName;

 			var input_val = $(this).val().toLowerCase();
 			var elem = $("[data-name-card]");
 				
 			//console.log(input_val);
 			//если инпут пустой то все наборы видны
 			if(!input_val){
 				elem.fadeIn();
 				return false;
 			}

//console.time(timerName);

 			$("[data-name-card]:not([data-name-card*="+ input_val +"])").fadeOut();
 			$("[data-name-card*="+ input_val +"]").fadeIn();


 			/*elem.each(function(i,el){

 				var this_ = $(el);
 					name = this_.attr("data-name-card").toLowerCase();

 				if(~name.indexOf(input_val)){
 					this_.fadeIn();
 				}else{
 					this_.fadeOut();
 				}


 			});*/
//console.timeEnd(timerName);
 		});


 	})
 </script>


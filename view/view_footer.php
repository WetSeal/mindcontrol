
<script>


	$(function(){

		//изменяем модалку в хеде
		//КАЛ..............................
		var status_menu = false;
		$(".modal_state").on('click', function(){
			if(status_menu) return;
				status_menu = true;
			var this_ = $(this),
				nav_elem = this_.closest(".nav"),
				is_show = nav_elem.find(".menu").is(".show");

			
			if(is_show) {

				$('.menu').toggleClass("show").animate({"height": 'toggle',"width":'toggle'}, 340,function(){
					status_menu = false;
				});
				
			}else{	

				$('.menu')
				.animate({"height": 'toggle',"width":'toggle'}, 340, function(){
					/*console.log('231424');*/
					$('.menu').toggleClass("show");
					status_menu = false;
				});
			}
			
	});

		$(".cbalink").css({"display":"none","opacity":0});
	});
</script>
</body>
</html>
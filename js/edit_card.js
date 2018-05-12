function change_clone(card_clone,count_box){

		card_clone.find("[for],[id],[name]").each(function(){
			if($(this).is('.hidden')) return true;
			var tag = this.tagName.toLowerCase();
				this_ = $(this);

			if(tag == "label"){

				var attr_for = this_.attr('for');
					attr_for = attr_for.replace(/(_)\d(.)*/ig,"");
				this_.attr("for",attr_for+'_'+count_box);

			}else if(tag == "input" || tag == "textarea"){
				
				this_.val("");
				
				if(this_.is("[name='box_action']")){
					this_.val("insert");
					this_.attr("data-backup-action", "insert");
				}

				if(!!this_.closest(".status").length){

					this_.val("everyday");
					
				}




				var attr_id = this_.attr('id'),
					attr_name = this_.attr('name');
					attr_id = attr_id.replace(/(_)\d(.)*/ig,"");
					attr_name = attr_name.replace(/(_)\d(.)*/ig,"");
			
				this_.attr({
					"id" : attr_id+'_'+count_box,
					"name" : attr_name+'_'+count_box
				});
				


				if(this_.is("[type='checkbox']")){
					this_.prop("checked", false);
				}



			}
			//console.log(tag);
		});
		return card_clone;
}
function randInt(min,max){
	return Math.floor(Math.random() * (max - min + 1)) + min;
}
//кнопка добавть карточку
		$(".add_card").on('click',function(){
				var for_container = $(this).closest("[data-container-for]").attr("data-container-for");
				
			var wrap_block = $("[data-container-for='"+for_container+"'] .wrap_card"),

				count_box = wrap_block.length+"_"+ randInt(1,100) +"__"+ for_container,

				card_clone = wrap_block.eq(0).clone();

				
				//console.log(wrap_block);
				card_clone.attr("data-card", "card_"+count_box);
				card_clone.attr("data-changed", 1);

				card_clone.find("[name='box_id']").val("empty");
				

				change_clone(card_clone,count_box);

				card_clone.append("<div class='delete_card'></div>");
								
				$(".container_box[data-container-for='"+for_container+"']").append(card_clone);

			
		});


		//кнопка удалить карточку

		$(".create_box ").on('click',".delete_card", function(){
			
			$(this).closest(".wrap_card").remove();
		});

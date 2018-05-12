// Формируем наше тело запроса
function collect_data(box_set_name){
	//проходим по каждой карточке и записываем ее значение
	$(" [data-container-for='"+box_set_name+"'] [data-changed='1'] ").find('.for_change').each(function() {
		
		var th = $(this),
			data_card_elem = th.closest("[data-card]"),
			curr_card = data_card_elem.attr("data-card"),
			
			count_elem = data_card_elem.find(".for_change").length;//количество input textarea в этом блоке

		//создаем обьект если он не создан для одной карточки	
		if( !data[curr_card] ){ 
			data[curr_card] = {"counter_in":0, "counter_fail":0};
			Object.defineProperties(data[curr_card], {
			  "counter_in": {
			  	enumerable: false,
			    value: 0
			  },

			  "counter_fail": {
			  	enumerable: false,
			    value: false
			  }

			});
		}

		//удаляем все символы после _число что бы были чистые box_question и box_answer
		var name = this.name.replace(/(_)\d(.)*/ig,"");
		//console.log(name);
		data[curr_card][name] = th.val();
		data[curr_card]["counter_in"]++;


		if( !th.val() )  data[curr_card]["counter_fail"] = true;
		
		// console.log("count_in " + data[curr_card]["counter_in"]);
		// console.log("all count " + count_elem);
		if( (data[curr_card]["counter_in"] >= count_elem) && (!!data[curr_card]["counter_fail"])){
			delete data[curr_card];
		}

	});
}


			

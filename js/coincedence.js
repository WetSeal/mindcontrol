function coincendence(box_set_name){
	var obj_coincedence = new Object(null);
	var err = false;
//АХААХ ВОТ ЭТО Я ГАВНО ПРИДУМАЛ))))
// Выставляем дата атрибут data-changed='0' для тех элементов которые повторяются в вопросе
$(" [data-container-for='"+box_set_name+"'] [data-changed] ").find('.question textarea, .question input').each(function(){

	var th = $(this),
		val = th.val(),//наш вопрос
		card = th.closest("[data-changed]").attr("data-card");//id текущей карточки


	//создаем свойство с именем нашего вопроса и значением масив с id
	if(!obj_coincedence[val]){
		obj_coincedence[val] = ["[data-card='"+card+"']"];

	}else{
		obj_coincedence[val].push("[data-card='"+card+"']");
	}

				
});



for(var key in obj_coincedence ){
	//console.log(obj_coincedence[key]);
	//console.log(obj_coincedence[key].length);

	var str = obj_coincedence[key].join(',');

	//console.log(str);
	if(obj_coincedence[key].length > 1) {
		err = true;
		//все дубли не будет брать в запрос
		//$(str).attr("data-changed", 0);
		$(str).addClass("duplicate");

		//console.log("work");

		//alert('У Вас дублирующие вопросы, бля');
		//return false;
	};

	
}

return err;
//console.log(obj_coincedence);


}
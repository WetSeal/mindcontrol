//УДАЛЯЕМ ПОДСВЕТКУ ПРИ ИЗМЕНЕНИИ ПОЛЯ
$(".edit_box, .create_box").on("input", "[data-changed] input,[data-changed] textarea", function(){
	
	$(this).closest("[data-changed]").removeClass('duplicate');

	//console.log(1111);
});

//если мы что то поменяли в карточке то она будет отправлена на обработку
$(".edit_box, .create_box").on("input", "[data-changed='0'] input,[data-changed='0'] textarea", function(){
	$(this).closest("[data-changed]").attr('data-changed', 1);
	//console.log(1111);
});


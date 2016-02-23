(function() {
	var evento_lista_palestras_size = $(".evento_evento_palestras").outerHeight() + $(".admin_info").outerHeight() + parseInt($(".admin_info").css("margin-bottom"));
	$(".evento_lista_palestras").css("height", evento_lista_palestras_size);
	$(".evento_lista_palestras .list-group").css("height", evento_lista_palestras_size - 145);
})();

(function() {
	var eventos_lista_eventos_size = $(".evento_form").outerHeight() + $(".admin_info").outerHeight() + parseInt($(".admin_info").css("margin-bottom"));
	$(".eventos_lista_eventos").css("height", eventos_lista_eventos_size);
	$(".eventos_lista_eventos .list-group").css("height", eventos_lista_eventos_size - 145);
})();



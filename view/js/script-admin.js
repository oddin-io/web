(function() {
	var evento_lista_palestras_size = $(".evento_evento_palestras").outerHeight() + $(".admin_info").outerHeight() + parseInt($(".admin_info").css("margin-bottom"),10);
	$(".evento_lista_palestras").css("height", evento_lista_palestras_size);
	$(".evento_lista_palestras .list-group").css("height", evento_lista_palestras_size - 145);
})();

(function() {
	var eventos_lista_eventos_size = $(".evento_form").outerHeight() + $(".admin_info").outerHeight() + parseInt($(".admin_info").css("margin-bottom"),10);
	$(".eventos_lista_eventos").css("height", eventos_lista_eventos_size);
	$(".eventos_lista_eventos .list-group").css("height", eventos_lista_eventos_size - 145);
})();

(function() {
	var palestras_lista_palestras_size = $(".palestra_form").outerHeight() + $(".admin_info").outerHeight() + parseInt($(".admin_info").css("margin-bottom"),10);
	$(".palestras_lista_palestras").css("height", palestras_lista_palestras_size);
	$(".palestras_lista_palestras .list-group").css("height", palestras_lista_palestras_size - 145);
})();

(function() {
	var pessoa_lista_palestras_size = $(".admin_info").outerHeight();
	$(".pessoa_lista_palestras").css("height", pessoa_lista_palestras_size);
	$(".pessoa_lista_palestras .list-group").css("height", pessoa_lista_palestras_size - 145);
})();

(function() {
	if($(window).width() >= 992) {
		var pessoas_lista_pessoas_size = $(".admin_info").outerHeight() + $(".new-user-button").outerHeight() + parseInt($(".new-user-button").css("margin-bottom"), 10);
		$(".pessoas_lista_pessoas").css("height", pessoas_lista_pessoas_size);
		$(".pessoas_lista_pessoas .list-group").css("height", pessoas_lista_pessoas_size - 145);
	} else {
		$(".pessoas_lista_pessoas").css("height", 500);
		$(".pessoas_lista_pessoas .list-group").css("height", 500 - 145);
	}
})();

(function() {
	var turma_lista_turmas_size = $(".turma_form").outerHeight() + $(".admin_info").outerHeight() + parseInt($(".admin_info").css("margin-bottom"),10);
	$(".turma_lista_turmas").css("height", turma_lista_turmas_size);
	$(".turma_lista_turmas .list-group").css("height", turma_lista_turmas_size - 145);
})();


(function() {	
	var tabela_horarios_box_size = $(".admin_info").outerHeight();	
	$(".tabela-horarios-box").css("height", tabela_horarios_box_size);	
	$(".tabela-horarios").css("height", tabela_horarios_box_size - 125);
	$(".tabela-horarios table").css("height", tabela_horarios_box_size);		
})();

(function() {	
	var tabela_horarios_cadastrados_box_size = $(".admin_info").outerHeight() + $(".horario_form").outerHeight() + parseInt($(".admin_info").css("margin-bottom"),10);	
	$(".tabela-horarios-cadastrados-box").css("height", tabela_horarios_cadastrados_box_size);	
	$(".tabela-horarios-cadastrados").css("height", tabela_horarios_cadastrados_box_size - 125);
	//$(".tabela-horarios-cadastrados table").css("height", tabela_horarios_cadastrados_box_size);		
})();

(function() {	
	var tabela_horarios_disponiveis_box_size = $(".admin_info").outerHeight() + $(".disponibilidade-box").outerHeight() + parseInt($(".admin_info").css("margin-bottom"),10);	
	$(".tabela-horarios-disponiveis-box").css("height", tabela_horarios_disponiveis_box_size);	
	$(".tabela-horarios-disponiveis").css("height", tabela_horarios_disponiveis_box_size - 125);
	//$(".tabela-horarios-cadastrados table").css("height", tabela_horarios_cadastrados_box_size);		
})();

(function() {
	var atribuicao_lista_alunos_size = $(".atribuicao_lista_professores").outerHeight();
	$(".atribuicao_lista_alunos").css("height", atribuicao_lista_alunos_size);
	var list_group_alunos_height = parseInt($(".atribuicao_lista_professores .list-group").css("height"));

	var alunos_form_height = parseInt($(".atribuicao_lista_alunos form").css("height"));
	var list_margin = parseInt($(".atribuicao_lista_alunos .list-group").css("margin-top"));
	
	$(".atribuicao_lista_alunos .list-group").css("height", list_group_alunos_height - alunos_form_height - list_margin);
})();

(function() {
	var palestra_palestra_eventos_size = $(".palestra_info").outerHeight();
	$(".palestra_palestra_eventos").css("height", palestra_palestra_eventos_size);
	$(".palestra_palestra_eventos .list-group").css("height", palestra_palestra_eventos_size - 145);
})();

(function() {
	var predios_lista_predios_size = $(".predio_form").outerHeight() + $(".admin_info").outerHeight() + parseInt($(".admin_info").css("margin-bottom"),10);
	$(".predios_lista_predios").css("height", predios_lista_predios_size);
	$(".predios_lista_predios .list-group").css("height", predios_lista_predios_size - 145);
})();

(function() {
	var predio_lista_salas_size = $(".sala_form").outerHeight() + $(".admin_info").outerHeight() + parseInt($(".admin_info").css("margin-bottom"),10);
	$(".predio_lista_salas").css("height", predio_lista_salas_size);
	$(".predio_lista_salas .list-group").css("height", predio_lista_salas_size - 145);
})();





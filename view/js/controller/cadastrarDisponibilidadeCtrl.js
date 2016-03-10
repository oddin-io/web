app.controller("cadastrarDisponibilidadeCtrl", function($scope){
	var horarios_disponiveis = [{dia:'Segunda', inicio:'12:00', fim:'13:00', data_ini:'10/12/2016', data_fim:'10/13/2017'},
								{dia:'Terca', inicio:'12:00', fim:'13:00', data_ini:'10/12/2016', data_fim:'10/13/2017'},
								{dia:'Quarta', inicio:'12:00', fim:'13:00', data_ini:'10/12/2016', data_fim:'10/13/2017'},
								{dia:'Quinta', inicio:'12:00', fim:'13:00', data_ini:'10/12/2016', data_fim:'10/13/2017'},
								{dia:'Sexta', inicio:'12:00', fim:'13:00', data_ini:'10/12/2016', data_fim:'10/13/2017'},
								{dia:'Sabado', inicio:'12:00', fim:'13:00', data_ini:'10/12/2016', data_fim:'10/13/2017'},
								{dia:'Domingo', inicio:'12:00', fim:'13:00', data_ini:'10/12/2016', data_fim:'10/13/2017'}];		

	var horarios = [{dia:'Segunda', inicio:'14:00', fim:'15:00'},
					{dia:'Segunda', inicio:'15:00', fim:'17:00'},
					{dia:'Terca', inicio:'14:00', fim:'15:00'},
					{dia:'Quinta', inicio:'20:00', fim:'22:00'},
					{dia:'Sexta', inicio:'14:00', fim:'15:00'},
					{dia:'Sabado', inicio:'14:00', fim:'15:00'},
					{dia:'Segunda', inicio:'18:30', fim:'21:00'},
					{dia:'Quarta', inicio:'14:00', fim:'15:00'},
					{dia:'Quarta', inicio:'15:00', fim:'16:00'},
					{dia:'Quarta', inicio:'17:00', fim:'18:00'},
					{dia:'Segunda', inicio:'14:00', fim:'15:00'},
					{dia:'Segunda', inicio:'15:00', fim:'17:00'},					
					{dia:'Sabado', inicio:'11:00', fim:'13:00'}];
	
	var horarios_dom = [];
	var horarios_seg = [];
	var horarios_ter = [];
	var horarios_qua = [];
	var horarios_qui = [];
	var horarios_sex = [];
	var horarios_sab = [];

	for(var i = 0; i < horarios.length; i++) {
		switch(horarios[i].dia) {
			case 'Domingo':
				horarios_dom.push(horarios[i]);
				break;
			case 'Segunda':
				horarios_seg.push(horarios[i]);
				break;
			case 'Terca':
				horarios_ter.push(horarios[i]);
				break;
			case 'Quarta':
				horarios_qua.push(horarios[i]);
				break;
			case 'Quinta':
				horarios_qui.push(horarios[i]);
				break;
			case 'Sexta':
				horarios_sex.push(horarios[i]);
				break;
			case 'Sabado':
				horarios_sab.push(horarios[i]);
				break;
		}	
	}

	$scope.horarios_disp = horarios_disponiveis;
	$scope.domingo = horarios_dom;
	$scope.segunda = horarios_seg;
	$scope.terca = horarios_ter;
	$scope.quarta = horarios_qua;		
	$scope.quinta = horarios_qui;		
	$scope.sexta = horarios_sex;		
	$scope.sabado = horarios_sab;	
	$scope.modalData;

	$scope.confirmaRemoverHorarioDisp = function(horario) {
		$scope.modalData = horario;
	}	

	$scope.removerHorarioDisp = function(horario) {
		var index = horarios_disponiveis.indexOf(horario);
		horarios_disponiveis.splice(index, 1);		
	}

	$scope.confirmaAdicionarHorario = function(horario) {
		$scope.modalData = horario;
	}

	$scope.adicionarHorario = function(horario) {			
		horarios_disponiveis.push(horario);	

		var index = horarios.indexOf(horario);
		horarios.splice(index, 1);	

		switch(horario.dia) {
			case 'Domingo':
				index = horarios_dom.indexOf(horario);
				horarios_dom.splice(index, 1);
				break;
			case 'Segunda':
				index = horarios_seg.indexOf(horario);
				horarios_seg.splice(index, 1);
				break;
			case 'Terca':
				index = horarios_ter.indexOf(horario);
				horarios_ter.splice(index, 1);
				break;
			case 'Quarta':
				index = horarios_qua.indexOf(horario);
				horarios_qua.splice(index, 1);
				break;
			case 'Quinta':
				index = horarios_qui.indexOf(horario);
				horarios_qui.splice(index, 1);
				break;
			case 'Sexta':
				index = horarios_sex.indexOf(horario);
				horarios_sex.splice(index, 1);
				break;
			case 'Sabado':
				index = horarios_sab.indexOf(horario);
				horarios_sab.splice(index, 1);
				break;
		}	
	}	
});
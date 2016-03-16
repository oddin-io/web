app.controller("usuarioInfoCtrl", function($scope){

	var usuario = {id:'001', perfil:'Aluno', nome:'João da Silva', cpf:'333.999.000-55', data_nasc:'18/05/1990',
					tel:'3232-5555', rua:'Avenida das Neves', numero:350, bairro:'Jardim das Flores',
					pais:'Brasil', estado:'SP', cidade:'São Paulo'};

	var palestras_turmas = [{turma:'150', palestra:'Literatura'},
							{turma:'151', palestra:'Gramática'},
							{turma:'152', palestra:'Inglês'},
							{turma:'153', palestra:'História do Brasil'},
							{turma:'154', palestra:'História Geral'},
							{turma:'155', palestra:'Geopolítica'},
							{turma:'156', palestra:'Geografia Física'},
							{turma:'157', palestra:'Filosofia'},
							{turma:'158', palestra:'Sociologia'},
							{turma:'159', palestra:'Biologia'},
							{turma:'160', palestra:'Matemática'},
							{turma:'161', palestra:'Química'},
							{turma:'162', palestra:'Física'},
							{turma:'163', palestra:'Educação Artística'}];	

	$scope.usuario = usuario;
	$scope.palestras_turmas = palestras_turmas;	
});
app.controller("atribuicaoCtrl", function($scope){
	var salas_horarios = [{id:'001', dia:'Domingo', hora_ini:'14:30', hora_fim:'15:00', predio:'AT-00', sala:401},
							{id:'002', dia:'Segunda', hora_ini:'15:30', hora_fim:'22:00', predio:'AT-04', sala:300},
							{id:'003', dia:'Terça', hora_ini:'14:00', hora_fim:'00:00', predio:'AT-07', sala:255},
							{id:'004', dia:'Quarta', hora_ini:'18:00', hora_fim:'18:00', predio:'AT-10', sala:100},
							{id:'005', dia:'Quinta', hora_ini:'22:30', hora_fim:'15:00', predio:'AT-11', sala:105},
							{id:'006', dia:'Sexta', hora_ini:'20:30', hora_fim:'19:00', predio:'AT-05', sala:200},
							{id:'007', dia:'Sábado', hora_ini:'10:15', hora_fim:'21:00', predio:'AT-06', sala:300},
							{id:'008', dia:'Domingo', hora_ini:'16:30', hora_fim:'23:00', predio:'AT-13', sala:401},
							{id:'009', dia:'Segunda', hora_ini:'17:45', hora_fim:'02:00', predio:'AT-21', sala:505},
							{id:'010', dia:'Terça', hora_ini:'23:30', hora_fim:'03:00', predio:'AT-07', sala:600},
							{id:'011', dia:'Quarta', hora_ini:'17:30', hora_fim:'05:00', predio:'AT-08', sala:144}];

	var usuarios_matriculados = [{id:'001', nome:'João', estado:'São Paulo', pais:'Brasil', email:'joao@joao.com', senha:'1111', status:0},
					{id:'002', nome:'José', estado:'São Paulo', pais:'Brasil', email:'jose@joao.com', senha:'1111', status:1},
					{id:'003', nome:'Joaquim', estado:'São Paulo', pais:'Brasil', email:'joaquim@joao.com', senha:'1111', status:0},
					{id:'004', nome:'Jonas', estado:'São Paulo', pais:'Brasil', email:'jonas@joao.com', senha:'1111', status:1},
					{id:'005', nome:'Maria', estado:'São Paulo', pais:'Brasil', email:'maria@joao.com', senha:'1111', status:0},
					{id:'006', nome:'Marina', estado:'São Paulo', pais:'Brasil', email:'mar@joao.com', senha:'1111', status:1},
					{id:'007', nome:'Mariana', estado:'São Paulo', pais:'Brasil', email:'mary@joao.com', senha:'1111', status:0},
					{id:'008', nome:'Marcia', estado:'São Paulo', pais:'Brasil', email:'marcia@joao.com', senha:'1111', status:1},
					{id:'009', nome:'Marlene', estado:'São Paulo', pais:'Brasil', email:'lene@joao.com', senha:'1111', status:0},
					{id:'010', nome:'Francisco', estado:'São Paulo', pais:'Brasil', email:'chico@joao.com', senha:'1111', status:1},
					{id:'011', nome:'Francine', estado:'São Paulo', pais:'Brasil', email:'francine@joao.com', senha:'1111', status:0}];

	var usuarios = [{id:'001', nome:'Armando', estado:'São Paulo', pais:'Brasil', email:'joao@joao.com', senha:'1111', status:0},
					{id:'002', nome:'Alfredo', estado:'São Paulo', pais:'Brasil', email:'jose@joao.com', senha:'1111', status:1},
					{id:'003', nome:'Bruno', estado:'São Paulo', pais:'Brasil', email:'joaquim@joao.com', senha:'1111', status:0},
					{id:'004', nome:'Carlos', estado:'São Paulo', pais:'Brasil', email:'jonas@joao.com', senha:'1111', status:1},
					{id:'005', nome:'Daniel', estado:'São Paulo', pais:'Brasil', email:'maria@joao.com', senha:'1111', status:0},
					{id:'006', nome:'Danielle', estado:'São Paulo', pais:'Brasil', email:'mar@joao.com', senha:'1111', status:1},
					{id:'007', nome:'Érica', estado:'São Paulo', pais:'Brasil', email:'mary@joao.com', senha:'1111', status:0},
					{id:'008', nome:'Fabiana', estado:'São Paulo', pais:'Brasil', email:'marcia@joao.com', senha:'1111', status:1},
					{id:'009', nome:'Helena', estado:'São Paulo', pais:'Brasil', email:'lene@joao.com', senha:'1111', status:0},
					{id:'010', nome:'Kelly', estado:'São Paulo', pais:'Brasil', email:'chico@joao.com', senha:'1111', status:1},
					{id:'011', nome:'Tatiana', estado:'São Paulo', pais:'Brasil', email:'francine@joao.com', senha:'1111', status:0}];

	$scope.salas_horarios = salas_horarios;
	$scope.usuarios_matriculados = usuarios_matriculados;
	$scope.usuarios = usuarios;

	var selecionados = [];

	$scope.selecionarUsuario = function(usuario) {
    var button_icon = document.getElementById(usuario.id);
		if(selecionados.indexOf(usuario) == -1) {
      selecionados.push(usuario);
      button_icon.classList.remove('fa-circle-o');
      button_icon.classList.add('fa-check-circle-o');
    } else {
      var index = selecionados.indexOf(usuario);
      selecionados.splice(index, 1);
      button_icon.classList.remove('fa-check-circle-o');
      button_icon.classList.add('fa-circle-o');
    }
	}

  $scope.incluirUsuarios = function() {
    usuarios_matriculados = usuarios_matriculados.concat(selecionados);
    /*for(var i = 0; i < usuarios_matriculados.length; i++) {
      if(usuarios_matriculados[i].status == 1)
        alert(usuarios_matriculados[i].nome);
    }*/
    //$scope.usuarios_matriculados = usuarios_matriculados;
  }


	/*$scope.modalData;
	var modalIndex;

	$scope.cadastrarEvento = function(evento) {
		evento.status = 0;
		eventos.push(evento);
		delete $scope.evento;
		$('#modal-confirma-cadastro').modal('show');
	}

	$scope.editarEvento = function(evento) {
		$scope.modalData = JSON.parse(JSON.stringify(evento));  //Cria cópia do objeto evento
		modalIndex = eventos.indexOf(evento);
		$('#modal-edita-evento').modal('show');
	}

	$scope.confirmarRemocaoEvento = function(evento) {
		$scope.modalData = JSON.parse(JSON.stringify(evento));  //Cria cópia do objeto evento
		modalIndex = eventos.indexOf(evento);
		$('#modal-deleta-evento').modal('show');
	}

	$scope.atualizarEvento = function(modalData) {
		eventos[modalIndex] = modalData;
		$('#modal-edita-evento').on('hidden.bs.modal', function(e) {
			$('#modal-confirma-edicao').modal('show');
			$('#modal-edita-evento').off('hidden.bs.modal');
		});
		$('#modal-edita-evento').modal('hide');
	}

	$scope.deletarEvento = function(evento) {
		var index;
		for(var i = 0; i < eventos.length; i++) {
			if(eventos[i].codigo == evento.codigo) {
				index = i;
				break;
			}
		}
		eventos.splice(index, 1);

		$('#modal-deleta-evento').on('hidden.bs.modal', function(e) {
			$('#modal-confirma-remocao').modal('show');
			$('#modal-deleta-evento').off('hidden.bs.modal');
		});
		$('#modal-deleta-evento').modal('hide');
	} */
});

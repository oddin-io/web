app.controller("atribuicaoCtrl", function($scope){
	var salas_horarios_cadastrados = [{id:'001', dia:'Domingo', hora_ini:'14:30', hora_fim:'15:00', predio:'AT-00', sala:401},
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

  var salas_horarios = [{id:'012', dia:'Domingo', hora_ini:'14:30', hora_fim:'15:00', predio:'AT-00', sala:430},
              {id:'013', dia:'Segunda', hora_ini:'15:30', hora_fim:'22:00', predio:'AT-04', sala:302},
              {id:'014', dia:'Terça', hora_ini:'14:00', hora_fim:'00:00', predio:'AT-07', sala:257},
              {id:'015', dia:'Quarta', hora_ini:'18:00', hora_fim:'18:00', predio:'AT-10', sala:110},
              {id:'016', dia:'Quinta', hora_ini:'22:30', hora_fim:'15:00', predio:'AT-11', sala:120},
              {id:'017', dia:'Sexta', hora_ini:'20:30', hora_fim:'19:00', predio:'AT-05', sala:230},
              {id:'018', dia:'Sábado', hora_ini:'10:15', hora_fim:'21:00', predio:'AT-06', sala:350},
              {id:'019', dia:'Domingo', hora_ini:'16:30', hora_fim:'23:00', predio:'AT-13', sala:422},
              {id:'020', dia:'Segunda', hora_ini:'17:45', hora_fim:'02:00', predio:'AT-21', sala:551},
              {id:'021', dia:'Terça', hora_ini:'23:30', hora_fim:'03:00', predio:'AT-07', sala:607},
              {id:'022', dia:'Quarta', hora_ini:'17:30', hora_fim:'05:00', predio:'AT-08', sala:155}];

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

	var usuarios = [{id:'012', nome:'Armando', estado:'São Paulo', pais:'Brasil', email:'joao@joao.com', senha:'1111', status:0},
					{id:'013', nome:'Alfredo', estado:'São Paulo', pais:'Brasil', email:'jose@joao.com', senha:'1111', status:1},
					{id:'014', nome:'Bruno', estado:'São Paulo', pais:'Brasil', email:'joaquim@joao.com', senha:'1111', status:0},
					{id:'015', nome:'Carlos', estado:'São Paulo', pais:'Brasil', email:'jonas@joao.com', senha:'1111', status:1},
					{id:'016', nome:'Daniel', estado:'São Paulo', pais:'Brasil', email:'maria@joao.com', senha:'1111', status:0},
					{id:'017', nome:'Danielle', estado:'São Paulo', pais:'Brasil', email:'mar@joao.com', senha:'1111', status:1},
					{id:'018', nome:'Érica', estado:'São Paulo', pais:'Brasil', email:'mary@joao.com', senha:'1111', status:0},
					{id:'019', nome:'Fabiana', estado:'São Paulo', pais:'Brasil', email:'marcia@joao.com', senha:'1111', status:1},
					{id:'020', nome:'Helena', estado:'São Paulo', pais:'Brasil', email:'lene@joao.com', senha:'1111', status:0},
					{id:'021', nome:'Kelly', estado:'São Paulo', pais:'Brasil', email:'chico@joao.com', senha:'1111', status:1},
					{id:'022', nome:'Tatiana', estado:'São Paulo', pais:'Brasil', email:'francine@joao.com', senha:'1111', status:0}];

	$scope.salas_horarios_cadastrados = salas_horarios_cadastrados;
  $scope.salas_horarios = salas_horarios;
	$scope.usuarios_matriculados = usuarios_matriculados;
	$scope.usuarios = usuarios;
  $scope.modalData;
  $scope.selected;

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

  $scope.selecionarTodos = function() {
    var button_icon = document.getElementById("select-all");

    if(button_icon.getAttribute("class") == "fa fa-circle-o") {
      for(var i = 0; i < usuarios.length; i++)
      {

        if(selecionados.indexOf(usuarios[i]) == -1 && usuarios[i].status == 0) {
          var icon = document.getElementById(usuarios[i].id);
          selecionados.push(usuarios[i]);
          icon.classList.remove('fa-circle-o');
          icon.classList.add('fa-check-circle-o');
        }
      }
      button_icon.classList.remove('fa-circle-o');
      button_icon.classList.add('fa-check-circle-o');
    } else {
      selecionados = [];
      for(var i = 0; i < usuarios.length; i++) {
        if(usuarios[i].status == 0) {
          var icon = document.getElementById(usuarios[i].id);
          icon.classList.remove('fa-check-circle-o');
          icon.classList.add('fa-circle-o');
        }
      }
      button_icon.classList.remove('fa-check-circle-o');
      button_icon.classList.add('fa-circle-o');
    }
  }

  $scope.incluirProfessores = function() {
    for(var i = 0; i < selecionados.length; i++) {
      usuarios_matriculados.push(selecionados[i]);
      if(usuarios.indexOf(selecionados[i]) != -1)
      {
        var index = usuarios.indexOf(selecionados[i]);
        usuarios.splice(index, 1);
      }
    }
    selecionados = [];

    $('#modal-atribui-professor').on('hidden.bs.modal', function(e) {
      $('#modal-confirma-adicao').modal('show');
      $('#modal-atribui-professor').off('hidden.bs.modal');
    });
    $('#modal-atribui-professor').modal('hide');
  }

  $scope.incluirAlunos = function() {
    for(var i = 0; i < selecionados.length; i++) {
      usuarios_matriculados.push(selecionados[i]);
      if(usuarios.indexOf(selecionados[i]) != -1)
      {
        var index = usuarios.indexOf(selecionados[i]);
        usuarios.splice(index, 1);
      }
    }
    selecionados = [];

    $('#modal-atribui-aluno').on('hidden.bs.modal', function(e) {
      $('#modal-confirma-adicao').modal('show');
      $('#modal-atribui-aluno').off('hidden.bs.modal');
    });
    $('#modal-atribui-aluno').modal('hide');
  }


  $scope.confirmarRemocaoUsuario = function(usuario) {
    $scope.modalData = usuario;
    $('#modal-deleta-usuario').modal('show');
  }

  $scope.removerUsuario = function(modalData) {
    var index = usuarios_matriculados.indexOf(modalData);
    usuarios_matriculados.splice(index, 1);
    usuarios.push(modalData);

    $('#modal-deleta-usuario').on('hidden.bs.modal', function(e) {
      $('#modal-confirma-remocao').modal('show');
      $('#modal-deleta-usuario').off('hidden.bs.modal');
    });
    $('#modal-deleta-usuario').modal('hide');
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

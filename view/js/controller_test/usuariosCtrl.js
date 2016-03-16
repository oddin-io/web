app.controller("usuariosCtrl", function($scope){
	var usuarios = [{id:'001', nome:'João', estado:'São Paulo', pais:'Brasil', email:'joao@joao.com', senha:'1111', status:0},
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

	$scope.usuarios = usuarios;
	$scope.modalData;
	var modalIndex;

	$scope.editarUsuario = function(usuario) {
		$scope.modalData = JSON.parse(JSON.stringify(usuario));
		modalIndex = usuarios.indexOf(usuario);
		$('#modal-edita-usuario').modal('show');
	}

	$scope.atualizarUsuario = function(modalData) {
		usuarios[modalIndex] = modalData;
		$('#modal-edita-usuario').on('hidden.bs.modal', function(e) {
			$('#modal-confirma-edicao').modal('show');
			$('#modal-edita-usuario').off('hidden.bs.modal');
		});
		$('#modal-edita-usuario').modal('hide');
	}	

	$scope.confirmarRemocaoUsuario = function(usuario) {
		$scope.modalData = JSON.parse(JSON.stringify(usuario));
		modalIndex = usuarios.indexOf(usuario);
		$('#modal-deleta-usuario').modal('show');
	}

	$scope.deletarUsuario = function(usuario) {
		var index;
		for(var i = 0; i < usuarios.length; i++) {
			if(usuarios[i].id == usuario.id) {
				index = i;
				break;
			}
		}		
		usuarios.splice(index, 1);
		$('#modal-deleta-usuario').on('hidden.bs.modal', function(e) {
			$('#modal-confirma-remocao').modal('show');
			$('#modal-deleta-usuario').off('hidden.bs.modal');
		});
		$('#modal-deleta-usuario').modal('hide');
	}	
});
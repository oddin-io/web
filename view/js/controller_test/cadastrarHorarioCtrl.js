app.controller("cadastrarHorarioCtrl", function($scope){
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

	$scope.horarios = horarios;
	$scope.modalData;	

	$scope.cadastrarHorario = function(horario) {
		horarios.push(horario);			
		delete $scope.horario;
		$('#modal-confirma-cadastro').modal('show');		
	}

	$scope.confirmaDeletaHorario = function(horario) {
		$scope.modalData = horario;	
		$('#modal-deleta-horario').modal('show');	
	}

	$scope.deletarHorario = function(horario) {
		var index = horarios.indexOf(horario);
		horarios.splice(index, 1);
		$('#modal-deleta-horario').on('hidden.bs.modal', function(e) {
			$('#modal-confirma-remocao').modal('show');
			$('#modal-deleta-horario').off('hidden.bs.modal');
		});
		$('#modal-deleta-horario').modal('hide');		
	}	
});
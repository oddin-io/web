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
          {dia:'Sabado', inicio:'11:00', fim:'13:00'}];

  $scope.horarios = horarios;
  $scope.horarios_disp = horarios_disponiveis;	
  $scope.modalData;

  $scope.confirmaRemoverHorarioDisp = function(horario) {
    $scope.modalData = horario;
    $('#modal-remove-horarioDisp').modal('show');
  }	

  $scope.removerHorarioDisp = function(horario) {
    var index = horarios_disponiveis.indexOf(horario);
    horarios_disponiveis.splice(index, 1);	
    horarios.push(horario);		
    
    $('#modal-remove-horarioDisp').on('hidden.bs.modal', function(e) {
      $('#modal-confirma-remocao').modal('show');
      $('#modal-remove-horarioDisp').off('hidden.bs.modal');
    });	
    $('#modal-remove-horarioDisp').modal('hide');
  }

  $scope.confirmaAdicionarHorario = function(horario) {
    $scope.modalData = horario;
    $('#modal-adiciona-horario').modal('show');		
  }

  $scope.adicionarHorario = function(horario) {			
    horarios_disponiveis.push(horario);	

    var index = horarios.indexOf(horario);
    horarios.splice(index, 1);	
    
    $('#modal-adiciona-horario').on('hidden.bs.modal', function(e) {
      $('#modal-confirma-adicao').modal('show');
      $('#modal-adiciona-horario').off('hidden.bs.modal');
    });
    $('#modal-adiciona-horario').modal('hide');		
    delete $scope.horario;
  }	
});

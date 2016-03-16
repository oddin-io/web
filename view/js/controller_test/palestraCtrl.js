app.controller("palestraCtrl", function($scope){
	var eventos = [{codigo:'001', nome:'Análise de Sistemas', carga:755},
					{codigo:'002', nome:'Engenharia Civil', carga:755},
					{codigo:'003', nome:'Medicina', carga:755},
					{codigo:'004', nome:'Enfermagem', carga:755},
					{codigo:'005', nome:'Administração', carga:755},
					{codigo:'006', nome:'Ciências Sociais', carga:755},
					{codigo:'007', nome:'Biologia', carga:755},
					{codigo:'008', nome:'Arquitetura', carga:755},
					{codigo:'009', nome:'Artes Plásticas', carga:755},
					{codigo:'010', nome:'Engenharia Naval', carga:755}];

	var palestra = {codigo:'134', nome:'Matemática básica', carga:85};

	$scope.palestra = palestra;
	$scope.eventos = eventos;
	$scope.modalData;	

	$scope.confirmarRemocaoEvento = function(evento) {
		$scope.modalData = JSON.parse(JSON.stringify(evento));  //Cria cópia do objeto evento	
		$('#modal-deleta-evento').modal('show');	
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
	}	
});
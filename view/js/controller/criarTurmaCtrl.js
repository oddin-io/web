app.controller("criarTurmaCtrl", function($scope){
	var turmas = [{id:'1', nome:'Turma 001', status:0},
						{id:'2', nome:'Turma 002', status:1},
						{id:'3', nome:'Turma 003', status:0},
						{id:'4', nome:'Turma 004', status:0},
						{id:'5', nome:'Turma 005', status:1},
						{id:'6', nome:'Turma 006', status:1},
						{id:'7', nome:'Turma 007', status:1},
						{id:'8', nome:'Turma 008', status:0},
						{id:'9', nome:'Turma 009', status:0},
						{id:'10', nome:'Turma 010', status:1},
						{id:'11', nome:'Turma 011', status:0},
						{id:'12', nome:'Turma 012', status:1},
						{id:'13', nome:'Turma 013', status:0},
						{id:'14', nome:'Turma 014', status:0},
						{id:'15', nome:'Turma 015', status:0},
						{id:'16', nome:'Turma 016', status:1},
						{id:'17', nome:'Turma 017', status:0},
						{id:'18', nome:'Turma 018', status:0},
						{id:'19', nome:'Turma 019', status:1},
						{id:'20', nome:'Turma 020', status:0}];

	$scope.turmas = turmas;
	$scope.modalData;
	$scope.modalIndex;

	$scope.criarTurma = function(turma) {
		turma.status = 0;
		turma.id = parseInt(turmas[turmas.length-1].id) + 1;
		turmas.push(turma);
		delete $scope.turma;
	};

	$scope.deletarTurma = function(turma) {		
		var index = turmas.indexOf(turma);
		turmas.splice(index, 1);		
	};

	$scope.editarTurma = function(turma) {
		$scope.modalData = turma;
		$scope.modalIndex = turmas.indexOf(turma);
	}	

	$scope.atualizarTurma = function(modalData) {
		turmas[$scope.modalIndex] = modalData;		
	};
});
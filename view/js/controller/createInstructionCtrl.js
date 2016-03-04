app.controller("createInstructionCtrl", function($scope){
	var instructions = [{id:'001', turma:'Turma 001', status:0},
						{id:'002', turma:'Turma 002', status:1},
						{id:'003', turma:'Turma 003', status:0},
						{id:'004', turma:'Turma 004', status:0},
						{id:'005', turma:'Turma 005', status:1},
						{id:'006', turma:'Turma 006', status:1},
						{id:'007', turma:'Turma 007', status:1},
						{id:'008', turma:'Turma 008', status:0},
						{id:'009', turma:'Turma 009', status:0},
						{id:'010', turma:'Turma 010', status:1},
						{id:'011', turma:'Turma 011', status:0},
						{id:'012', turma:'Turma 012', status:1},
						{id:'013', turma:'Turma 013', status:0},
						{id:'014', turma:'Turma 014', status:0},
						{id:'015', turma:'Turma 015', status:0},
						{id:'016', turma:'Turma 016', status:1},
						{id:'017', turma:'Turma 017', status:0},
						{id:'018', turma:'Turma 018', status:0},
						{id:'019', turma:'Turma 019', status:1},
						{id:'020', turma:'Turma 020', status:0}];

	$scope.instructions = instructions;
	$scope.modalData;

	$scope.criarInstrucao = function(instruction) {
		instruction.status = 0;
		instructions.push(instruction);
		delete $scope.instruction;
	};

	$scope.deletarInstrucao = function(instruction) {
		var index = instructions.indexOf(instruction);
		instructions.splice(index, 1);
	};

	$scope.editarInstrucao = function(instruction) {
		$scope.modalData = instruction;
	};

	$scope.atualizarInstrucao = function(modalData) {
		var index = instructions.indexOf()
	};
});
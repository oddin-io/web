var disciplinas = [
    {"_id": 1, "nome": "Lógica de Programação", "turma": "630", "aulas": [
        {"_id": 1, "nome": "Aula 1"},
        {"_id": 2, "nome": "Aula 2"},
        {"_id": 3, "nome": "Aula 3"}
    ]},
    {"_id": 2, "nome": "Banco de Dados I", "turma": "629"},
    {"_id": 3, "nome": "Projeto II", "turma": "640"}
];

module.exports = function() {
    var controller = {
        listaDisciplinas: function (req, res) {
            res.json(disciplinas);
        },
        listaAulas: function(req, res) {
            var _id = req.params.id;
            var disciplina;
            for(var i = 0; i < disciplinas.length; i++) {
                if(disciplinas[i]._id == _id)
                {
                    disciplina = disciplinas[i];
                }
            }
            res.json(disciplina);
        }
    };
    return controller;
}

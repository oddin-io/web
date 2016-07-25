var disciplinas = [
    {"_id": 1, "nome": "Lógica de Programação", "turma": "630", "aulas": [
        {"_id": 1, "nome": "Aula 1", "status": 0, "date": '31/12/2015', "time":"18:45"},
        {"_id": 2, "nome": "Aula 2", "status": 0, "date": '27/13/2016', "time":"09:30"},
        {"_id": 3, "nome": "Aula 3", "status": 1, "date": '25/04/1999', "time":"13:15"}
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

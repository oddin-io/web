var disciplinas = [
    {"_id": 1, "nome": "Lógica de Programação", "turma": "630",
        "aulas": [
            {"_id": 1, "nome": "Aula 1", "status": 0, "date": '31/12/2015', "time":"18:45"},
            {"_id": 2, "nome": "Aula 2", "status": 0, "date": '27/13/2016', "time":"09:30"},
            {"_id": 3, "nome": "Aula 3", "status": 1, "date": '25/04/1999', "time":"13:15"}
        ],
        "materiais": [
            {"_id": 1, "nome": "teste1.jpeg", "mime":"image/jpeg"},
            {"_id": 2, "nome": "teste2.jpeg", "mime":"image/jpeg"},
            {"_id": 3, "nome": "teste3.jpeg", "mime":"image/jpeg"}
        ],
        "participantes": [
            {"_id": 1, "nome": "João", "online": 1},
            {"_id": 2, "nome": "Maria", "online": 1},
            {"_id": 3, "nome": "Pedro", "online": 0},
            {"_id": 4, "nome": "Fernando", "online": 1},
            {"_id": 5, "nome": "Luíza", "online": 0}
        ]
    },
    {"_id": 2, "nome": "Banco de Dados I", "turma": "629"},
    {"_id": 3, "nome": "Projeto II", "turma": "640"}
];

module.exports = function() {
    var controller = {
        listaDisciplinas: function (req, res) {
            res.json(disciplinas);
        },
        mostraInfoDisciplina: function (req, res) {
            var _id = req.params.id;
            var disciplina = {};
            for(var i = 0; i < disciplinas.length; i++) {
                if(disciplinas[i]._id == _id) {
                    disciplina = disciplinas[i];
                    break;
                }
            }
            res.json(disciplina);
        },
        listaAulas: function(req, res) {
            var _id = req.params.id;
            var aulas;
            for(var i = 0; i < disciplinas.length; i++) {
                if(disciplinas[i]._id == _id)
                {
                    aulas = disciplinas[i].aulas;
                    break;
                }
            }
            res.json(aulas);
        },
        listaMateriais: function(req, res) {
            var _id = req.params.id;
            var materiais;
            for(var i = 0; i < disciplinas.length; i++) {
                if(disciplinas[i]._id == _id)
                {
                    materiais = disciplinas[i].materiais;
                    break;
                }
            }
            res.json(materiais);
        },
        listaParticipantes: function(req, res) {
            var _id = req.params.id;
            var participantes;
            for(var i = 0; i < disciplinas.length; i++) {
                if(disciplinas[i]._id == _id)
                {
                    participantes = disciplinas[i].participantes;
                    break;
                }
            }
            res.json(participantes);
        }
    };
    return controller;
}

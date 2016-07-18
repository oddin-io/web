var disciplinas = [
    {"nome": "Lógica de Programação", "turma": "630"},
    {"nome": "Banco de Dados I", "turma": "629"},
    {"nome": "Projeto II", "turma": "640"}
];

module.exports = function() {
    var controller = {
        listaDisciplinas: function (req, res) {
            res.json(disciplinas);
        }
    };
    return controller;
}

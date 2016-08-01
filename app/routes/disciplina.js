module.exports = function(app) {
    var controller = app.controllers.disciplina;
    app.get('/disciplinas', controller.listaDisciplinas);
    app.get('/disciplinas/:id', controller.mostraInfoDisciplina);
    app.get('/disciplinas/:id/aulas', controller.listaAulas);
    app.get('/disciplinas/:id/materiais', controller.listaMateriais);
    app.get('/disciplinas/:id/participantes', controller.listaParticipantes);
}

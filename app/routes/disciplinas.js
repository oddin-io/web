module.exports = function(app) {
    var controller = app.controllers.disciplinas;
    app.get('/disciplinas', controller.listaDisciplinas);
    app.get('/disciplinas/:id/aulas', controller.listaAulas);
    app.get('/disciplinas/:id/materiais', controller.listaMateriais);
    app.get('/disciplinas/:id/participantes', controller.listaParticipantes);
}

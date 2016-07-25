module.exports = function(app) {
    var controller = app.controllers.disciplinas;
    app.get('/disciplinas', controller.listaDisciplinas);
    app.get('/disciplinas/:id', controller.listaAulas);
}

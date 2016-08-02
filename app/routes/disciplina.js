module.exports = function(app) {
    var controller = app.controllers.disciplina;
    app.get('/instructions', controller.listaDisciplinas);
    app.get('/instructions/:id', controller.mostraInfoDisciplina);
};

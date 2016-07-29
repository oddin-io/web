module.exports = function(app) {
    var controller = app.controllers.aulas;
    app.get('/aulas/:id', controller.listaDuvidas);
}

module.exports = function(app) {
    var controller = app.controllers.aula;
    app.get('/presentations', controller.listaAulas);
    //app.get('/aulas/:id', controller.listaDuvidas);
}

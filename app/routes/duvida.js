module.exports = function(app) {
  var controller = app.controllers.duvida;
  app.get('/questions', controller.listaDuvidas);
};

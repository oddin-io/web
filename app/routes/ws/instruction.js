module.exports = function (app) {
  var controller = app.controllers.ws.instruction;

  app.get('/api/instructions', controller.index);
  app.get('/api/instructions/:id', controller.show);
  app.post('/api/instructions', controller.create);
  app.put('/api/instructions/:id', controller.update);
  app.delete('/api/instructions/:id', controller.destroy);
};

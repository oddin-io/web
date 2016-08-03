module.exports = function (app) {
  var controller = app.controllers.ws.material;

  app.get('/api/materials', controller.index);
  app.get('/api/materials/:id', controller.show);
  app.post('/api/materials', controller.create);
  app.put('/api/materials/:id', controller.update);
  app.delete('/api/materials/:id', controller.destroy);
};

module.exports = function (app) {
  var controller = app.controllers.ws.instruction;

  app.get('/api/instructions', controller.index);
  app.get('/api/instructions/:id', controller.show);
  app.post('/api/instructions', controller.create);
  app.put('/api/instructions/:id', controller.update);
  app.delete('/api/instructions/:id', controller.destroy);

  app.get('/api/instructions/:id/presentations', controller.showPresentations);
  app.post('/api/instructions/:id/presentations', controller.createPresentation);

  app.get('/api/instructions/:id/materials', controller.showMaterials);
  app.get('/api/instructions/:id/participants', controller.showParticipants);

  app.get('/api/instructions/:id/profile', controller.showProfile);
};

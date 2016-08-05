module.exports = function (app) {
  var controller = app.controllers.ws.answer;

  app.get('/api/questions/:id/answers', controller.index);
  app.get('/api/answers/:id', controller.show);
  app.post('/api/questions/:id/answers', controller.create);
  app.put('/api/answers/:id', controller.update);
  app.delete('/api/answers/:id', controller.destroy);
};

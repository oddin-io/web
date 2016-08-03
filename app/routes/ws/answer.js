module.exports = function (app) {
  var controller = app.controllers.ws.answer;

  app.get('/api/answers', controller.index);
  app.get('/api/answers/:id', controller.show);
  app.post('/api/answers', controller.create);
  app.put('/api/answers/:id', controller.update);
  app.delete('/api/answers/:id', controller.destroy);
};

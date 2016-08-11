module.exports = function (app) {
  var controller = app.controllers.ws.question;

  app.get('/api/questions', controller.index);
  app.get('/api/questions/:id', controller.show);
  app.post('/api/questions', controller.create);
  app.put('/api/questions/:id', controller.update);
  app.delete('/api/questions/:id', controller.destroy);
  app.post('/api/questions/:id/upvote', controller.upvote);
};

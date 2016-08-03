module.exports = function (app) {
  var controller = app.controllers.lecture;

  app.get('/lectures/:id', controller.index);
};

module.exports = function (app) {
  var controller = app.controllers.lecture;

  app.get('/lecture/:id', controller.index);
};

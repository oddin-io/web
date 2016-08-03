module.exports = function (app) {
  var controller = app.controllers.presentation;

  app.get('/presentations/:id', controller.index);
};

module.exports = function (app) {
  var controller = app.controllers.presentation;

  app.get('/presentation/:id', controller.index);
};

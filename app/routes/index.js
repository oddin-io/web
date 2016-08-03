module.exports = function (app) {
  var controller = app.controllers.index;

  app.get('/', controller.index);
  app.get('/recover-password', controller.recoverPassword);
};

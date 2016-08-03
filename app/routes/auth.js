module.exports = function (app) {
  var controller = app.controllers.auth;

  app.post('/login', controller.login);
  app.post('/logout', controller.logout)
};

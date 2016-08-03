module.exports = function (app) {
  var controller = app.controllers.home;

  app.get('/home', controller.index);
};

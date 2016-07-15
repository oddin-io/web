module.exports = function(app) {
    var controller = app.controllers.login;
    app.get('/', controller.start);
    app.post('/', controller.login);
}

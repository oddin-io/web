module.exports = function(app) {
    var controller = app.controllers.login;
    app.get('/', controller.start);
    app.get('/index', controller.app);
    app.post('/', controller.login);
    app.post('/loginTeste', controller.loginTest);
}

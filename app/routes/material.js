module.exports = function(app) {
    var controller = app.controllers.material;
    app.get('/materials', controller.listaMateriais);
};


module.exports = function() {
    var controller = {
        load: function(req, res) {
            res.render('index');
        }
    };
    return controller;
}

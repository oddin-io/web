var testAuth = false;
module.exports = function() {
    var controller = {
        start: function(req, res, next) {
            if(testAuth)
                return next();
            else
                res.render('login');
        },
        login: function(req, res, next) {
            console.log(req.body.email);
            console.log(req.body.senha);
            testAuth = true;
            res.end();
        }
    };
    return controller;
}

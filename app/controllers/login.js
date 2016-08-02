var testAuth = false;
var request = require('request');

module.exports = function() {
    var controller = {
        start: function(req, res, next) {
            if(testAuth)
                return next();
            else
                res.render('login');
        },
        app: function(req, res, next) {
            res.render('index');
        },
        login: function(req, res, next) {
            testAuth = true;
            res.end();
        },
        loginTest: function(req, res, next) {
            request(
                {
                    'uri': "http://rws-edupanel.herokuapp.com/session",
                    'method': "POST",
                    'form': {
                        'email': req.body.email,
                        'password': req.body.password
                    }
                }, function(error, response, body) {
                    if(response.statusCode == 401) {
                        res.status(401);
                        res.end();
                    }
                    else {
                        res.cookie(JSON.stringify(body));
                        res.end();
                        console.log("logado");
                    }
                }
            );
        }
    };
    return controller;
}

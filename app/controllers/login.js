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
            console.log(req.body.email);
            console.log(req.body.senha);
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
                    if(error) {
                        console.log(error);
                    } else {
                        res.json(JSON.parse(body));
                    }
                }
            );
        }
    };
    return controller;
}

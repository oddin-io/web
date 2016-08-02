var express = require('express');
var load = require('express-load');
var bodyParser = require('body-parser');
var cookieParser = require('cookie-parser');

module.exports = function() {
    var app = express();

    //configuração de ambiente
    app.set('port', 3000);
    app.set('view engine', 'ejs');
    app.set('views', './public/pages');

    //middleware
    app.use(express.static('./public'));
    app.use(bodyParser.urlencoded({extended: true}));
    app.use(bodyParser.json());
    app.use(require('method-override')());
    app.use(cookieParser());

    //express load
    load('controllers', {cwd: 'app'})
        .then('routes/login.js')
        .then('routes')
        .into(app);

    return app;
}
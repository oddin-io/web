var express = require('express')
  , load = require('express-load')
  , bodyParser = require('body-parser')
  , cookieParser = require('cookie-parser')
  , request = require('request');

module.exports = function () {
  var app = express();

  //configuração de ambiente
  app.set('port', 3000);
  app.set('view engine', 'ejs');
  app.set('views', 'public/pages');

  //middleware
  app.use(express.static('public'));
  app.use(bodyParser.urlencoded({extended: true}));
  app.use(bodyParser.json());
  app.use(require('method-override')());
  app.use(cookieParser());

  //express load
  load('utils', {cwd: 'app'})
    .then('controllers')
    .then('routes')
    .into(app);

  return app;
};

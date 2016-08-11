var express = require('express')
  , load = require('express-load')
  , bodyParser = require('body-parser')
  , cookieParser = require('cookie-parser')
  , request = require('request');

module.exports = function () {
  var app = express();

  //configuração de ambiente
  app.set('port', (process.env.PORT || 3000));
  app.set('view engine', 'ejs');
  app.set('views', 'public/pages');

  //middleware
  app.use(express.static('public'));
  app.use(bodyParser.urlencoded({extended: true}));
  app.use(bodyParser.json());
  app.use(require('method-override')());
  app.use(cookieParser());
  // Auth middleware
  // app.use(function (req, res, next) {
  //   if (req.url == '/') {
  //     next();
  //     return;
  //   }
  //
  //   if (!req.cookies.session || !req.cookies.session.token) {
  //     res.redirect('/');
  //     return;
  //   }
  //
  //   var token = req.cookies.session.token;
  //   request(
  //       {
  //         uri: app.utils.constants.ws.uri + '/session',
  //         method: 'GET',
  //         headers: {
  //           'x-session-token': token
  //         }
  //       }, function (error, response, body) {
  //         if (response.statusCode == 401) {
  //           res.status(401);
  //           res.end();
  //         } else {
  //           next();
  //         }
  //       }
  //   );
  // });
  // Redirect middleware
  app.use(function (req, res, next) {
    if (req.url != '/') {
      next();
      return;
    }

    if (!req.cookies.session || !req.cookies.session.token) {
      next();
      return;
    }

    var token = req.cookies.session.token;
    request(
        {
          uri: app.utils.constants.ws.uri + '/session',
          method: 'GET',
          headers: {
            'x-session-token': token
          }
        }, function (error, response, body) {
          if (response.statusCode == 401) {
            res.redirect('/');
            res.end();
          } else {
            res.redirect('/home');
            next();
          }
        }
    );
  });

  //express load
  load('utils', {cwd: 'app'})
    .then('controllers')
    .then('routes')
    .into(app);

  return app;
};

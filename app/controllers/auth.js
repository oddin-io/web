var request = require('request');

function login(req, res, next) {
  request(
    {
      uri: app.utils.constants.ws.uri + "/session",
      method: 'POST',
      json: {
        email: req.body.email,
        password: req.body.password
      }
    }, function (error, response, body) {
      if (response.statusCode == 401) {
        res.status(401);
        res.end();
      } else if(response.statusCode == 404) {
        res.status(404);
        res.end();
      }
      else {
        res.cookie('session', body);
        res.end();
      }
    }
  );
}

function logout(req, res, next) {
  var session = req.cookies.session;
  request(
      {
        uri: app.utils.constants.ws.uri + "/session",
        method: 'DELETE',
        headers: {
          'x-session-token': session.token
        }
      }, function (error, response, body) {
        if (response.statusCode == 401) {
          res.status(401);
          res.end();
        }
        else {
          res.status(204);
          res.end();
        }
      }
  );
}

module.exports = function() {
  return {
    login: login,
    logout: logout
  };
};

var request = require('request'),
    app = undefined;

function index(req, res, next) {
    var session = req.cookies.session;
    request(
        {
            uri: app.utils.constants.ws.uri + '/questions/' + req.params.id + '/answers',
            method: 'GET',
            headers: {
                'x-session-token': session.token
            }
        }, function(error, response, body) {
            if(response.statusCode == 401) {
                res.status(401);
                res.end();
            } else {
                res.json(JSON.parse(body));
            }
        }
    );
}

function show(req, res, next) {
  var session = req.cookies.session;
  request(
      {
        uri: app.utils.constants.ws.uri + '/answers/' + req.params.id,
        method: 'GET',
        headers: {
          'x-session-token': session.token
        }
      }, function (error, response, body) {
        if (response.statusCode == 401) {
          res.status(401);
          res.end();
        }
        else {
          res.json(JSON.parse(body));
        }
      }
  );
}

function create(req, res, next) {
    var session = req.cookies.session;
    request(
        {
            uri: app.utils.constants.ws.uri + '/questions/' + req.params.id + '/answers',
            method: 'POST',
            headers: {
                'x-session-token': session.token
            },
            json: {
                text: req.body.text
            }
        }, function (error, response, body) {
            if (response.statusCode == 401) {
                res.status(401);
                res.end();
            }
            else {
                res.json(body);
            }
        }
    );
}

function update(req, res, next) {

}

function destroy(req, res, next) {

}

module.exports = function (application) {
  app = application;

  return {
    index: index,
    show: show,
    create: create,
    update: update,
    destroy: destroy
  };
};

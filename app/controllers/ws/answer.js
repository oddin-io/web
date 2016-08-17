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

function upvote(req, res, next) {
    var session = req.cookies.session;
    request(
        {
            uri: app.utils.constants.ws.uri + '/answers/' + req.params.id + '/upvote',
            method: 'POST',
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

function downvote(req, res, next) {
    var session = req.cookies.session;
    request(
        {
            uri: app.utils.constants.ws.uri + '/answers/' + req.params.id + '/downvote',
            method: 'POST',
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

function cancelvote(req, res, next) {
    var session = req.cookies.session;
    request(
        {
            uri: app.utils.constants.ws.uri + '/answers/' + req.params.id + '/vote',
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
                res.end();
            }
        }
    );
}

function accept(req, res, next) {
    var session = req.cookies.session;
    request(
        {
            uri: app.utils.constants.ws.uri + '/answers/' + req.params.id + '/accept',
            method: 'POST',
            headers: {
                'x-session-token': session.token
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
    )
}

function unaccept(req, res, next) {
    var session = req.cookies.session;
    request(
        {
            uri: app.utils.constants.ws.uri + '/answers/' + req.params.id + '/accept',
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
                res.json(body);
            }
        }
    )
}

module.exports = function (application) {
  app = application;

  return {
    index: index,
    show: show,
    create: create,
    update: update,
    destroy: destroy,
    upvote: upvote,
    downvote: downvote,
    cancelvote: cancelvote,
    accept: accept,
    unaccept: unaccept
  };
};

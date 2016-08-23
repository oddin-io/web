var request = require('request');

function index(req, res) {
  res.json(duvidas);
}

function index(req, res, next) {

}

function show(req, res, next) {

}

function create(req, res, next) {

}

function update(req, res, next) {

}

function destroy(req, res, next) {

}

function upvote(req, res, next) {
  var session = req.cookies.session;
  request(
      {
        uri: app.utils.constants.ws.uri + '/questions/' + req.params.id + '/upvote',
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
            uri: app.utils.constants.ws.uri + '/questions/' + req.params.id + '/vote',
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

module.exports = function (app) {
  return {
    index: index,
    show: show,
    create: create,
    update: update,
    destroy: destroy,
    upvote: upvote,
    cancelvote: cancelvote
  };
};

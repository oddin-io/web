var request = require('request');

function index(req, res, next) {

}

function show(req, res, next) {
  var session = req.cookies.session;
  request(
      {
        uri: app.utils.constants.ws.uri + '/presentations/' + req.params.id,
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

}

function update(req, res, next) {

}

function destroy(req, res, next) {

}

function close(req, res, next) {
  var session = req.cookies.session;
  request(
      {
        uri: app.utils.constants.ws.uri + '/presentations/' + req.params.id + '/close',
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
          res.end();
        }
      }
  );
}

function showQuestions(req, res, next){
  var session = req.cookies.session;
  request(
      {
        uri: app.utils.constants.ws.uri + '/presentations/' + req.params.id + '/questions',
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

function postQuestion(req, res, next){
  var session = req.cookies.session;
  request(
      {
        uri: app.utils.constants.ws.uri + '/presentations/' + req.params.id + '/questions',
        method: 'POST',
        headers: {
          'x-session-token': session.token
        },
        json: {
          text: req.body.text,
          anonymous: req.body.anonymous
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

module.exports = function (app) {
  return {
    index: index,
    show: show,
    create: create,
    update: update,
    destroy: destroy,
    close: close,
    showQuestions: showQuestions,
    postQuestion: postQuestion
  };
};

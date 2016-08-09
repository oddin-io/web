var request = require('request');

function index(req, res, next) {
}

function show(req, res, next) {
  var session = req.cookies.session;
  request(
      {
        uri: app.utils.constants.ws.uri + '/materials/' + req.params.id,
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

module.exports = function (app) {
  return {
    index: index,
    show: show,
    create: create,
    update: update,
    destroy: destroy
  };
};

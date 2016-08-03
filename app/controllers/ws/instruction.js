var request = require('request');
  app = undefined;

function index(req, res, next) {
  var session = req.cookies.session;

  request(
    {
      uri: app.utils.constants.ws.uri + '/instructions',
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

function show(req, res, next) {

}

function create(req, res, next) {

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

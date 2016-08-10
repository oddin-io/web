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
    var session = req.cookies.session;
    console.log(req.body.name + " - " + req.body.mime);
    request(
        {
            uri: app.utils.constants.ws.uri + '/materials/' + req.params.id,
            method: 'PUT',
            headers: {
                'x-session-token': session.token
            },
            json: {
                'name': req.body.name,
                'mime': req.body.mime
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

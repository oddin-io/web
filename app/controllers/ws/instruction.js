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
  var session = req.cookies.session;

  request(
      {
        uri: app.utils.constants.ws.uri + '/instructions/' + req.params.id,
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

function showPresentations(req, res, next) {
  var session = req.cookies.session;
  request(
      {
        uri: app.utils.constants.ws.uri + '/instructions/' + req.params.id + '/presentations',
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

function createPresentation(req, res, next) {
    var session = req.cookies.session;
    request(
        {
            uri: app.utils.constants.ws.uri + '/instructions/' + req.params.id + '/presentations',
            method: 'POST',
            headers: {
                'x-session-token': session.token
            },
            json: {
                subject: req.body.subject
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

function createMaterial(req, res, next) {
    console.log('criar material');
    var session = req.cookies.session;
    request(
        {
            uri: app.utils.constants.ws.uri + '/instructions/' + req.params.id + '/materials/new',
            method: 'GET',
            headers: {
                'x-session-token': session.token
            }
        }, function(error, response, body) {
            if(response.statusCode == 401) {
                res.status(401);
                res.end();
            } else if(response.statusCode == 404) {
                res.status(404);
                res.end();
            } else {
                res.json(JSON.parse(body));
            }
        }
    )
}

function showMaterials(req, res, next) {
    var session = req.cookies.session;
    request(
        {
            uri: app.utils.constants.ws.uri + '/instructions/' + req.params.id + '/materials',
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

function showParticipants(req, res, next) {
    var session = req.cookies.session;
    request(
        {
            uri: app.utils.constants.ws.uri + '/instructions/' + req.params.id + '/participants',
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

function showProfile(req, res, next) {
    var session = req.cookies.session;

    request(
        {
            uri: app.utils.constants.ws.uri + '/instructions/' + req.params.id + '/profile',
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

module.exports = function (application) {
  app = application;

  return {
    index: index,
    show: show,
    create: create,
    update: update,
    destroy: destroy,
    showPresentations: showPresentations,
    createPresentation: createPresentation,
    createMaterial: createMaterial,
    showMaterials: showMaterials,
    showParticipants: showParticipants,
    showProfile: showProfile
  };
};

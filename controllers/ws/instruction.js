const request = require('request')
const constants = require('../../config/constants')

function index(req, res) {
  const session = req.cookies.session

  request({
    uri: `${constants.uri}/instructions`,
    method: 'GET',
    headers: {
      'x-session-token': session.token,
    },
  }, function responseHandler(error, response, body) {
    if (response.statusCode === 401) {
      res.status(401)
      res.end()
    } else {
      res.json(JSON.parse(body))
    }
  })
}

function show(req, res) {
  const session = req.cookies.session

  request({
    uri: `${constants.uri}/instructions/${req.params.id}`,
    method: 'GET',
    headers: {
      'x-session-token': session.token,
    },
  }, function responseHandler(error, response, body) {
    if (response.statusCode === 401) {
      res.status(401)
      res.end()
    } else {
      res.json(JSON.parse(body))
    }
  })
}

function create() {}

function update() {}

function destroy() {}

function showPresentations(req, res) {
  const session = req.cookies.session

  request({
    uri: `${constants.uri}/instructions/${req.params.id}/presentations`,
    method: 'GET',
    headers: {
      'x-session-token': session.token,
    },
  }, function responseHandler(error, response, body) {
    if (response.statusCode === 401) {
      res.status(401)
      res.end()
    } else {
      res.json(JSON.parse(body))
    }
  })
}

function createPresentation(req, res) {
  const session = req.cookies.session

  request({
    uri: `${constants.uri}/instructions/${req.params.id}/presentations`,
    method: 'POST',
    headers: {
      'x-session-token': session.token,
    },
    json: {
      subject: req.body.subject,
    },
  }, function responseHandler(error, response) {
    if (response.statusCode === 401) {
      res.status(401)
      res.end()
    } else {
      res.end()
    }
  })
}

function createMaterial(req, res) {
  const session = req.cookies.session

  request(
    {
      uri: `${constants.uri}/instructions/${req.params.id}/materials/new`,
      method: 'GET',
      headers: {
        'x-session-token': session.token,
      },
    }, function responseHandler(error, response, body) {
    if (response.statusCode === 401) {
      res.status(401)
      res.end()
    } else if (response.statusCode === 404) {
      res.status(404)
      res.end()
    } else {
      res.json(JSON.parse(body))
    }
  })
}

function showMaterials(req, res) {
  const session = req.cookies.session

  request({
    uri: `${constants.uri}/instructions/${req.params.id}/materials`,
    method: 'GET',
    headers: {
      'x-session-token': session.token,
    },
  }, function responseHandler(error, response, body) {
    if (response.statusCode === 401) {
      res.status(401)
      res.end()
    } else {
      res.json(JSON.parse(body))
    }
  })
}

function showParticipants(req, res) {
  const session = req.cookies.session

  request({
    uri: `${constants.uri}/instructions/${req.params.id}/participants`,
    method: 'GET',
    headers: {
      'x-session-token': session.token,
    },
  }, function responseHandler(error, response, body) {
    if (response.statusCode === 401) {
      res.status(401)
      res.end()
    } else {
      res.json(JSON.parse(body))
    }
  })
}

function showProfile(req, res) {
  const session = req.cookies.session

  request({
    uri: `${constants.uri}/instructions/${req.params.id}/profile`,
    method: 'GET',
    headers: {
      'x-session-token': session.token,
    },
  }, function responseHandler(error, response, body) {
    if (response.statusCode === 401) {
      res.status(401)
      res.end()
    } else {
      res.json(JSON.parse(body))
    }
  })
}

module.exports = {
  index,
  show,
  create,
  update,
  destroy,
  showPresentations,
  createPresentation,
  createMaterial,
  showMaterials,
  showParticipants,
  showProfile,
}

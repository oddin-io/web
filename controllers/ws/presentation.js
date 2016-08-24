const request = require('request')
const constants = require('../../config/constants')

function index() {}

function show(req, res) {
  const session = req.cookies.session

  request({
    uri: `${constants.uri}/presentations/${req.params.id}`,
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

function closePresentation(req, res) {
  const session = req.cookies.session

  request({
    uri: `${constants.uri}/presentations/${req.params.id}/close`,
    method: 'POST',
    headers: {
      'x-session-token': session.token,
    },
  }, function responseHandler(error, response, body) {
    if (response.statusCode === 401) {
      res.status(401)
      res.end()
    } else {
      res.json(JSON.parse(body))
      res.end()
    }
  })
}

function showQuestions(req, res) {
  const session = req.cookies.session

  request({
    uri: `${constants.uri}/presentations/${req.params.id}/questions`,
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

function showMaterials(req, res) {
  const session = req.cookies.session

  request({
    uri: `${constants.uri}/presentations/${req.params.id}/materials`,
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

function createMaterial(req, res) {
  const session = req.cookies.session

  request({
    uri: `${constants.uri}/presentations/${req.params.id}/materials/new`,
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

function postQuestion(req, res) {
  const session = req.cookies.session

  request({
    uri: `${constants.uri}/presentations/${req.params.id}/questions`,
    method: 'POST',
    headers: {
      'x-session-token': session.token,
    },
    json: {
      text: req.body.text,
      anonymous: req.body.anonymous,
    },
  }, function responseHandler(error, response, body) {
    if (response.statusCode === 401) {
      res.status(401)
      res.end()
    } else {
      res.json(body)
    }
  })
}

module.exports = {
  index,
  show,
  create,
  update,
  destroy,
  closePresentation,
  showQuestions,
  postQuestion,
  showMaterials,
  createMaterial,
}

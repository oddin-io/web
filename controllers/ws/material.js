const request = require('request')
const constants = require('../../config/constants')

function index() {}

function show(req, res) {
  const session = req.cookies.session

  request({
    uri: `${constants.uri}/materials/${req.params.id}`,
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

function update(req, res) {
  const session = req.cookies.session

  request({
    uri: `${constants.uri}/materials/${req.params.id}`,
    method: 'PUT',
    headers: {
      'x-session-token': session.token,
    },
    json: {
      name: req.body.name,
      mime: req.body.mime,
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

function destroy() {}

module.exports = {
  index,
  show,
  create,
  update,
  destroy,
}

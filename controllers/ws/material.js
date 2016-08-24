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
  }).pipe(res)
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
  }).pipe(res)
}

function destroy() {}

module.exports = {
  index,
  show,
  create,
  update,
  destroy,
}

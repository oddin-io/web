const request = require('request')
const constants = require('../../config/constants')

function showMaterials(req, res) {
  const session = req.cookies.session
  request({
    uri: `${constants.uri}/submissions/${req.params.id}/materials`,
    method: 'GET',
    headers: {
      'x-session-token': session.token,
    }
  }).pipe(res)
}

function createMaterial(req, res) {
  const session = req.cookies.session
  request({
    uri: `${constants.uri}/submissions/${req.params.id}/materials`,
    method: 'POST',
    headers: {
      'x-session-token': session.token,
    }
  }).pipe(res)
}

function destroy(req, res) {
  const session = req.cookies.session
  request({
    uri: `${constants.uri}/submissions/${req.params.id}`,
    method: 'DELETE',
    headers: {
      'x-session-token': session.token,
    }
  }).pipe(res)
}

function update(req, res) {
  const session = req.cookies.session
  request({
    uri: `${constants.uri}/submissions/${req.params.id}`,
    method: 'PUT',
    headers: {
      'x-session-token': session.token,
    },
    json: {
      'text': req.body.text
    }
  }).pipe(res)
}

module.exports = {
  showMaterials,
  createMaterial,
  destroy,
  update
}

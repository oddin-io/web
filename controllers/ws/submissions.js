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

module.exports = {
  showMaterials,
  createMaterial
}

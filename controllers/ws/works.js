const request = require('request')
const constants = require('../../config/constants')

function createMaterial(req, res) {
  const session = req.cookies.session
  request({
    uri: `${constants.uri}/works/${req.params.id}/materials`,
    method: 'POST',
    headers: {
      'x-session-token': session.token,
    }
  }).pipe(res)
}

function showMaterials(req, res) {
  const session = req.cookies.session
  request({
    uri: `${constants.uri}/works/${req.params.id}/materials`,
    method: 'GET',
    headers: {
      'x-session-token': session.token,
    }
  }).pipe(res)
}

module.exports = {
  createMaterial,
  showMaterials
}

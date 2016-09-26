const request = require('request')
const constants = require('../../config/constants')

function index(req, res) {
  const session = req.cookies.session
  request({
    uri: `${constants.uri}/events`,
    method: 'GET',
    headers: {
      'x-session-token': session.token,
    },
  }).pipe(res)
}

function create(req, res) {
  const session = req.cookies.session
  request({
    uri: `${constants.uri}/events`,
    method: 'POST',
    headers: {
      'x-session-token': session.token,
    },
    json: {
      'code': req.body.code,
      'name': req.body.name,
      'workload': req.body.workload
    }
  }).pipe(res)
}

module.exports = {
  index,
  create
}

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

function update(req, res) {
  const session = req.cookies.session
	console.log(req.params);
  request({
    uri: `${constants.uri}/events/${req.params.id}`,
    method: 'PUT',
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

function destroy(req, res) {
  const session = req.cookies.session
  request({
    uri: `${constants.uri}/events/${req.params.id}`,
    method: 'DELETE',
    headers: {
      'x-session-token': session.token,
    }
  }).pipe(res)
}

module.exports = {
  index,
  create,
  destroy,
	update
}

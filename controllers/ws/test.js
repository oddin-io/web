const request = require('request')
const constants = require('../../config/constants')

function destroy(req, res) {
  const session = req.cookies.session
  request({
    uri: `${constants.uri}/tests/${req.params.id}`,
    method: 'DELETE',
    headers: {
      'x-session-token': session.token
    }
  }).pipe(res)
}

function update(req, res) {
  const session = req.cookies.session
  request({
    uri: `${constants.uri}/tests/${req.params.id}`,
    method: 'PUT',
    headers: {
      'x-session-token': session.token
    },
		json: {
			'title': req.body.title,
			'question': req.body.question,
			'alternatives': req.body.alternatives
    }
  }).pipe(res)
}

function close(req, res) {
  const session = req.cookies.session
  request({
    uri: `${constants.uri}/tests/${req.params.id}/close`,
    method: 'POST',
    headers: {
      'x-session-token': session.token
    }
  }).pipe(res)
}

module.exports = {
  destroy,
  update,
	close
}
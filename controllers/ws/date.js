const request = require('request')
const constants = require('../../config/constants')

function destroy(req, res) {
  const session = req.cookies.session
  request({
    uri: `${constants.uri}/dates/${req.params.id}`,
    method: 'DELETE',
    headers: {
      'x-session-token': session.token
    }
  }).pipe(res)
}

function update(req, res) {
  const session = req.cookies.session
  request({
    uri: `${constants.uri}/dates/${req.params.id}`,
    method: 'PUT',
    headers: {
      'x-session-token': session.token
    },
    json: {
      'subject': req.body.subject,
      'text': req.body.text,
      'date': req.body.date
    }
  }).pipe(res)
}

module.exports = {
  destroy,
  update
}

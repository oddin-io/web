const request = require('request')
const constants = require('../../config/constants')

function destroy(req, res) {
  const session = req.cookies.session
  request({
    uri: `${constants.uri}/faqs/${req.params.id}`,
    method: 'DELETE',
    headers: {
      'x-session-token': session.token,
    },
  }).pipe(res)
}

function update(req, res) {
  const session = req.cookies.session
  request({
    uri: `${constants.uri}/faqs/${req.params.id}`,
    method: 'PUT',
    headers: {
      'x-session-token': session.token,
    },
    json: {
      question: req.body.question,
      answer: req.body.answer,
    },
  }).pipe(res)
}

module.exports = {
  destroy,
  update,
}

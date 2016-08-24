const request = require('request')
const constants = require('../../config/constants')

function index() {}

function show() {}

function create() {}

function update() {}

function destroy() {}

function upvote(req, res) {
  const session = req.cookies.session

  request({
    uri: `${constants.uri}/questions/${req.params.id}/upvote`,
    method: 'POST',
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

function cancelvote(req, res) {
  const session = req.cookies.session

  request({
    uri: `${constants.uri}/questions/${req.params.id}/vote`,
    method: 'DELETE',
    headers: {
      'x-session-token': session.token,
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

module.exports = {
  index,
  show,
  create,
  update,
  destroy,
  upvote,
  cancelvote,
}

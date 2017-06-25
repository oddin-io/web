const request = require('request')
const constants = require('../../config/constants')

function choose(req, res) {
  const session = req.cookies.session
  request({
    uri: `${constants.uri}/alternatives/${req.params.id}/choose`,
    method: 'POST',
    headers: {
      'x-session-token': session.token,
    },
  }).pipe(res)
}

module.exports = {
  choose,
}

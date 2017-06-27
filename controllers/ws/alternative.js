const ws = require('../../services/webService')

function choose(req, res) {
  const session = req.cookies.session
  ws.authenticated({
    uri: `/alternatives/${req.params.id}/choose`,
    method: 'POST',
  }, session.token).pipe(res)
}

module.exports = {
  choose,
}

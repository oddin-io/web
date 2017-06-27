const ws = require('../../services/webService')

function choose(req, res) {
  const token = req.cookies.token
  ws.authenticated({
    uri: `/alternatives/${req.params.id}/choose`,
    method: 'POST',
  }, token).pipe(res)
}

module.exports = {
  choose,
}

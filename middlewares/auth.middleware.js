const request = require('request')

module.exports = function auth(req, res, next) {
  if (req.url === '/') {
    next()
    return
  }

  if (!req.cookies.session || !req.cookies.session.token) {
    res.redirect('/')
    return
  }

  const token = req.cookies.session.token
  request(
    {
      uri: app.utils.constants.ws.uri + '/session',
      method: 'GET',
      headers: {
        'x-session-token': token,
      },
    }, function responseHandler(error, response) {
    if (response.statusCode === 401) {
      res.status(401)
      res.end()
    } else {
      next()
    }
  })
}

const request = require('request')

module.exports = function redirect(req, res, next) {
  if (req.url !== '/') {
    next()
    return
  }

  if (!req.cookies.session || !req.cookies.session.token) {
    next()
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
      res.redirect('/')
      res.end()
    } else {
      res.redirect('/home')
      next()
    }
  }
  )
}

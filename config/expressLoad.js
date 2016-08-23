const load = require('express-load')

module.exports = function expressLoad(app) {
  load('utils', { cwd: 'app' })
    .then('controllers')
    .then('routes')
    .into(app)
}

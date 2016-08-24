const path = require('path')

module.exports = function variables(app) {
  app.set('views', path.join(__dirname, '../', 'views'))
  app.set('view engine', 'pug')
}

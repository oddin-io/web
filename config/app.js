const routes = require('./routes')

module.exports = function appConfig(app) {
  routes(app)
}

const middlewares = require('./middlewares')
const routes = require('./routes')

module.exports = function appConfig(app) {
  middlewares(app)
  routes(app)
}

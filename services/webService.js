const request = require('request')
const constants = require('../config/constants')

function authenticatedRequest(conf, sessionToken, handler) {
  const config = Object.assign(conf, {
    headers: {
      Authorization: sessionToken,
    },
  })

  return normalRequest(config, handler)
}

function normalRequest(conf, handler) {
  const config = Object.assign(conf, {
    uri: `${constants.uri}${conf.uri}`,
  })

  if (typeof handler === 'function') return request(config, handler)

  return request(config)
}

normalRequest.authenticated = authenticatedRequest

module.exports = normalRequest

const router = require('express').Router()
const constants = require('../config/constants')

router.get('/config', function customConfig(req, res) {
  res.jsonp(constants)
})

module.exports = router

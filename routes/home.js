const router = require('express').Router()
const controller = require('../controllers/home')

router.get('/home', controller.index)

module.exports = router

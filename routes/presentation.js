const router = require('express').Router()
const controller = require('../controllers/presentation')

router.get('/presentations/:id', controller.index)

module.exports = router

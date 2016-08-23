const router = require('express').Router()
const controller = require('../controllers/lecture')

router.get('/lectures/:id', controller.index)

module.exports = router

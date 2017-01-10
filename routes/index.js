const router = require('express').Router()
const controller = require('../controllers/index')

router.get('/', controller.index)
router.get('/recover-password', controller.recoverPassword)

module.exports = router

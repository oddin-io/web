const router = require('express').Router()
const controller = require('../controllers/auth')

router.post('/login', controller.login)
router.post('/logout', controller.logout)
router.post('/recover-password', controller.recoverPassword)

module.exports = router

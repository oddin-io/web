const router = require('express').Router()
const controller = require('../../controllers/ws/alternative')

router.post('/alternatives/:id/choose', controller.choose)

module.exports = router

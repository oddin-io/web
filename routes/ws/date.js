const router = require('express').Router()
const controller = require('../../controllers/ws/date')

router.delete('/dates/:id', controller.destroy)
router.put('/dates/:id', controller.update)

module.exports = router

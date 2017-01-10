const router = require('express').Router()
const controller = require('../../controllers/ws/person')

router.get('/person', controller.index)
router.post('/person', controller.create)
router.put('/person/:id', controller.update)
router.delete('/person/:id', controller.destroy)

module.exports = router

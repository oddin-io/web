const router = require('express').Router()
const controller = require('../../controllers/ws/event')

router.get('/events', controller.index)
router.post('/events', controller.create)
router.put('/events/:id', controller.update)
router.delete('/events/:id', controller.destroy)

module.exports = router

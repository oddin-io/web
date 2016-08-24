const router = require('express').Router()
const controller = require('../../controllers/ws/material')

router.get('/materials', controller.index)
router.get('/materials/:id', controller.show)
router.post('/materials', controller.create)
router.put('/materials/:id', controller.update)
router.delete('/materials/:id', controller.destroy)

module.exports = router

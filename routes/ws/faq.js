const router = require('express').Router()
const controller = require('../../controllers/ws/faq')

router.delete('/faqs/:id', controller.destroy)
router.put('/faqs/:id', controller.update)

module.exports = router

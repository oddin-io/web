const router = require('express').Router()
const controller = require('../../controllers/ws/works')

router.post('/works/:id/materials', controller.createMaterial)
router.get('/works/:id/materials', controller.showMaterials)

module.exports = router

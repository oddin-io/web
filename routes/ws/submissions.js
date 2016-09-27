const router = require('express').Router()
const controller = require('../../controllers/ws/submissions')

router.get('/submissions/:id/materials', controller.showMaterials)
router.post('/submissions/:id/materials', controller.createMaterial)

module.exports = router

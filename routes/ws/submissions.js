const router = require('express').Router()
const controller = require('../../controllers/ws/submissions')

router.get('/submissions/:id/materials', controller.showMaterials)
router.post('/submissions/:id/materials', controller.createMaterial)
router.put('/submissions/:id', controller.update)
router.delete('/submissions/:id', controller.destroy)

module.exports = router

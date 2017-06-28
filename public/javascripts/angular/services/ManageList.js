import oddin from '../app'

oddin.factory('ManageList', function () {
  var _updateItem = function (list, item) {
    var index = list.findIndex(function (element) {
      return element.id === item.id
    })
    list[index] = item
  }
  var _deleteItem = function (list, item) {
    var index = list.findIndex(function (element) {
      return element.id === item.id
    })
    list.splice(index, 1)
  }

  return {
    updateItem: _updateItem,
    deleteItem: _deleteItem,
  }
})

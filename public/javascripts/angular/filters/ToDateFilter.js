import oddin from '../app'

oddin.filter('toDate', function () {
  return function (date, time) {
    var day = parseInt(date.substring(0, 2), 10)
    var month = parseInt(date.substring(2, 4), 10) - 1
    var year = parseInt(date.substring(4, 8), 10)
    var hour = 0
    var minute = 0
    if (time) {
      hour = parseInt(time.substring(0, 2), 10)
      minute = parseInt(time.substring(2, 4), 10)
    }
    return new Date(year, month, day, hour, minute)
  }
})

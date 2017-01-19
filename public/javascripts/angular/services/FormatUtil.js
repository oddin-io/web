oddin.factory("FormatUtil", function () {
	var _convertToDate = function (date, time) {
		var day = parseInt(date.substring(0, 2));
		var month = parseInt(date.substring(2, 4)) - 1;
		var year = parseInt(date.substring(4, 8));
		var hour = 0;
		var minute = 0;
		if(time) {
			hour = parseInt(time.substring(0,2));
			minute = parseInt(time.substring(2,4));
		}
		return new Date(year, month, day, hour, minute);
	}

	return {
		convertToDate: _convertToDate
	}
});

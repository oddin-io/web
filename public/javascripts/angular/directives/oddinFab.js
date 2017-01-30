oddin.directive("oddinFab", function () {
	return {
		replace: true,
		restrict: "AE",
		scope: {
			trigger: "@"
		},
		templateUrl: '/components/fab'
	}
});

app.filter('orderObjectBy', function(){
 return function(input, attribute) {
    if (!angular.isObject(input)) return input;

    var array = [];
    for(var objectKey in input) {
        array.push(input[objectKey]);
    }

    var negative = false;
    if (attribute[0] === '-') {
      attribute = attribute.substr(1);
      negative = true;
    }

    if (negative) {
      array.sort(function(a, b){
          a = parseInt(a[attribute]);
          b = parseInt(b[attribute]);
          return b - a;
      });
    } else {
      array.sort(function(a, b){
          a = parseInt(a[attribute]);
          b = parseInt(b[attribute]);
          return a - b;
      });
    }

    return array;
 };
});

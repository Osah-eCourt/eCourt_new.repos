osahApp.filter('capitalize', function() {
  return function(input, scope) {
    if (input!=null)

    	var reg = (input) ? /([^\W_]+[^\s-]*) */g : /([^\W_]+[^\s-]*)/;

    return (!!input) ? input.replace(reg, function(txt){return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();}) : '';
    // input = input.toLowerCase();
    // return input.substring(0,1).toUpperCase()+input.substring(1);
  }
});

osahApp.filter('capitalizeall', function() {
  return function(input, scope) {
    if (input!=null)
    input = input.toUpperCase();
    return input;
  }
});

/**
 Created By Amol s 
 Created on :09-12-2016
 */

 osahApp.filter('unique', function () {

  return function (items, filterOn) {

    if (filterOn === false) {
      return items;
    }

    if ((filterOn || angular.isUndefined(filterOn)) && angular.isArray(items)) {
      var hashCheck = {}, newItems = [];

      var extractValueToCompare = function (item) {
        if (angular.isObject(item) && angular.isString(filterOn)) {
          return item[filterOn];
        } else {
          return item;
        }
      };

      angular.forEach(items, function (item) {
        var valueToCheck, isDuplicate = false;

        for (var i = 0; i < newItems.length; i++) {
          if (angular.equals(extractValueToCompare(newItems[i]), extractValueToCompare(item))) {
            isDuplicate = true;
            break;
          }
        }
        if (!isDuplicate) {
          newItems.push(item);
        }

      });
      items = newItems;
    }
    return items;
  };
});


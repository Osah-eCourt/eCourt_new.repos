
//bDatepicker directive
/*use 
	<input 	b-datepicker		="{{item.hearingdate}}" 
			ng-model			="item.hearingdate" 
			datepicker-options	="{startDate: '-7d',endDate: '+0d'}"
*/
   
 osahApp.directive('bDatepicker', function($filter) {
  return {
    require: '?ngModel',
    restrict: 'A',
	scope:{datepickerOptions:'='},
    link: function($scope, element, attrs, ngModelCtrl) {
      return attrs.$observe('bDatepicker', function(value) {
		datepickerOptions=($scope.datepickerOptions)?$scope.datepickerOptions:[];
		
        if(/^([0-9]{4})\-([0-9]{2})\-([0-9]{2})$/.test(value))
		{
            var d = new Date(value);
            d.setTime( d.getTime() + d.getTimezoneOffset()*60*1000 );
            viewDate = (value)?$filter('date')(new Date(d), 'MM-dd-yyyy'):'';
		}
		else{
			viewDate=value;
		}
        datepickerOptions.format=datepickerOptions.format?datepickerOptions.format:'mm-dd-yyyy';
		$return=element.datepicker(datepickerOptions);
        if(viewDate){
            element.datepicker("update",viewDate);
        }
        return false;
      });
    }
  };
}); 

osahApp.directive('toggleClass', function($rootScope, $interval) {
    return {
        restrict: 'A',
         link: function($scope, element, attrs) {
             element.bind('click', function() {
				 console.log();
				 element.attr('disabled',true)
				 //$scope.isDisabled = true;			 
				 $scope.Timer = $interval(function () {
                    //Display the current time.
                   if($rootScope.errorMessageshow == 1){
					   console.log($rootScope.errorMessageshow);
					   element.attr('disabled',false)
						//$scope.isDisabled = false;
					   $interval.cancel($scope.Timer);
				    }else{
						element.attr('disabled',false);
						 $interval.cancel($scope.Timer);
					}
                }, 1000);
            });
        } 
		
    };
});

osahApp.directive('ngEnter', function () {
    return function (scope, element, attrs) {
        element.bind("keydown keypress", function (event) {
            if(event.which === 13) {
                scope.$apply(function (){
                    scope.$eval(attrs.ngEnter);
                });

                event.preventDefault();
            }
        });
    };
});

osahApp.directive('compile', ['$compile', function ($compile) {
  return function(scope, element, attrs) {
    scope.$watch(
        function(scope) {
            return scope.$eval(attrs.compile);
        },
        function(value) {
            element.html(value);
            $compile(element.contents())(scope);
        }
    );
  };
}]);

osahApp.directive('numericOnly', function(){
    return {
        require: 'ngModel',
        link: function(scope, element, attrs, modelCtrl) {

            modelCtrl.$parsers.push(function (inputValue) {
                var transformedInput = inputValue ? inputValue.replace(/[^\d.-]/g,'') : null;

                if (transformedInput!=inputValue) {
                    modelCtrl.$setViewValue(transformedInput);
                    modelCtrl.$render();
                }

                return transformedInput;
            });
        }
    };
});

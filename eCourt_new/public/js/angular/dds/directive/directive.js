
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

/// on enter login to dds

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
//allow numbers with decimal

    osahApp.directive('allowOnlyNumbers', function () {  
        return {  
            restrict: 'A',  
            link: function (scope, elm, attrs, ctrl) {  
                elm.on('keydown', function (event) {  
                   
                    if (event.which == 64 || event.which == 16) {  
                        // numbers  
                        return false;  
                    } if ([8, 13, 27, 37, 38, 39, 40, 110].indexOf(event.which) > -1) {  
                        // backspace, enter, escape, arrows  
                        return true;  
                    } else if (event.which >= 48 && event.which <= 57) {  
                        // numbers  
                        return true;  
                    } else if (event.which >= 96 && event.which <= 105) {  
                        // numpad number  
                        return true;  
                    } else if ([46, 110, 190].indexOf(event.which) > -1) {  
                        // dot and numpad dot  
                        return true;  
                    } else {  
                        event.preventDefault();  
                        return false;  
                    }  
                });  
            }  
        }  
	});
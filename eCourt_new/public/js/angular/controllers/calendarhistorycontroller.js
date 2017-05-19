osahApp.controller('calendarhistorycontroller',['$scope','$rootScope','$state','$http','$stateParams','DocketFactory','DynamicFactory','Base64','$window','SearchFactory','$filter','loader','calendarManagementFactory',function($scope,$rootScope,$state,$http,$stateParams,DocketFactory,DynamicFactory,Base64,$window,SearchFactory,$filter,loader,calendarManagementFactory){
	loader.show();
	$scope.docket_number = Base64.decode($stateParams.reqdt);
			calendarManagement.getCalendarhistory().success(function(response){
				loader.hide();
			 console.log(response);
			
			  $scope.historyList = response;			  
			  $scope.sortingOrder ='date';
			  $scope.reverse = !$scope.reverse;
				var vm = this;
				vm =  $scope.historyList;
				console.log(vm.length);		
				if(vm.length <= 10){
				 $('.more').hide();
					//$('.loadless').show();
					$('.loadless').css('display','none');	
				}
				vm.limit = 10;
			$scope.loadMore = function() {
			  var increamented = vm.limit + 10;
			  vm.limit = increamented > vm.length ? vm.length : increamented;
			  if(increamented >= vm.length){
				  $('.more').hide();
					//$('.loadless').show();
					$('.loadless').css('display','block');
			  }
			};
			$scope.loadless = function() {
				console.log(vm.length);
				var decremented = vm.limit - 10;
				
				console.log(decremented);
				vm.limit = decremented < vm.length ? decremented : vm.length;
				console.log(vm.limit);
				console.log(decremented)
				if(decremented <= 9){
					 $('.more').show();
					 $('.more').css('display','block');
					$('.loadless').css('display','none');
				}
			};
 	  
	});	
	
	/* 
        Author Name : Amol s.
        Description : Function sort_by is used to on click documnet heading sorting.
		Added by FAISALK This should be in common because this is repeating.
      */
	
    $scope.sort_by = function(newSortingOrder) {
		console.log(newSortingOrder);
         if ($scope.sortingOrder == newSortingOrder){
           $scope.reverse = !$scope.reverse;
         }
         
         $scope.sortingOrder = newSortingOrder;

         // icon setup
         $('td i').each(function(){
             // icon reset
              if(!$(this).attr('id')=="topdeletebutton")
                 $(this).removeClass().addClass('fa fa-angle-down');
         });
        
         if ($scope.reverse){
           $('td.'+newSortingOrder+' i').removeClass().addClass('fa fa-angle-up');
         }else{
           $('td.'+newSortingOrder+' i').removeClass().addClass('fa fa-angle-down');
         }
    }
}]);
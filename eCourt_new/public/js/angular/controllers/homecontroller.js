    //Home controller
osahApp.controller('homecontroller',['$scope','$state','SearchFactory','DynamicFactory','Base64','DocketFactory','SessionFectory','$rootScope','loader',function($scope,$state,SearchFactory,DynamicFactory,Base64,DocketFactory,SessionFectory,$rootScope,loader){
	// $('#docketno').val('');
	$('.additional-search-block').slideUp();
	$('.additional-search-btn span').html('+');
        $scope.docketerMessage="";
    //Check The loged user type
    $scope.user_type = Base64.decode(SessionFectory.get('user_type'));
    
  
  if($scope.user_type != undefined &&  $scope.user_type !='' && $scope.user_type !='clerk'){
	  
	  loader.show();
    //To fill the upcomming calendar data 5 records from current date
    DocketFactory.upcomingcalendar().success(function(response){

      $scope.data = response.result;
	  loader.hide();
    //    $scope.user_type = response.user_type;
    });
  
  }
    
  
  
  //on click upcomming calendar redirect to search result 
  // $scope.searchbyvalue = function(chdf,hearingtime,judge){
	  // $rootScope.advanceSearch(undefined,undefined,undefined,undefined,undefined,undefined,undefined,undefined,judge,undefined,undefined,undefined,undefined,undefined,undefined,hearingtime,chdf);
	  $scope.searchbyvalue = function(chdf=1,hearingsite,hearingtime,judge,assistant){
	  $rootScope.advanceSearch(undefined,undefined,undefined,undefined,undefined,undefined,undefined,undefined,judge,assistant,hearingsite,undefined,undefined,undefined,undefined,hearingtime,chdf);
    /* $scope.calendar_date = Base64.encode(calendar_date);
    $scope.flag = Base64.encode('1');
    $state.go("searchresult",{reqdt:$scope.calendar_date,flg:$scope.flag},{reload: true}); */
  }
  

}]);
    


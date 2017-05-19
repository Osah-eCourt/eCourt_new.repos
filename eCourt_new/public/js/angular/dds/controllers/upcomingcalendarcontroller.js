osahApp.controller('upcomingcalendarcontroller',['$scope','$rootScope','$state','$stateParams','UpcomingCalendarFactory','DynamicFactory','SessionFectory','Base64','SearchFactory','$filter','loader',function($scope,$rootScope,$state,$stateParams,UpcomingCalendarFactory,DynamicFactory,SessionFectory,Base64,SearchFactory,$filter,loader){

	//Amol S 29-11-2016 Get the list of Judges
	$scope.searchjudgename='0';
	$scope.upcSearchjudgelist = $rootScope.judgeList_root;
	$scope.query_str="";

	 $scope.loggeduser_type = Base64.decode(SessionFectory.get('user_type'));
	
	 $scope.Lasname=Base64.decode(SessionFectory.get('LastName'));
	 $scope.Fisname=Base64.decode(SessionFectory.get('FirstName'));
	 $scope.calanderFlage=0;
	 if($scope.loggeduser_type=='cma' || $scope.loggeduser_type=='judge'){
	 	 $scope.calanderFlage=1;
	 }
	 $scope.userName = $scope.Lasname+" "+$scope.Fisname;
	 
	 $scope.upcommingcalenderliat='';
	 $scope.getupcomingcalander = function (flage) {
	 	$scope.user_typeField="";
	 	$scope.condition="";
	 	$scope.searchflage=0;
	 	if(flage==1){
			switch ($scope.loggeduser_type=='judge') {
	            case 'judge':
	               		$scope.user_typeField="Judge";
	                break;
	            case 'cma':
	                 $scope.user_typeField="Judgassistant";
	                break;
	            default:
	            	 $scope.user_typeField="";
	            	  $scope.userName ="";
	            	break;

	        }
	         
		}else{

			$scope.condition=$scope.query_str;
				$scope.searchflage=1;
		}

 		UpcomingCalendarFactory.UpcomingCalendarjudgelist($scope.userName,$scope.user_typeField,$scope.condition,$scope.searchflage).success(function(response){
        	$scope.upcjudgelist = response;

        });

		
        UpcomingCalendarFactory.UpcomingCalendardataUserwise($scope.userName,$scope.user_typeField,$scope.condition,$scope.searchflage).success(function(response){
        		 $scope.upcommingcalenderliat= response;
        		 if(response==null || response==undefined || response==''){
        		 	$rootScope.errorMessageshow=1;
					$rootScope.errorMessage="No upcoming calendars were found";
        		 }
        		 $scope.calanderFlage=1;
        		 
        		 loader.hide();	
        });

       


    };
    if($scope.loggeduser_type=='judge' || $scope.loggeduser_type=='cma'){
    	$scope.getupcomingcalander(1);
    }
    

		$('#todate').datepicker({
				format: "mm-dd-yyyy"
		});

		$('#frdate').datepicker({
				format: "mm-dd-yyyy"
		});

	//on Click Search Button This function Will Call Amol S.	
	$scope.searchupcommingCalander = function(searchjudgename,frdate,todate){
		
		var condition='';
		 $scope.query_str="";

		 if(searchjudgename!=undefined && searchjudgename!='0' && searchjudgename!=''){
        $scope.query_str +="Judge ="+"'"+searchjudgename+"'";
        
    	}
          
		if(frdate!=undefined && frdate!=''){
			var from_date=''; 
           frdate = frdate.replace("-", "/"); frdate = frdate.replace("-", "/");
           from_date = $filter('date')(new Date(frdate), 'yyyy-MM-dd');
           $scope.query_str +=($scope.query_str=='')?"hearingdate >='"+from_date+"'":" && hearingdate >='"+from_date+"'";

		}

		if(todate!=undefined && todate!=''){
		var to_date=''; 
		todate = todate.replace("-", "/"); todate = todate.replace("-", "/");
		 to_date = $filter('date')(new Date(todate), 'yyyy-MM-dd');
		 $scope.query_str +=($scope.query_str=='')?"hearingdate <='"+to_date+"'":" && hearingdate <='"+to_date+"'";
		}

		if($scope.query_str==''){
			$rootScope.errorMessageshow=1;
			$rootScope.errorMessage="Please select judge or hearingdate!";
		}else{
			loader.show();
			$scope.getupcomingcalander(0);


		}
		//console.log($scope.query_str);

		/*$('#collapseOne').collapse('toggle');
        $('#searchfield').addClass('collapsed');*/

	}
	//on click upcomming calendar redirect to search result 
  $scope.searchbyvalue = function(hdf,hearingsite,hearingtime){
	  $rootScope.advanceSearch(undefined,undefined,undefined,undefined,undefined,undefined,undefined,undefined,undefined,undefined,hearingsite,hdf,undefined,undefined,undefined,hearingtime);
    /* $scope.calendar_date = Base64.encode(calendar_date);
    $scope.flag = Base64.encode('1');
    $state.go("searchresult",{reqdt:$scope.calendar_date,flg:$scope.flag},{reload: true}); */
  }


}]);
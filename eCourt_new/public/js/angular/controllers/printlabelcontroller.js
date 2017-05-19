osahApp.controller('printlabelcontroller',['$scope','$rootScope','$state','$stateParams','DocketFactory','DynamicFactory','PartyFactory','Base64','SearchFactory','$filter','loader','PrintlabelFectory','$window','$http',function($scope,$rootScope,$state,$stateParams,DocketFactory,DynamicFactory,PartyFactory,Base64,SearchFactory,$filter,loader,PrintlabelFectory,$window,$http){
$scope.labelsNumberList = [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29];
$scope.labelnumber='-1';
$scope.clerk_id='0';
	PrintlabelFectory.getclerkList().success(function(response){
		$scope.clerkList =response;
	});
	$('#docReceivedDate').datepicker({
        format: "mm-dd-yyyy",
        autoclose: true
	 });

	// Using this Function we can call the printlabel function
	$scope.printlabels= function(){
		
		
		$rootScope.errorMessageshow=0;
		$rootScope.errorMessage = '';
		
			if($scope.clerk_id=='0' &&($scope.docReceivedDate==undefined || $scope.docReceivedDate=='') && ($scope.caseid==undefined || $scope.caseid=='')){
				$rootScope.errorMessageshow=1;
				$rootScope.errorMessage = 'Please enter docket clerk and date received or docket number.';
			}else{
				var requested_date='';
				if($scope.docReceivedDate!='' && $scope.docReceivedDate!=undefined){
					requested_date = $scope.docReceivedDate.replace("-", "/"); requested_date = requested_date.replace("-", "/");
					requested_date= $filter('date')(new Date(requested_date), 'yyyy-MM-dd');	
				}

				if($scope.clerk_id!='0'&&($scope.docReceivedDate==undefined||$scope.docReceivedDate=='')){
					$rootScope.errorMessageshow=1;
					$rootScope.errorMessage = 'Please enter the Date Received.';

					return false;
				}	
				if($scope.clerk_id!='0' && $scope.docReceivedDate!=undefined && $scope.caseid!=undefined){
					$rootScope.errorMessageshow=1;
					$rootScope.errorMessage = 'Please enter docket clerk and date received or docket number only.';	
					return false;
				}


				
				var lblnumber=($scope.labelnumber=='-1')?'0':$scope.labelnumber;

				var printlabel_information="";
				printlabel_information={dateReceived:requested_date,clerk_id:$scope.clerk_id,labelnumber:lblnumber,caseid:$scope.caseid};
				loader.show();
				PrintlabelFectory.generatelabel(printlabel_information).success(function(response){
					if(response.status_doc=='1'){
						loader.hide();
						$rootScope.errorMessageshow=1;
						$rootScope.errorMessage = 'Labels generated successfully.';
						$window.location.href ="/Osahform/downloadprintlabelfile/"+response.filenames;
					}if(response.status_doc=='0' || response.status_doc=='2'){
						loader.hide();
						$rootScope.errorMessageshow=1;
						$rootScope.errorMessage = (response.status_doc=='2')?'No records found.':'Labels not generated.';
						 
					}
				});
			}
				     
	}
}]);
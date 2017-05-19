osahApp.controller('ddsreportcontroller',['$scope','$rootScope','$state','$stateParams','DocketFactory','DynamicFactory','PartyFactory','Base64','SearchFactory','DDSForm1Factory','$filter','loader',function($scope,$rootScope,$state,$stateParams,DocketFactory,DynamicFactory,PartyFactory,Base64,SearchFactory,DDSForm1Factory,$filter,loader){
$('.additional-search-block').slideUp();
$('.additional-search-btn span').html('+');
$scope.agencyCode = "DDS";
$scope.casetypeselect = "ALS";
$scope.printOsahform1 = function()
{
	if(($scope.docReceivedDate=='' || $scope.docReceivedDate==undefined) && ($scope.caseid=='' || $scope.caseid==undefined))
	{
		$rootScope.errorMessageshow=1;
		$rootScope.errorMessage="Please enter received date or docket number";
	}
	else{
		loader.show();
		$scope.formatted_docReceivedDate = $filter('date')(new Date($scope.docReceivedDate), 'yyyy-MM-dd');
		var data = {refagency:$scope.agencyCode,datereceivedbyOSAH:$scope.formatted_docReceivedDate,caseid:$scope.caseid};
		DDSForm1Factory.printOsahform1(data).success(function(response){
		loader.hide();
		$scope.caseid = '';
		$scope.docReceivedDate='';
		if(response=='true')
		{
			$rootScope.errorMessageshow=1;
			$rootScope.errorMessage="OSAH Form printed successfully!";
		}else{
			$rootScope.errorMessageshow=1;
			$rootScope.errorMessage="No records found!";
		}
		});
	}
	
}

$('#docReceivedDate').datepicker({
        format: "mm-dd-yyyy",
		autoclose: true
		
	});

}]);
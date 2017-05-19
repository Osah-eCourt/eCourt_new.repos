osahApp.controller('dochistorycontroller',['$scope','$rootScope','$state','$http','$stateParams','DocketFactory','DynamicFactory','Base64','$window','SearchFactory','$filter','loader',function($scope,$rootScope,$state,$http,$stateParams,DocketFactory,DynamicFactory,Base64,$window,SearchFactory,$filter,loader){
	loader.show();	
	
	$scope.encoded_docket_number = $stateParams.reqdt;
	$rootScope.errorMessageshow = 0;
	$scope.docket_number = '';
	
	//rootScope.contactList_root
		 
	$scope.checkDoc = function(docId){
		console.log(docId);
		$http.post('Osahform/checkdocumentfileExist',{file: docId}).success(function(response) {
				console.log(response);
				  if(response == 1){
					var f = document.createElement("form");    
					f.setAttribute('method',"post");    
					f.setAttribute('action',"/Osahform/delete-temp-document"); 
					
					var i = document.createElement("input");    
					i.setAttribute('type',"hidden");    
					i.setAttribute('value',docId);    
					i.setAttribute('name',"file");
					f.appendChild(i);
					f.submit();					
					
					
					
					
				 }else{
					$rootScope.errorMessageshow=1;
					$rootScope.errorMessage="File Not Exist!";
				 } 
			 
			});
	};
	
	$scope.getDocketinformation = function() {	
		$scope.docket_number = Base64.decode($stateParams.reqdt);
		$scope.reqdt = $stateParams.reqdt;
		$scope.party_data = '';
		$scope.result = '';
		/* 
			Function is used to display docket information
		*/
		DocketFactory.searchbydocket("docketsearch", "caseid = '" + $scope.docket_number + "'").success(function(response) {
			console.log(response);
				console.log("AFFAN");
			$scope.casefiletype =response['docketData'][0].casefiletype;
			$scope.result = response;
			$scope.partyResult = response['peopleData'];
			$scope.agencyCode =  $scope.result['docketData'][0].refagency;
			$scope.casetype = $scope.result['docketData'][0].casetype;
			if ($scope.result == '') {
				$rootScope.errorMessageshow = 1;
				$rootScope.errorMessage = "No records found";
			}
			var OlddocketNumber = $scope.result['docketData'][0].docketnumber;
             var SplitdocketNumber = OlddocketNumber.split('-');
             var NewdocketNumber = SplitdocketNumber[2]+'-'+SplitdocketNumber[0]+'-'+SplitdocketNumber[1]+'-'+SplitdocketNumber[3]+'-'+SplitdocketNumber[4];
             $scope.docket_no=NewdocketNumber;
			 $scope.docketCreated = $scope.result['docketData'][0].docketclerk;
			 
			$scope.petitioner_flg = '0';
			$scope.respondent_flg = '0';
			console.log($scope.partyResult);
			angular.forEach($scope.partyResult, function(value, key) {
				console.log(value);
			
				if (value.typeofcontact == "Petitioner"){
					$scope.Firstname = value.Firstname;
					$scope.Lastname = value.Lastname;
					$scope.petitioner_flg = '1';
				}if(value.typeofcontact == "Respondent"){
                         $scope.ResfirstName = value.Firstname;
                         $scope.ReslastName = value.Lastname;
						 $scope.respondent_flg = '1';
					}
				});
				if($scope.respondent_flg=='0')
				{
					SearchFactory.searchbyvalue("agency","Agencycode ='"+$scope.agencyCode+"'").success(function(response){
							$scope.agencyData=response;
							$scope.agencyId = response[0].AgencyID;
							SearchFactory.searchbyvalue("casetypes","CaseCode ='"+$scope.casetype+"' and AgencyID = '"+$scope.agencyId+"'").success(function(response){
								$scope.casetypeData=response;
								$scope.caseId = response[0].Casetypeid;
								SearchFactory.searchbyvalue("casetypestyling","AgencyID ='"+$scope.agencyId+"' and Casetypeid = '"+$scope.caseId+"'").success(function(response){
										$scope.respondentName = response[0].respondent;
								});
							});
						});
				}
				if($scope.petitioner_flg=='0')
				{
					SearchFactory.searchbyvalue("agency","Agencycode ='"+$scope.agencyCode+"'").success(function(response){
						$scope.agencyData=response;
						$scope.agencyId = response[0].AgencyID;
						SearchFactory.searchbyvalue("casetypes","CaseCode ='"+$scope.casetype+"' and AgencyID = '"+$scope.agencyId+"'").success(function(response){
							$scope.casetypeData=response;
							$scope.caseId = response[0].Casetypeid;
							SearchFactory.searchbyvalue("casetypestyling","AgencyID ='"+$scope.agencyId+"' and Casetypeid = '"+$scope.caseId+"'").success(function(response){
								$scope.petitionerName = response[0].petitioner;
							});
						});
					});
				}
			});
		loader.hide();
	}
	$scope.getDocketinformation();
	$scope.reqdt = $stateParams.reqdt;
		$scope.docket_number = Base64.decode($stateParams.reqdt);
			DynamicFactory.getdynamicdata("history","caseid",$scope.docket_number,"1").success(function(response){
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
	
		$scope.isExpired = function(t){						
			return (new Date().getTime()-(60 * 60 * 24 * 2)>t)?1:0;
		}
 
}]);

osahApp.filter('html', ['$sce', function ($sce) { 
    return function (text) {
        return $sce.trustAsHtml(text);
    };    
}])

.directive('compile', ['$compile', function ($compile) {
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
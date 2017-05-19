 //Login controller
		osahApp.controller('temporarypermitscontroller',['$scope','$state','LoginFactory','DocketFactory','PrintPermitsFactory','SessionFectory','Base64',function($scope,$state,LoginFactory,DocketFactory,PrintPermitsFactory,SessionFectory,Base64){
        loader.show();
        $scope.validation_message = '';
		console.log("sc"+userName);
		$scope.getDocketinformation=function(){
			loader.show();
			$scope.docket_number = Base64.decode($stateParams.reqdt);
			$scope.party_data = '';
			$scope.result = '';
			
				 /* 
					Function is used to display docket information
				 */
            DocketFactory.searchbydocket("docketsearch","caseid = '"+$scope.docket_number+"'").success(function(response){
				loader.hide();
                 $scope.result = response['peopleData'];
                 $scope.ppldetail = response['peopleData'];
                $scope.dockets = response['docketData'];
				$scope.docketCreated= $scope.dockets[0].docketclerk;
				console.log($scope.docketCreated);
				
			});;
			 $scope.getDocketinformation();
		// Print Permits Code.
		
			 $scope.printPermits = function()
			{
						// PrintPermitsFactory.printpermits('docket').success(function(response){
								// if(response=="true"){
									// $rootScope.errorMessageshow=1;
									$scope.empty_result_flag_document = '0';
									// $scope.listDocumentflag = '1';
									// $rootScope.errorMessage="Document added successfully!";
									// $('#document-templates').modal('toggle');
									// $scope.documentListing();
								// }else{
									// alert("Some error occured!");
								// }
							  
							// });
			}
		}

		}]);
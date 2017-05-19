 //Login controller
		osahApp.controller('temporarypermitscontroller',['$scope','$rootScope','$state','$stateParams','$window','LoginFactory','DocketFactory','PrintPermitsFactory','SessionFectory','Base64',function($scope,$rootScope,$state,$stateParams,$window,LoginFactory,DocketFactory,PrintPermitsFactory,SessionFectory,Base64){
        loader.show();
        $scope.validation_message = '';
		console.log($rootScope.username);
		//$scope.getDocketinformation=function(){
			//loader.show();
			//$scope.docket_number = Base64.decode($stateParams.reqdt);
			//$scope.party_data = '';
			//$scope.result = '';
			
				 /* 
					Function is used to display docket information
				 */
			/* 	 console.log("asddf");
			DocketFactory.searchbydocket("docketsearch",$rootScope.username).success(function(response){
				console.log(response);
				loader.hide();
				console.log("ZXC");
                 $scope.result = response['peopleData'];
                 $scope.ppldetail = response['peopleData'];
                $scope.dockets = response['docketData'];
				$scope.docketCreated= $scope.dockets[0].docketclerk;
				console.log($scope.docketCreated);
				
			});
			
		}
		 

		
		
		$scope.getDocketinformation(); */
		// Print Permits Code in bulk.
				loader.hide();
			 $scope.printPermits = function()
			{
				loader.show();
				//var newWin = $window.open('', '_blank');
				console.log("sadf");
						 PrintPermitsFactory.printpermits('docket',$rootScope.username).success(function(response){
							 console.log(response);
								if(response.flag == 1){
									 $rootScope.errorMessageshow=1;
									 $rootScope.errorMessage="Generating Temporary Permit";
									 loader.hide();
									 var newWin = $window.open('', '_blank');
									 newWin.location =response.tmp_path;
								 }else{
										$rootScope.errorMessageshow=1;
										 loader.hide();
										 $rootScope.errorMessage="No Temporary Permit To Print.";
								}
							  
							}); 
			}
			// print single permit
			 $scope.printSinglePermits = function()
			{
				loader.show();
			
				$('.tem_per').each(function(){
							var cur = $(this);
							id = $(this).attr("id");
							console.log(id)
							if ($.trim(cur.val()) == '' ||  $.trim(cur.val()) == 0 ){
								
								$rootScope.errorMessageshow=1;
								$rootScope.errorMessage=$(this).attr("msg");
								flag= false;
								return false;
								
							
							}
				});	
						 PrintPermitsFactory.printsinglepermits('docket',$scope.license_number).success(function(response){
								if(response.flag == 1){
									 $rootScope.errorMessageshow=1;
									 $rootScope.errorMessage="Generating Temporary Permit";
									 loader.hide();
											var newWin = $window.open('', '_blank');
											 newWin.location =response.tmp_path;
									

								 }else{
											$rootScope.errorMessageshow=1;
											 loader.hide();
										 $rootScope.errorMessage="No Temporary Permit To Print.";
								}
							  
							}); 
			}
}]);
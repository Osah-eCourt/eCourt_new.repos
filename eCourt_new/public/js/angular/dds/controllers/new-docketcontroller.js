osahApp.controller('new-docketcontroller',['$scope','$rootScope','$state','$stateParams','DocketFactory','DynamicFactory','PartyFactory','Base64','SearchFactory','$filter','loader','$http','$window','SessionFectory','PageLeaveWarning',function($scope,$rootScope,$state,$stateParams,DocketFactory,DynamicFactory,PartyFactory,Base64,SearchFactory,$filter,loader,$http,$window,SessionFectory,PageLeaveWarning){
	loader.show();
       
	  $scope.countyList_root      =  $rootScope.countyList_root; //Get County list
      //$scope.AgencyList           =  $rootScope.AgencyList_root; //Get Agency list
      //$scope.casetypesList        =  $rootScope.casetypesList_root; //Get casetypes list
      //$scope.judgeList            =  $rootScope.judgeList_root; //Get judge list
     // $scope.Judge_AssistantList  =  $rootScope.Judge_AssistantList_root; //Get Judge_Assistant list
      //$scope.courtlocationList    =  $rootScope.courtlocationList_root; //Get courtlocation list
      //$scope.statusList           =  $rootScope.statusList_root; //Get status list
      //$scope.hearingtimeList     =  $rootScope.hearingtimeList_root; //Get status list
	  //$scope.hearingTypedetails =   $rootScope.hearingTypedetails  //Get Hearing Type List
	  $scope.skip_hearingDate = '0';
	  	// to check empty value affan.						
	  $scope.countyselect = "No County";
	  $scope.hearingType = "In Person";
	  $scope.elgpermit = "0";
	  $scope.agencyCode = "DDS";
	  $scope.casetypeselect = "ALS";
	  $scope.docketClerk = Base64.decode(SessionFectory.get('dds_user')); // get loggedin username
		//console.log($scope.hearingTypedetails);
	$('#new_docket-reqdate').datepicker({
        format: "mm-dd-yyyy",

		endDate: '+0d',
		autoclose: true
	});
	
	$('#new_docket-effectivedate').datepicker({
				format: "mm-dd-yyyy",
				
		});

	
	$('#new_docket-hearingdate').datepicker({
        format: "mm-dd-yyyy",
		startDate: '-0d',
		autoclose: true
	});

	$('#new_docket-effectivedate').datepicker({
        format: "mm-dd-yyyy",
		startDate: '-0d',
		autoclose: true
	});

	

	
	$('#expirydate').datepicker({
        format: "mm-dd-yyyy",
		startDate: '-0d',
		autoclose: true
	});
	
	$('#dob').datepicker({
        format: "mm-dd-yyyy",
        autoclose: true
		
	});
	$('#incident_date').datepicker({
        format: "mm-dd-yyyy",
        autoclose: true
		
	});
	$scope.receivedDate = $filter('date')(new Date(), 'MM-dd-yyyy');
	
	 /* 
        Name : Neha Agrawal
        Description : Function is casetype_agencywise is used to when select the agency the it will get respective case types
        Created on : 05-12-2016
      */
      /* $scope.casetype_agencywise = function(){
           
         var agnid =  $('#new_docket-agencyCode').find('option:selected').attr('agnid');
         $scope.agencyCode =  $('#new_docket-agencyCode').find('option:selected').val();
         if(agnid!=undefined && agnid !='' && agnid!=null){

              DynamicFactory.getdynamicdata("casetypes","AgencyID",agnid,1).success(function(response){
                  $scope.casetypeselect=''; 
                  $scope.casetypesList=response;
				  setConfidentialCaseType();
              });

         }
       } */
	   
	 /* 
          Name : Neha Agrawal
          Description : Function is casetypeCountyChange is used to auto-populate hearing information based on casetype id and countyid.
          Created on : 05-12-2016
      */
      $scope.casetypeCountyChange = function(){
        var casetypeid =  $('#new_docket-casetypeselect').find('option:selected').attr('castyp');
        $scope.casetypeselect= $('#new_docket-casetypeselect').find('option:selected').val();
        var countyid =   $('#new_docket-countyselect').find('option:selected').attr('conty');
        $scope.countyselect =   $('#new_docket-countyselect').find('option:selected').val();
        var condition="";
        if(casetypeid!=undefined && casetypeid!='' && casetypeid!=null && countyid!=undefined && countyid!='' && countyid!=null){
            condition="CountyID="+countyid+" && Casetypeid="+casetypeid;
            SearchFactory.searchbyvalue("judgeassist_court_mapping",condition).success(function(response){
                  if(response==''|| response==null || response.empty ){
                    $scope.judgeAssistant="";
                    $scope.judge="";
                    $scope.caseLocation=""; 
                    $scope.hearingTime=''; 

				}else{
					$scope.judgeAssistant=response[0].judgeassistant;
					$scope.judge=response[0].judges;
					$scope.caseLocation=response[0].Locationname; 
					$scope.hearingTime=response[0].hearingtime; 
				}
				setConfidentialCaseType();
            });
		}
		if(casetypeid!=undefined && casetypeid !='' && casetypeid!=null && casetypeid!= 'a0')
			  {
				condition="Casetypeid="+casetypeid;
				 SearchFactory.searchbyvalue("hearingdateskip",condition).success(function(response){
                  if(response==''|| response==null || response.empty ){
                  $scope.skip_hearingDate = "0";
                  }else{
					 $scope.skip_hearingDate = "1";
                  }
				  setConfidentialCaseType();
              });
			  }
    }
	
	/* 
		Name : Neha Agrawal
		Description : Function is used to add docket number.
		Created On : 05-12-2016
	*/
	$scope.addDocket = function()
	{
		$scope.disable_button = '1'; 
			$rootScope.errorMessageshow=0;
			flag = true;
				// if($scope.agencyCode=='' || $scope.agencyCode==undefined || $scope.casetypeselect=='' || $scope.casetypeselect==undefined|| $scope.countyselect=='' || $scope.countyselect==undefined|| $scope.dateRequested=='' || $scope.dateRequested==undefined || $scope.hearingType=='' || $scope.hearingType==undefined || $scope.receivedDate=='' || $scope.receivedDate==undefined || $scope.caseLocation=='' || $scope.caseLocation==undefined || $scope.hearingDate=='' || $scope.hearingDate==undefined || $scope.hearingTime=='' || $scope.hearingTime==undefined || $scope.judge=='' || $scope.judge==undefined || $scope.judgeAssistant=='' || $scope.judgeAssistant==undefined)
					// {
						if($scope.skip_hearingDate == "1")
						{
							 $("#new_docket-hearingdate").removeClass("add_doc");
							 $("#new_docket-hearingTime").removeClass("add_doc");
							 
						}else{
							$("#new_docket-hearingdate").addClass("add_doc");
							$("#new_docket-hearingTime").addClass("add_doc");
						}
						$scope.disable_button = '1'; 
						$('.add_doc').each(function(){
							var cur = $(this);
							id = $(this).attr("id");
							if ($.trim(cur.val()) == '' ||  $.trim(cur.val()) == 0 ){
								$rootScope.errorMessageshow=1;
								$rootScope.errorMessage=$(this).attr("msg");
								 flag= false;
								return false;
							}
						});
							var selected = $('#new_docket-elegpermit option:selected').text();							
							if(selected == 'Yes'){
								var effectivedatevalue = $('#new_docket-effectivedate').val();
								console.log(effectivedatevalue);
								if(effectivedatevalue == "" && $scope.elgpermit == 1)
								{
								 $rootScope.errorMessageshow=1;
								 $rootScope.errorMessage=$('#new_docket-effectivedate').attr("msg");
								 flag= false;
								 return false;
								}
							}else{
								//flag= true;
							}
							console.log(flag);
							if(flag){
							loader.show();
							$scope.disable_button = '1';
						 
							dateRequested = '';
							
							dateRequested = $scope.dateRequested.replace("-", "/");
							dateRequested = dateRequested.replace("-", "/");
							//effectivedate=  $scope.effectivedate.replace("-", "/");
							console.log($scope.elgpermit);
							if($scope.elgpermit == 1){
								
								effectivedate = $scope.effectivedate.replace("-", "/");
								effectivedate = effectivedate.replace("-", "/");
								
								
								expirydate=  $scope.expirydate.replace("-", "/");
								expirydate = expirydate.replace("-", "/");
								
								
								dob=  $scope.dob.replace("-", "/");
								dob = dob.replace("-", "/");
								
								incident_date=  $scope.incident_date.replace("-", "/");
								incident_date = incident_date.replace("-", "/");
								
								 $scope.effectivedate = $filter('date')(new Date(effectivedate), 'yyyy-MM-dd');
								$scope.expirydate = $filter('date')(new Date(expirydate), 'yyyy-MM-dd');
								 $scope.dob = $filter('date')(new Date(dob), 'yyyy-MM-dd');
								 $scope.incident_date = $filter('date')(new Date(incident_date), 'yyyy-MM-dd'); 
								
							 
								 
							}							
						 
								$scope.formatted_dateRequested = $filter('date')(new Date(dateRequested), 'yyyy-MM-dd');
								
								
							 
							//console.log($scope.formatted_dateRequested);
							
							console.log("$scope.formatted_dateRequested");
							console.log($scope.dateRequested);
						$scope.docket_status = "Pending";
						$rootScope.county = $scope.countyselect;
						var docketDetail={refagency:$scope.agencyCode, casetype:$scope.casetypeselect, county:$scope.countyselect, daterequested:$scope.formatted_dateRequested, agencyrefnumber:$scope.agencyrefnumber, hearingmode:$scope.hearingType,eligiblepermit:$scope.elgpermit,permiteffectivedate:$scope.effectivedate,expiryDate:$scope.expirydate,DOB:$scope.dob,incident_date:$scope.incident_date,docketclerk:$scope.docketClerk,status:$scope.docket_status,casefiletype:$scope.casefiletype};
						
						
						//var locationId =   {location_id : $('#new_docket-caseLocation').find('option:selected').attr('location_id')};
						 console.log(docketDetail);
							 DocketFactory.addDocket(docketDetail).success(function(response){
							
								console.log(response);
								console.log(response.docket_id);
								if(response.status=="true"){
									loader.hide();
									$scope.disable_button = '0'; 
									$rootScope.errorMessageshow=1;
									$rootScope.errorMessage="Docket added successfully!";
									$scope.docket_id = response.docket_id;
									$scope.docket_no = Base64.encode($scope.docket_id);
									PageLeaveWarning.reset();
									$state.go("docket",{reqdt:$scope.docket_no},{reload: true});
								}else{
									$rootScope.errorMessageshow=1;
									$rootScope.errorMessage="Some thnig went wrong tray again later";
								}
							}); 
					}
	};
        loader.hide();
	/* added by Faisal Khan	@Description: setConfidentialCaseType @Created on 	: 2017-05-01*/
	/* setConfidentialCaseType=function(){
		if($scope.agencyCode!=''&&$scope.casetypeselect!=''){
			DocketFactory.getConfidentialCaseType({refagency:$scope.agencyCode, casetype:$scope.casetypeselect}).success(function(response){
				$scope.casefiletype =response;
			});
		}
		else{
			$scope.casefiletype ='';
		}
	}; */
	
	/* 
	Name : Neha Agrawal
	Description : Page leaving Warning pop-up
	Created Date : 05-04-2017
	*/
	PageLeaveWarning.watch($scope,[
		'agencyCode',
		'casetypeselect',
		'countyselect',
		'dateRequested',
		'agencyrefnumber',
		'hearingType',
		'elgpermit',
		'effectivedate',
		'expirydate',
		'dob',
		'incident_date'
	]);
	//Get Current Time from utc.			
				$scope.chkForCurrentDateTimeASPerUTC = function(dateUTC){	
								var d = new Date(dateUTC);	
						var da = d.setTime( d.getTime() + d.getTimezoneOffset()*60*1000 );	
						var date = $filter('date')(da, 'MM-dd-yyyy');
						console.log(date);
						return date;
				};
	// when clerk change permit effective date, this function change expiration date automatically for 30 days after - affan shaikh
	  $scope.getPermitExpiryDate = function(effectivedate){
		  effe = $scope.effectivedate.replace("-", "/");
		  effe = effe.replace("-", "/");
		  
		var effectiveDate = 	$filter('date')(new Date(effe), 'yyyy-MM-dd');
		var cur = new Date(effectiveDate);
		var after30days = cur.setDate(cur.getDate() + 30);
		$scope.expirydate = 	$scope.chkForCurrentDateTimeASPerUTC(after30days);
		if(effe == ''){
			$scope.expirydate = '';
		}
	  };
	
	}]);
osahApp.controller('new-docketcontroller',['$scope','$rootScope','$state','$stateParams','DocketFactory','DynamicFactory','PartyFactory','Base64','SearchFactory','$filter','loader','$http','$window','SessionFectory','PageLeaveWarning',function($scope,$rootScope,$state,$stateParams,DocketFactory,DynamicFactory,PartyFactory,Base64,SearchFactory,$filter,loader,$http,$window,SessionFectory,PageLeaveWarning){
	  
	  $scope.countyList_root      =  $rootScope.countyList_root; //Get County list
      $scope.AgencyList           =  $rootScope.AgencyList_root; //Get Agency list
      $scope.casetypesList        =  $rootScope.casetypesList_root; //Get casetypes list
      $scope.judgeList            =  $rootScope.judgeList_root; //Get judge list
      $scope.Judge_AssistantList  =  $rootScope.Judge_AssistantList_root; //Get Judge_Assistant list
      $scope.courtlocationList    =  $rootScope.courtlocationList_root; //Get courtlocation list
      $scope.statusList           =  $rootScope.statusList_root; //Get status list
      $scope.hearingtimeList     =  $rootScope.hearingtimeList_root; //Get status list
	  $scope.hearingTypedetails =   $rootScope.hearingTypedetails  //Get Hearing Type List
	  $scope.skip_hearingDate = '0';
	  $scope.docketClerk = Base64.decode(SessionFectory.get('user')); // get loggedin username
	  $scope.hearingType = 'In Person';
	
	$('#new_docket-reqdate').datepicker({
        format: "mm-dd-yyyy",
		endDate: '+0d',
		autoclose: true
	});
	
	$('#new_docket-recvdate').datepicker({
        format: "mm-dd-yyyy",
		 startDate: '-7d',
		 endDate: '+0d',
		 autoclose: true
	});
	
	/* commented by Faisal Khan	@Description: instead of this, b-datepicker directive is used because model/datepicker is not updated @On : 2017-03-29*/
	/*$('#new_docket-hearingdate').datepicker({
        format: "mm-dd-yyyy",
		startDate: '-0d',
	});*/

	$scope.receivedDate = $filter('date')(new Date(), 'MM-dd-yyyy');
	
	 /* 
        Name : Neha Agrawal
        Description : Function is casetype_agencywise is used to when select the agency the it will get respective case types
        Created on : 05-12-2016
      */
      $scope.casetype_agencywise = function(){
           
         var agnid =  $('#new_docket-agencyCode').find('option:selected').attr('agnid');
         $scope.agencyCode =  $('#new_docket-agencyCode').find('option:selected').val();
         if(agnid!=undefined && agnid !='' && agnid!=null){

              DynamicFactory.getdynamicdata("casetypes","AgencyID",agnid,1).success(function(response){
                  $scope.casetypeselect=''; 
                  $scope.casetypesList=response;
				  setConfidentialCaseType();
              });

         }else{
			 $scope.casetypeselect=''; 
			 $scope.casetypesList = $rootScope.casetypesList_root;
		 }
       }
	   
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
	$rootScope.dyn_func_name = "addDocket()";
	$scope.addDocket = function()
	{
			console.log($scope.hearingType);
		// $scope.disable_button = '0'; 
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
						
						$('.add_doc').each(function(){
							// $scope.disable_button = '0'; 
							var cur = $(this);
							id = $(this).attr("id");
							if ($.trim(cur.val()) == '' ||  $.trim(cur.val()) == 0 ){
								$rootScope.errorMessageshow=1;
								$rootScope.errorMessage=$(this).attr("msg");
								 flag= false;
								return false;
							}
						});
					// }else{
						if(flag){
						 // $scope.disable_button = '1'; 
						 loader.show();
						 
						var hearing_date=''; var requested_date=''; var received_date='';
						hearing_date=$scope.hearingDate.replace("-", "/"); hearing_date = hearing_date.replace("-", "/");
					    requested_date = $scope.dateRequested.replace("-", "/"); requested_date = requested_date.replace("-", "/");
					    received_date = $scope.receivedDate.replace("-", "/"); received_date = received_date.replace("-", "/");
						hearing_date = $filter('date')(new Date(hearing_date), 'yyyy-MM-dd');
						requested_date= $filter('date')(new Date(requested_date), 'yyyy-MM-dd');
						received_date= $filter('date')(new Date(received_date), 'yyyy-MM-dd');
						 
						 // $scope.formatted_dateRequested = $filter('date')(new Date($scope.dateRequested), 'yyyy-MM-dd');
						 // $scope.formatted_receivedDate = $filter('date')(new Date($scope.receivedDate), 'yyyy-MM-dd');
						 // $scope.formatted_hearingDate = $filter('date')(new Date($scope.hearingDate), 'yyyy-MM-dd');
						 $scope.docket_status = "Hearing Scheduled";
						var docketDetail={refagency:$scope.agencyCode, casetype:$scope.casetypeselect, county:$scope.countyselect, daterequested:requested_date, agencyrefnumber:$scope.agencyrefnumber, hearingmode:$scope.hearingType,datereceivedbyOSAH:received_date, hearingsite:$scope.caseLocation, hearingdate:hearing_date, hearingtime:$scope.hearingTime, judge:$scope.judge,judgeassistant:$scope.judgeAssistant,docketclerk:$scope.docketClerk,status:$scope.docket_status,casefiletype:$scope.casefiletype,telv_o_five:'1'};
						
						 var locationId =   {location_id : $('#new_docket-caseLocation').find('option:selected').attr('location_id')};
						 console.log($rootScope.pageLeaveWarning);
						 //return;
						DocketFactory.addDocket(docketDetail,locationId).success(function(response){
							loader.hide();
							console.log(response.docket_id);
							if(response.status=="true"){
								// $scope.disable_button = '0'; 
								$rootScope.errorMessageshow=1;
								$rootScope.errorMessage="Docket added successfully!";
								$scope.docket_id = response.docket_id;
								$scope.docket_no = Base64.encode($scope.docket_id);
								console.log();
								PageLeaveWarning.reset();
								$state.go("docket",{reqdt:$scope.docket_no},{reload: true});
							}else{
								$rootScope.errorMessageshow=1;
								$rootScope.errorMessage="Some thnig went wrong tray again later";
							}
						});
					}
	};
	/* added by Faisal Khan	@Description: setConfidentialCaseType @Created on 	: 2017-05-01*/
	setConfidentialCaseType=function(){
		if($scope.agencyCode!=''&&$scope.casetypeselect!=''){
			DocketFactory.getConfidentialCaseType({refagency:$scope.agencyCode, casetype:$scope.casetypeselect}).success(function(response){
				$scope.casefiletype =response;
			});
		}
		else{
			$scope.casefiletype ='';
		}
	};
	/* added by Faisal Khan	@Description: setHearingDate @Created on 	: 2017-01-30*/
	$scope.elementDataLoader={
		val:0,
		token:0,
		defaultText:'<i class="fa fa-gavel"></i> Retrieving hearing date...',
		text:'',
		lastAutomatedHearingDate:"",
		hearingDateValEnteredByUser:false,
		fieldDisabled:false,
		submitDisabled:false
	};
	$scope.hearingDateManualMode=function(){
		if($scope.hearingDate!=$scope.elementDataLoader.lastAutomatedHearingDate){
			$scope.elementDataLoader.hearingDateValEnteredByUser=true;
		}
		if(!$scope.hearingDate) hearingDateAutomateMode();
		if($scope.elementDataLoader.hearingDateValEnteredByUser) hearingDateManual();
	};
	$scope.hearingDateAutomateMode=function(){
		$scope.elementDataLoader.hearingDateValEnteredByUser=false;hearingDateAutomation();
	};
	$scope.$watchGroup(['judge','judgeAssistant','caseLocation','casetypeselect','hearingTime'], function(newValue, oldValue) {
		if(newValue.every(function(v,k){ return v;}))
		{
			if($scope.elementDataLoader.hearingDateValEnteredByUser==false)hearingDateAutomation();
			if($scope.elementDataLoader.hearingDateValEnteredByUser)hearingDateManual();
		}
	});
	prepareHearingDateRequest=function(){
		obj = {};
		obj.judge_id = $('#new_docket-judge').find('option:selected').attr('judge_id');
		obj.judge_assistant_id = $('#new_docket-judgeAssistant').find('option:selected').attr('judge_assistant_id');
		obj.court_location_id = $('#new_docket-caseLocation').find('option:selected').attr('location_id');
		obj.casetype_id = $('#new_docket-casetypeselect').find('option:selected').attr('castyp');
		obj.casetype = $('#new_docket-casetypeselect').val();
		obj.hearingTimeId=$('[name="hearingTime"]').find('option:selected').attr('time-id');
		obj.hearingTime=$('[name="hearingTime"]').val();
		obj.token=++$scope.elementDataLoader.token;
		obj.hearingDate=$scope.hearingDate;
		obj.hearingDateValEnteredByUser=$scope.elementDataLoader.hearingDateValEnteredByUser;
		return obj;
	}
	hearingDateAutomation=function(){
		$scope.elementDataLoader.val=1;
		$scope.elementDataLoader.fieldDisabled=true;
		$scope.elementDataLoader.submitDisabled=true;
		$scope.elementDataLoader.text=$scope.elementDataLoader.defaultText;
		DocketFactory.hearingDateAutomation(prepareHearingDateRequest()).success(function(response) {
			if($scope.elementDataLoader.token==response.token)
			{		
				if(response.hearingDateValEnteredByUser==false){
					$scope.hearingDate =response.hearingDate;
					$scope.elementDataLoader.lastAutomatedHearingDate=response.hearingDate;
				}
				$scope.elementDataLoader.val=0;
				$scope.elementDataLoader.fieldDisabled=false;
				$scope.elementDataLoader.submitDisabled=false;
				$scope.elementDataLoader.text=$scope.elementDataLoader.defaultText;
			}
		});
	};
	
	hearingDateManual=function(){
		$scope.elementDataLoader.val=1;
		$scope.elementDataLoader.fieldDisabled=true;
		$scope.elementDataLoader.submitDisabled=true;
		$scope.elementDataLoader.text='<i class="fa fa-gavel"></i> Validating hearing date...';
		DocketFactory.hearingDateManual(prepareHearingDateRequest()).success(function(response) {
			if($scope.elementDataLoader.token==response.token)
			{		
				if(response.hearingDateValEnteredByUser==true){
					if(response.error.length){
						//$scope.elementDataLoader.val=0;		
						switch(response.error[0]){
							case 'cutoffDate':$scope.elementDataLoader.text='<div class="more-block" ng-click="hearingDateAutomateMode()" ><i class="fa fa-plus-circle"></i><span>Click to add calendar date.</span></div><span ng-click="hearingDateAutomateMode()"  class="message-block"> Cutoff date has passed.</span>';break;
							case 'maxNoOfCasesLimit':$scope.elementDataLoader.text='<div class="more-block" ng-click="hearingDateAutomateMode()" ><i class="fa fa-plus-circle"></i><span>Click to add calendar date.</span></div><span ng-click="hearingDateAutomateMode()" class="message-block"> Exceeds case limit.</span>';
						}
						//$('[data-toggle="tooltip"]').tooltip(); 
						$scope.elementDataLoader.fieldDisabled=false;
					}
					else{
						$scope.elementDataLoader.val=0;	
						$scope.elementDataLoader.fieldDisabled=false;
						$scope.elementDataLoader.submitDisabled=false;	
						$scope.elementDataLoader.text=$scope.elementDataLoader.defaultText;
					}
					$('[data-toggle="tooltip"]').tooltip(); 
				}

			}
		});
	};
	/* added by Faisal Khan	@Description: page-leave-warning-popup @Created on 	: 2017-01-30*/
	PageLeaveWarning.watch($scope,[
		'agencyCode',
		'casetypeselect',
		'countyselect',
		'dateRequested',
		'agencyrefnumber',
		'hearingType',
		'receivedDate',
		'caseLocation',
		'hearingDate',
		'hearingTime',
		'judge',
		'judgeAssistant'
	]);
	/*end added by Faisal Khan	@Description: page-leave-warning-popup @Created on 	: 2017-01-30*/
	
	
	}]);
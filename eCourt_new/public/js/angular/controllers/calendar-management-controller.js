osahApp.controller('calendarManagementController', ['$scope', '$rootScope', '$state', '$stateParams', 'DocketFactory', 'DynamicFactory', 'PartyFactory', 'Base64', 'SearchFactory', 'calendarManagementFactory', '$filter', 'loader','SessionFectory','PageLeaveWarning', function($scope, $rootScope, $state, $stateParams, DocketFactory, DynamicFactory, PartyFactory, Base64, SearchFactory, calendarManagementFactory, $filter, loader,SessionFectory,PageLeaveWarning) {
	$scope.loggedUserType = Base64.decode(SessionFectory.get('user_type'));
	$scope.calendarFlag=0;
	$scope.calSearch={};
	$scope.showCalendarDatesBlock=0;
	$scope.showCalendarDatesView=0;
	$scope.activeCalendarTiles=-1;
	$scope.addDatebox_flag = 0;
	$scope.editDateflag = 0;
	$scope.calendarDatesList=[];
	$scope.deleteData=[];
	$scope.versement_each='';
	$rootScope.pageLeaveWarning.val = 0;
	if($scope.loggedUserType=='cma' || $scope.loggedUserType=='judge'){
		$scope.calendarFlag=1;
	}
	user_id = Base64.decode(SessionFectory.get('user_id'));
	
	$scope.calData = {};
	$scope.cmjudgeslist = $rootScope.judgeList_root;
	$scope.cmjudgeassistantlist = $rootScope.Judge_AssistantList_root;
	$scope.cmaloacationlist = $rootScope.courtlocationList_root;
	$scope.hearingtimelist = $rootScope.hearingtimeList_root;
	$scope.casetypegrouplist = $rootScope.getcasetypegroupList_root;
	
	$scope.toggleCalendarTiles=function(pi,i,calId){
		if(i>-1){
			$scope.activeCalendarTiles='pi'+pi+'i'+i;
			$scope.pos={pi:pi,i:i,calId:calId};
		}
		else
		{
			$scope.activeCalendarTiles=-1;
			$scope.pos={};
		}
	};
	
	$scope.listJudge = function(successMessage) {
		
		loader.show();
		$scope.toggleCalendarDatesBlockFn();
		$scope.toggleCalendarDatesViewFn();
		$scope.calendarFlag=1;
		if($scope.calSearch.judge_id==''){$scope.calSearch.judge_id=undefined;}
		if($scope.calSearch.judge_assistant_id==''){$scope.calSearch.judge_assistant_id=undefined;}
		calendarManagementFactory.get($scope.calSearch).success(function(response) {
			$scope.judgeList = response;
			if(response.length==0){
				$rootScope.errorMessageshow = 1;
				$rootScope.errorMessage = "No calendars were found";
			}
			if(successMessage){
				$rootScope.errorMessageshow = 1;
				$rootScope.errorMessage = "Calendar "+successMessage+" successfully";
			}
			//$scope.calSearch={};
			loader.hide();
		});

		/*$('#collapseOne').removeClass('in');
        $('[data-target="#collapseOne"]').addClass('collapsed');*/
	};
	$scope.checkselection = function() {
		var flag = true;
		$rootScope.errorMessageshow = 0;
		$('.req').each(function() {
			var cur = $(this);
			id = $(this).attr("id");
			if ($.trim(cur.val()) == '' || $.trim(cur.val()) == 0 || $.trim(cur.val()) == 'a0') {
				$rootScope.errorMessageshow = 1;
				$rootScope.errorMessage = $(this).attr("mesg");
				flag = false;
				return false;
			}
		});
		var judge_name = $("#Judge option:selected").text();
		var assistant_name = $("#Judgassistant option:selected").text();
		var hearing_site = $("#Hearingsite option:selected").text();
		var hearing_time = $("#Hearingtime option:selected").text();
		var casetype_grp = $("#Castypegroup option:selected").text();
		if (flag) {
			if ($scope.calData != undefined) {
				sendData=angular.copy($scope.calData);
				console.log(sendData);
				/*remove unnecessary data*/
				sendData.judge=undefined;
				sendData.assistant=undefined;
				sendData.casetypegroup=undefined;
				sendData.hearingtime=undefined;
				sendData.location=undefined;
				/*remove unnecessary data*/
				
				
				if(sendData.Calendarid)
				{
					/* console.log($scope.calData);
					 $.each($scope.calData, function(key, value) {
					 if(value !="" || value != undefined || key != undefined ){
						 // console.log(key);
						 console.log(value);
						 console.log($scope.old_value);
						 
						 if($scope.old_value[key]!= value){
							 // console.log($scope.old_value[key]);
							 // console.log(value);
							 var value = $(".dropdown select option[value='"+value+"']").text();
							 // console.log(value);
								$scope.versement_each += '<p><span class="history-label">'+ key +':</span><span class="history-data">'+value+'</span></p>';
								//console.log($scope.versement_each);
						 }
					 }
				});  
				console.log($scope.versement_each);
					 */
					 console.log(sendData);
				calendarManagementFactory.update(sendData).success(function(response) {
						if (response == 1) {
							$scope.addedCalendarid = sendData.Calendarid;
							 $scope.HistoryMessage = '<p class="history-title">Calendar form has been updated and saved with the following data:</p><p><span class="history-calendar-label">Judge:</span><span class="history-data">'+ judge_name +'</span></p><p><span class="history-calendar-label">Judge Assistant:</span><span class="history-data">'+ assistant_name +'</span></p><p><span class="history-calendar-label">Hearing Location:</span><span class="history-data">'+ hearing_site +'</span></p><p><span class="history-calendar-label">Hearing Time:</span><span class="history-data">'+ hearing_time +'</span></p><p><span class="history-calendar-label">Casetype Group:</span><span class="history-data">'+ casetype_grp+'</span></p>';
							$('#create-new-calendar').modal('hide');
							$scope.listJudge('updated');//pass 1 for calendarAddedFlag
							calendarManagementFactory.updateHistory($scope.addedCalendarid,$scope.HistoryMessage);
							$scope.calData = {};
						}
					}); 
				}
				else{
					 calendarManagementFactory.insertcalendardata(sendData).success(function(response) {
						if (response.result == 1) {
							$scope.addedCalendarid = response.calendarid;
							 $scope.HistoryMessage = '<p class="history-title">Calendar form has been created and saved with the following data:</p><p><span class="history-calendar-label">Judge:</span><span class="history-data">'+ judge_name +'</span></p><p><span class="history-calendar-label">Judge Assistant:</span><span class="history-data">'+ assistant_name +'</span></p><p><span class="history-calendar-label">Hearing Location:</span><span class="history-data">'+ hearing_site +'</span></p><p><span class="history-calendar-label">Hearing Time:</span><span class="history-data">'+ hearing_time +'</span></p><p><span class="history-calendar-label">Casetype Group:</span><span class="history-data">'+ casetype_grp+'</span></p>';
							$('#create-new-calendar').modal('hide');
							$scope.listJudge('added');//pass 1 for calendarAddedFlag
							calendarManagementFactory.updateHistory($scope.addedCalendarid,$scope.HistoryMessage);
							$scope.calData = {};
							console.log($scope.HistoryMessage);
						}
					});
				}
			}
		}
	};
	$scope.editCalendar=function(calData){
		$scope.old_value = angular.copy(calData);
		console.log($scope.old_value);
		$scope.calData=calData;
		$('#create-new-calendar').modal('show');
	}
	$scope.closeModal=function(){
		$('#create-new-calendar').modal('hide');
		$scope.calData={};
		$scope.elementDataLoader.errorVal=0;
	}
	$scope.deleteCalendar=function(id){
		var d = new Date();
		$scope.calendarDeleteddate = $filter('date')(new Date(d), 'MM-dd-yyyy');
		$('#delete-confirmation').modal('hide');
		calendar={};
		for (var c in $scope.judgeList) {
			$scope.judgeList[c].filter(function(v){
				if(v.Calendarid==id) calendar = v;
				return v.Calendarid==id;
			})
		}
		$scope.judgeName = calendar.judge;
		$scope.judgeAssistant = calendar.assistant;
		$scope.hearingLocation = calendar.location;
		$scope.hearingtime = calendar.hearingtime;
		$scope.casetypeGroup = calendar.casetypegroup;
		calendarManagementFactory.delete({Calendarid:id}).success(function(response) {
			if (response == 1) {
				$scope.listJudge('deleted');
				$scope.HistoryMessage = '<p><span class="history-calendar-label">Calendar has been removed:</span><span class="history-data">'+ $scope.calendarDeleteddate +'</span></p><p class="history-title2"><b>Judge:</b> '+$scope.judgeName+', <b>Judge Assistant:</b> '+$scope.judgeAssistant+', <b>Hearing Location:</b> '+$scope.hearingLocation+', <b>Hearing Time:</b> '+$scope.hearingtime+', <b>Casetype Group:</b> '+$scope.casetypeGroup+'</p>';
					calendarManagementFactory.updateHistory(id,$scope.HistoryMessage);
			}
		});
	}
	
	$scope.getRowNo=function(i){
		currentRow=(parseInt(i/3)+1)*3;
		return currentRow;
	};
	
	$scope.getParentChildRowNo=function(pi,i){return ('prow'+pi+'crow'+$scope.getRowNo(i))};
	
	$scope.toggleCalendarDatesBlockFn=function(i,calendarId){
		$scope.showCalendarDatesView=0;
		$scope.showCalendarDatesBlock=i?i:0;
		if(i){
			scrollTo('.calendar-view-date-wrapper');
			getDates(calendarId);
		}
		else{
			$scope.toggleCalendarTiles();
		}
	};
	$scope.toggleCalendarDatesViewFn=function(i,calendarId){
		$scope.showCalendarDatesBlock=0;
		$scope.showCalendarDatesView=i?i:0;
		if(i){
			scrollTo('.calendar-view-date-wrapper');
			getDates(calendarId,true);
		}
		else{
			$scope.toggleCalendarTiles();
		}
	};
	scrollTo=function(elem){
		setTimeout(function(){
			offset=angular.element(elem).offset();
			if(offset){
				angular.element('body').scrollTop(offset.top-60);
			}
		},100);

	};
	/* start watch activeCalendarTiles for scroll top*/
	$scope.$watch('activeCalendarTiles', function(newValue, oldValue) {
		if(newValue!=-1)
		{
			$scope.$evalAsync(function() {
				//setTimeout(function(){
					scrollTo('.calendar-dates-wrapper');
					scrollTo('.calendar-view-date-wrapper');
				//},100);
			});
		}
	});
	getDates=function(calendarId,viewDates,message){
		console.log(viewDates);
		loader.show();
		calendarManagementFactory.getDates(calendarId,viewDates).success(function(response) {
			$scope.calendarDatesList.initNoRecord=undefined;
			$scope.calendarDatesList=response;
			$scope.old_dates=angular.copy($scope.calendarDatesList);
			$scope.calendarDatesList.calendarId=calendarId;
			PageLeaveWarning.reset();
			if(viewDates)
			{
				if($scope.calendarDatesList.data.length==0){
					$rootScope.errorMessageshow = 1;
					$rootScope.errorMessage = "No calendar dates were found";
				}
			}
			else{
				if($scope.calendarDatesList.data.length==0){
					for(i=0;i<12;i++)$scope.addDateInput(calendarId);
					$scope.calendarDatesList.initNoRecord=true;
				}
			}
			
			if(message){				
				$rootScope.errorMessageshow = 1;
				$rootScope.errorMessage = "Calendar dates "+message+" successfully";
			}
			
			loader.hide();
			PageLeaveWarning.reset();
		});
	};
	$scope.addDateInput=function(calendarId){
		$scope.calendarDatesList.data.push({hearingdate:'',Calendarid:calendarId});
		$scope.addDatebox_flag = $scope.calendarDatesList.data.length;	
		$rootScope.pageLeaveWarning.watchCount=1;
	};
	/* 
	Name : Neha Agrawal
	Date Created : 27-02-2017-01-30
	Description : Function is used to check changed hearing date for pageleaving warning message.
	*/
	$scope.hearingDate= function()
	{
		calendarManagementFactory.getupdatedates($scope.old_dates.data,$scope.calendarDatesList.data).success(function(response) {
			if(response.updated_dates.length>0 || response.updated_dates!='')
			{
				$rootScope.pageLeaveWarning.watchCount=1;
				$scope.editDateflag = "1";
			}
		});
	}
	$scope.deleteDateInput=function(i,deleteDate){
		$('#delete-confirmation').modal('hide');
		if(i.idSchedule!=undefined)
		{	
			$scope.calendarId = i.Calendarid;
			loader.show();
			calendarManagementFactory.deleteDate({idSchedule:i.idSchedule}).success(function(response) {
				if (response == 1) {
					$rootScope.errorMessageshow = 1;
					$rootScope.errorMessage = "Calendar date deleted successfully";
					loader.hide();
					calendar={};
					for (var c in $scope.judgeList) {
						$scope.judgeList[c].filter(function(v){
							if(v.Calendarid==$scope.calendarId) calendar=v;
							return v.Calendarid==$scope.calendarId;
						})
					}
					console.log($scope.judgeList);
					console.log(calendar);
					$scope.judgeName = calendar.judge;
					$scope.judgeAssistant = calendar.assistant;
					$scope.hearingLocation = calendar.location;
					$scope.hearingtime = calendar.hearingtime;
					$scope.casetypeGroup = calendar.casetypegroup;
					$scope.deletedDate = $filter('date')(new Date(i.hearingdate), 'MM-dd-yyyy');
					$scope.HistoryMessage = '<p><span class="history-calendar-label">Calendar entry date has been removed:</span><span class="history-data">'+ $scope.deletedDate +'</span></p><p class="history-title2"><b>Judge:</b> '+$scope.judgeName+', <b>Judge Assistant:</b> '+$scope.judgeAssistant+', <b>Hearing Location:</b> '+$scope.hearingLocation+', <b>Hearing Time:</b> '+$scope.hearingtime+', <b>Casetype Group:</b> '+$scope.casetypeGroup+'</p>';
					PageLeaveWarning.reset();
					calendarManagementFactory.updateHistory($scope.calendarId,$scope.HistoryMessage);
					
					if($scope.showCalendarDatesBlock) {
						$scope.calendarDatesList.data.filter(function(v,k){
							if(v.idSchedule==i.idSchedule) $scope.calendarDatesList.data.splice(k,1);
							return;
						});
					};
					if($scope.showCalendarDatesView) {
						for (var d_index in $scope.calendarDatesList.data) {
							$scope.calendarDatesList.data[d_index].dates.filter(function(v,k){
								if(v.idSchedule==i.idSchedule) $scope.calendarDatesList.data[d_index].dates.splice(k,1);
								return;
							})
						}
					};

				}
			});
		}
		else{
			$scope.calendarDatesList.data.filter(function(v,k){
				if(v==i) $scope.calendarDatesList.data.splice(k,1);
				return;
			});
		}
	};
	$scope.updateCalendarDates=function(){
		if($scope.calendarDatesList.initNoRecord==undefined){
			if($scope.calendarDatesList.data.every( function(v){ return v.hearingdate!=''})){
				updateCalendarDatesDB($scope.calendarDatesList.data);
			}
			else
			{
				$rootScope.errorMessageshow = 1;
				$rootScope.errorMessage = ($scope.calendarDatesList.data.length>1)?'Please fill all calendar dates!':'Please fill calendar date!';
			}
		}
		else if($scope.calendarDatesList.initNoRecord){
			if($scope.calendarDatesList.data.some( function(v) {return v.hearingdate!=''})){
				let calendarDatesList=$scope.calendarDatesList.data.filter(function(v,k){
					return v.hearingdate!=''
				});
				updateCalendarDatesDB(calendarDatesList);
				$scope.old_dates=angular.copy(calendarDatesList);
			}
			else
			{
				$rootScope.errorMessageshow = 1;
				$rootScope.errorMessage = 'Please fill calendar date!';
			}
		}
	};
	updateCalendarDatesDB=function(data){
		$scope.versement_each = '';
		$scope.add_flag = '0';
		loader.show();
		
		
   calendarManagementFactory.updateDate(data).success(function(response) {
				PageLeaveWarning.reset();
				if (response == 1) {
					console.log("check condition");
					loader.hide();
					// $scope.toggleCalendarDatesBlockFn();
					 // getDates(data[0].Calendarid,"",'');
					$scope.storeMultipledates=[]; 
					var multipleDatesarray = [];
					angular.forEach(data, function(result){
						if(!("idSchedule" in result))
						{
							$scope.add_flag = "1";
							$scope.calendarId = result.Calendarid;
							multipleDatesarray.push(result.hearingdate);
						}
					});
					
					
					$scope.storeMultipledates = multipleDatesarray;
					$scope.convertedMultipledates = $scope.storeMultipledates.join(', ');
					if($scope.add_flag!='1')
					{
						calendarManagementFactory.getupdatedates($scope.old_dates.data,data).success(function(response) {
							$scope.new_one = response.updated_dates;
							$.each($scope.new_one, function(key, value) {
								$scope.calendarId = value.Calendarid;
								$scope.hearingDate = $filter('date')(new Date(value.hearingdate), 'MM-dd-yyyy');
								$scope.old_hearingDate = $filter('date')(new Date(value.hearingdate2.hearingdate), 'MM-dd-yyyy');
								if($scope.hearingDate!='' && $scope.old_hearingDate!='')
								{
								   $scope.versement_each += '<p><span class="history-calendar-label">Calendar date has been updated to:</span><span class="history-data">'+$scope.hearingDate+'</span></p><p><span class="history-calendar-label">Old Date:</span><span class="history-data">'+$scope.old_hearingDate+'</span></p>';
								}
							});
							calendar={};
							for (var c in $scope.judgeList) {
								$scope.judgeList[c].filter(function(v){
									if(v.Calendarid==$scope.calendarId) calendar = v;
									return v.Calendarid==$scope.calendarId;
								})
							}
							$scope.judgeName = calendar.judge;
							$scope.judgeAssistant = calendar.assistant;
							$scope.hearingLocation = calendar.location;
							$scope.hearingtime = calendar.hearingtime;
							$scope.casetypeGroup = calendar.casetypegroup;
							if($scope.versement_each!='')
							{
								$scope.HistoryMessage = $scope.versement_each+'<p class="history-title2"><b>Judge:</b> '+$scope.judgeName+', <b>Judge Assistant:</b> '+$scope.judgeAssistant+', <b>Hearing Location:</b> '+$scope.hearingLocation+', <b>Hearing Time:</b> '+$scope.hearingtime+', <b>Casetype Group:</b> '+$scope.casetypeGroup+'</p>';
							}
							if($scope.HistoryMessage!='')
							{
								calendarManagementFactory.updateHistory($scope.calendarId,$scope.HistoryMessage);
							}
						});
					}
					if($scope.add_flag=="1")
					{
						calendar={};
					for (var c in $scope.judgeList) {
								$scope.judgeList[c].filter(function(v){
									if(v.Calendarid==$scope.calendarId) calendar = v;
									return v.Calendarid==$scope.calendarId;
								})
							}
					$scope.judgeName = calendar.judge;
					$scope.judgeAssistant = calendar.assistant;
					$scope.hearingLocation = calendar.location;
					$scope.hearingtime = calendar.hearingtime;
					$scope.casetypeGroup = calendar.casetypegroup;
						$scope.HistoryMessage = '<p><span class="history-calendar-label">New Calendar entry date has been added:</span><span class="history-data">'+ $scope.convertedMultipledates +'</span></p><p class="history-title2"><b>Judge:</b> '+$scope.judgeName+', <b>Judge Assistant:</b> '+$scope.judgeAssistant+', <b>Hearing Location:</b> '+$scope.hearingLocation+', <b>Hearing Time:</b> '+$scope.hearingtime+', <b>Casetype Group:</b> '+$scope.casetypeGroup+'</p>';
						calendarManagementFactory.updateHistory($scope.calendarId,$scope.HistoryMessage);
					}
					getDates(data[0].Calendarid,false,'updated');
				}
			});  
	};
	$scope.deleteConfirmation=function(type,i,hearingdate){
		$scope.deleteData.date = hearingdate;
		$scope.deleteData.type=type;
		$scope.deleteData.id=i;
		$('#delete-confirmation').modal('show');
	};
	if($scope.calendarFlag){
		switch ($scope.loggedUserType) {
			case 'judge': $scope.calSearch.judge_id=user_id; break;
			case 'cma': $scope.calSearch.judge_assistant_id=user_id; break;
		}
		$scope.listJudge();
	}
	/* added by Faisal Khan	@Description: page-leave-warning-popup @Created on 	: 2017-01-30*/
	PageLeaveWarning.watch($scope,[
		// 'calendarDatesList',
		'addDatebox_flag',
		'editDateflag'
	]);
	/*end added by Faisal Khan	@Description: page-leave-warning-popup @Created on 	: 2017-01-30*/
	$scope.elementDataLoader={
		loadingVal:0,
		errorVal:0,
		defaultText:'Validating calendar...',
		token:0
	};
	$scope.validateCalendar=function(val){
		data={
			judge_id:			val.judge_id,
			judge_assistant_id:	val.judge_assistant_id,
			court_location_id:	val.court_location_id,
			casetype_group_id:	val.casetype_group_id,
			hearingtime_id:		val.hearingtime_id
		};
		if(
			val&&
			val.judge_id&&val.judge_id!=''&&
			val.judge_assistant_id&&val.judge_assistant_id!=''&&
			val.court_location_id&&val.court_location_id!=''&&
			val.casetype_group_id&&val.casetype_group_id!=''&&
			val.hearingtime_id&&val.hearingtime_id!=''
		){
			++$scope.elementDataLoader.token;
			$scope.elementDataLoader.loadingVal=1;
			$scope.elementDataLoader.errorVal=0;	
			$scope.elementDataLoader.text=$scope.elementDataLoader.defaultText;
			calendarManagementFactory.validateCalendar({
				token:$scope.elementDataLoader.token,
				data:data,
				Calendarid:val.Calendarid
			}).success(function(response) {
				if(response.token==$scope.elementDataLoader.token)
				{
					if(response.count==0){						
						$scope.elementDataLoader.loadingVal=0;					
						$scope.elementDataLoader.errorVal=0;	
					}
					else{
						$scope.elementDataLoader.loadingVal=0;					
						$scope.elementDataLoader.errorVal=1;	
					}
				}
			});
		}		
	};
}]);
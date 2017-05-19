osahApp.controller('calendarManagementController', ['$scope', '$rootScope', '$state', '$stateParams', 'DocketFactory', 'DynamicFactory', 'PartyFactory', 'Base64', 'SearchFactory', 'calendarManagementFactory', '$filter', 'loader','SessionFectory', function($scope, $rootScope, $state, $stateParams, DocketFactory, DynamicFactory, PartyFactory, Base64, SearchFactory, calendarManagementFactory, $filter, loader,SessionFectory) {
	$scope.loggedUserType = Base64.decode(SessionFectory.get('user_type'));
	$scope.calendarFlag=0;
	$scope.calSearch={};
	$scope.showCalendarDatesBlock=0;
	$scope.showCalendarDatesView=0;
	$scope.activeCalendarTiles=-1;
	$scope.calendarDatesList=[];
	$scope.deleteData=[];
	if($scope.loggedUserType=='cma' || $scope.loggedUserType=='judge'){
		$scope.calendarFlag=1;
	}
	userName = Base64.decode(SessionFectory.get('LastName'))+" "+Base64.decode(SessionFectory.get('FirstName'));
	
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
		if($scope.calSearch.Judge==''){$scope.calSearch.Judge=undefined;}
		if($scope.calSearch.Judgassistant==''){$scope.calSearch.Judgassistant=undefined;}
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
		if (flag) {
			if ($scope.calData != undefined) {
				if($scope.calData.Calendarid)
				{
					calendarManagementFactory.update($scope.calData).success(function(response) {
						if (response == 1) {
							$('#create-new-calendar').modal('hide');
							$scope.listJudge('updated');//pass 1 for calendarAddedFlag
							$scope.calData = {};
						}
					});
				}
				else{
					calendarManagementFactory.insertcalendardata($scope.calData).success(function(response) {
						if (response == 1) {
							$('#create-new-calendar').modal('hide');
							$scope.listJudge('added');//pass 1 for calendarAddedFlag
							$scope.calData = {};
						}
					});
				}
			}
		}
	};
	$scope.editCalendar=function(calData){
		$scope.calData=calData;
		$('#create-new-calendar').modal('show');
	}
	$scope.closeModal=function(){
		$('#create-new-calendar').modal('hide');
		$scope.calData={};
	}
	$scope.deleteCalendar=function(id){
		$('#delete-confirmation').modal('hide');
		calendarManagementFactory.delete({Calendarid:id}).success(function(response) {
			if (response == 1) {
				$scope.listJudge('deleted');
			}
		});
	}
	
	$scope.getRowNo=function(i){
		currentRow=(parseInt(i/3)+1)*3;
		return currentRow;
	};
	
	$scope.getParentChildRowNo=(pi,i)=>('prow'+pi+'crow'+$scope.getRowNo(i));
	
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
		loader.show();
		calendarManagementFactory.getDates(calendarId,viewDates).success(function(response) {
			$scope.calendarDatesList.initNoRecord=undefined;
			$scope.calendarDatesList=response;
			$scope.calendarDatesList.calendarId=calendarId;
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
		});
	};
	$scope.addDateInput=function(calendarId){
		$scope.calendarDatesList.data.push({hearingdate:'',Calendarid:calendarId});
	};
	$scope.deleteDateInput=function(i){
		$('#delete-confirmation').modal('hide');
		if($scope.calendarDatesList.data[i].idSchedule)
		{	
			loader.show();
			calendarManagementFactory.deleteDate({idSchedule:$scope.calendarDatesList.data[i].idSchedule}).success(function(response) {
				if (response == 1) {
					
					$rootScope.errorMessageshow = 1;
					$rootScope.errorMessage = "Calendar date deleted successfully";
					$scope.calendarDatesList.data.splice(i,1);
					loader.hide();
				}
			});
		}
		else{			
			$scope.calendarDatesList.data.splice(i,1);
		}
	};
	$scope.updateCalendarDates=function(){
		if($scope.calendarDatesList.initNoRecord==undefined){
			if($scope.calendarDatesList.data.every( v=>v.hearingdate!='')){
				updateCalendarDatesDB($scope.calendarDatesList.data);
			}
			else
			{
				$rootScope.errorMessageshow = 1;
				$rootScope.errorMessage = ($scope.calendarDatesList.data.length>1)?'Please fill all calendar dates!':'Please fill calendar date!';
			}
		}
		else if($scope.calendarDatesList.initNoRecord){
			if($scope.calendarDatesList.data.some( v=>v.hearingdate!='')){
				let calendarDatesList=$scope.calendarDatesList.data.filter(function(v,k){
					return v.hearingdate!=''
				});
				updateCalendarDatesDB(calendarDatesList);
			}
			else
			{
				$rootScope.errorMessageshow = 1;
				$rootScope.errorMessage = 'Please fill calendar date!';
			}
		}
	};
	updateCalendarDatesDB=function(data){
		loader.show();
		calendarManagementFactory.updateDate(data).success(function(response) {
				if (response == 1) {
					loader.hide();
					$scope.toggleCalendarDatesBlockFn();
					getDates(data[0].Calendarid,false,'updated');
					
				}
			});
	};
	
	/* validateCalendarDate=function(){
		let flag=false;
		angular.forEach($scope.calendarDatesList.data,function(v,k){
			if(v.hearingdate){
				flag=true;
			}
		});
		
		if(flag==false){
			$rootScope.errorMessageshow = 1;
			$rootScope.errorMessage = 'Please fill calendar date!';
		}
		return flag;
	}; */
	$scope.deleteConfirmation=function(type,i){
		$scope.deleteData.type=type;
		$scope.deleteData.id=i;
		$('#delete-confirmation').modal('show');
	};
	if($scope.calendarFlag){
		switch ($scope.loggedUserType) {
			case 'judge': $scope.calSearch.Judge=userName; break;
			case 'cma': $scope.calSearch.Judgassistant=userName; break;
		}
		$scope.listJudge();
	}
	
}]);
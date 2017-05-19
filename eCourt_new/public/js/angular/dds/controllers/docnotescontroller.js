osahApp.controller('docnotescontroller', ['$scope', '$rootScope', '$state', '$stateParams', 'DocketFactory', 'DynamicFactory', 'PartyFactory', 'Base64', 'SearchFactory', '$filter', 'loader','$http','NotesFactory', function($scope, $rootScope, $state, $stateParams, DocketFactory, DynamicFactory, PartyFactory, Base64, SearchFactory, $filter, loader,$http,NotesFactory) {
	loader.show();
	$scope.encoded_docket_number = $stateParams.reqdt;
	$rootScope.errorMessageshow = 0;
	$scope.docket_number = '';
	//rootScope.contactList_root
	$scope.getDocketinformation = function() {	
		$scope.docket_number = Base64.decode($stateParams.reqdt);
		$scope.reqdt = $stateParams.reqdt;
		$scope.party_data = '';
		$scope.result = '';
		/* 
			Function is used to display docket information
		*/
		DocketFactory.searchbydocket("docketsearch", "caseid = '" + $scope.docket_number + "'").success(function(response) {
			$scope.result = response;
			$scope.partyResult = response['peopleData'];
			$scope.agencyCode =  $scope.result['docketData'][0].refagency;
			$scope.casetype = $scope.result['docketData'][0].casetype;
			$scope.casefiletype =response['docketData'][0].casefiletype;
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
			
			angular.forEach($scope.partyResult, function(value, key) {
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
	
	$scope.addNotes=function(){
		loader.show();
		$scope.summarynotes = $scope.summarynotes;
		NotesFactory.add({
			summarynotes:$scope.summarynotes,
			caseid:$scope.docket_number
		}).success(function(response) {
			loader.hide();
			if(response=='1')
			{
					$rootScope.errorMessageshow = 1;
					$rootScope.errorMessage = "Notes added successfully.";
					$('#add-note-summary').modal('hide');
					$scope.getNoteslist();
					$scope.HistoryMessage = "<p class='history-title'>Notes has been added with the following data:</p><p> "+ $scope.summarynotes +" </p>";
					$scope.summarynotes='';
					$scope.updateHistory($scope.docket_number,$scope.HistoryMessage);
			}
			else
			{
				$rootScope.errorMessageshow = 1;
				$rootScope.errorMessage = "Notes not added, please try again.";
			}
		});
	};
	
	//Get contact type from databse
	$scope.getNoteslist = function()
	{
		loader.show();
		DynamicFactory.getdynamicdata("summarytable","caseid",$scope.docket_number,"1").success(function(response){
			loader.hide();
			$scope.notesList=response;
			$scope.sortingOrder ='date';
			$scope.reverse = true;
		});
	}
	$scope.getNoteslist();
	
	/* 
			Name : Neha
			Description : Function is used to delete the notes.
			Created on : 25-10-2016
		*/
		
		$scope.deleteNotes = function(notesId){
			$rootScope.errorMessageshow=0;
			$scope.summaryNotes = $('#summarynotes'+notesId).val();
			NotesFactory.deleteNotes(notesId).success(function(response){
				$scope.deleteNotesresult = response;				
				if($scope.deleteNotesresult == 'true')
				{
					$rootScope.errorMessageshow=1;
					$rootScope.errorMessage="Notes deleted successfully";
					$('#deleteNotes'+notesId).modal('toggle');
					$('.modal-backdrop.in').hide();
					$scope.getNoteslist();
					$scope.HistoryMessage = "<span>Deleted Notes!</span><p> "+ $scope.summaryNotes +" </p>";
					$scope.summarynotes='';
					$scope.updateHistory($scope.docket_number,$scope.HistoryMessage);
				}else{
					alert("some error occured");
				}
			});
		};
	
	 /* 
        Author Name : Amol s.
        Description : Function sort_by is used to on click documnet heading sorting.
		Added by FAISALK This should be in common because this is repeating.
      */
    $scope.sort_by = function(newSortingOrder) {
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
	/* 
		Author : Neha
		Date created : 08-11-2016
		Description : Function is used to get notes data for update.
	*/
	$scope.notesId;
	$scope.summary;
	$scope.getNotes = function(NotesId,summary)
	{
		$scope.notesId = NotesId;
		$scope.summary = summary;
		$('#update-note-summary'+NotesId).modal();
	}
	
	/* 
		Author : Neha
		Date created : 08-11-2016
		Description : Function is used to update notes detail.
	*/
	$scope.updateNotes=function(notesId){
		loader.show();
		$scope.summaryNotes = $('#summarynotes'+notesId).val();
		console.log($scope.summaryNotes);
		NotesFactory.updateNotes({summarynotes:$scope.summaryNotes,notesId:notesId
		}).success(function(response) {
			loader.hide();
			if(response=='1')
			{
					$rootScope.errorMessageshow = 1;
					$rootScope.errorMessage = "Notes updated successfully.";
					$('#update-note-summary'+notesId).modal('hide');
					$scope.getNoteslist();
					$scope.HistoryMessage = " <p class='history-title'>Notes has been updated with the following data:</p><p> "+ $scope.summaryNotes +" </p>";
					$scope.summarynotes='';
					$scope.updateHistory($scope.docket_number,$scope.HistoryMessage);
					
			}
			else
			{
				$rootScope.errorMessageshow = 1;
				$rootScope.errorMessage = "Notes not updated, please try again.";
			}
		});
		
	};
	
		$scope.updateHistory = function(docket_number,HistoryMessage){
		DocketFactory.updateHistory({
			caseid:docket_number,
			message:HistoryMessage
		}).success(function(response){
	     console.log(response);
	});	
};
}]);
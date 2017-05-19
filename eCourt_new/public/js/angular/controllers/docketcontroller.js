             //Search Result controller
  osahApp.controller('docketcontroller',['$scope','$rootScope','$state','$stateParams','DocketFactory','DynamicFactory','PartyFactory','Base64','SearchFactory','$filter','loader','$http','$window','DocumentTemplateFactory','SessionFectory','FileFactory','$timeout','PageLeaveWarning',function($scope,$rootScope,$state,$stateParams,DocketFactory,DynamicFactory,PartyFactory,Base64,SearchFactory,$filter,loader,$http,$window,DocumentTemplateFactory,SessionFectory,FileFactory,$timeout,PageLeaveWarning){
      
	  loader.show();
     $scope.flag_type = '';
     $scope.validation_message = '';
	 $scope.listPartyflag = ''; // party listing flag.
	 $scope.encoded_docket_number = $stateParams.reqdt;
	 $scope.empty_result_flag = ''; // if no records found.
	 $scope.listDocumentflag = '0'; // Files listing flag
	 $rootScope.errorMessageshow=0;
	 $scope.hearingTime=0;
	 $scope.updatedocketStatus='0';
     $scope.contactType='0';
     $scope.cmachange_lage='0';
	 $scope.listDispositionflag = '0'; // disposition listing flag.
     $scope.olddocketStatus='';
     $scope.document_types_list='';
     $scope.documents_types='';
     $scope.templatedocumentType='0'
     $scope.decisionDocumentList=''; //Decision Docuemet list 
	 $scope.reopenCaseflg = "0";
	 $scope.reasons = '';
	  $scope.desc = '';
	  $scope.document_template_id=0;
	  $rootScope.pageLeaveWarning.val = 0;
	  $scope.changed_flag = '0';

	  $scope.state = 'GA';

	$scope.allDocumentList=''; //All Document list will come here

    $scope.nonDecisionDocumentList=''; //NonDecision Docuemet list 
      //Check The loged user type
    $scope.loggeduser_type = Base64.decode(SessionFectory.get('user_type'));
	$scope.decision_type = '0'; // Flag to check document type(DECISION) and based on that it will show/hide disposition button.
	  //$scope.loggeduser = $rootScope.loggedUsertype;
    $scope.dispositions_data ="";
	$scope.checkHearingdate="0";		

      $scope.documentList = ''; //Get the document list
      $scope.sortingOrder  = ''; //Set the sorting order
      $scope.reverse       = false;  //Make reverse sort order false
      $scope.docketdetails  = ''; // Get the docket details for showing general informaion
      $scope.hearingTypedetails  = ''; // Get the hearing type details of respective docket
      $scope.hearingMode='0';

      $scope.countyList_root      =  $rootScope.countyList_root; //Get County list
      $scope.AgencyList           =  $rootScope.AgencyList_root; //Get Agency list
      $scope.casetypesList        =  $rootScope.casetypesList_root; //Get casetypes list
      $scope.judgeList            =  $rootScope.judgeList_root; //Get judge list
      $scope.Judge_AssistantList  =  $rootScope.Judge_AssistantList_root; //Get Judge_Assistant list
      $scope.courtlocationList    =  $rootScope.courtlocationList_root; //Get courtlocation list
      $scope.statusList           =  $rootScope.statusList_root; //Get status list
      $scope.hearingtimeList     =  $rootScope.hearingtimeList_root; //Get status list
	  $scope.hearingTypedetails =   $rootScope.hearingTypedetails; //Get Hearing Type List
      $scope.docket_number ='';
      $scope.selected_userid='';
      $scope.dataSourceUserlist='';
	  $scope.skip_hearingDate = '0';

      // console.log( $scope.countyList_root);
      //Add Partty autocomplect use this function Start Here // Amol s
      var ctrl = this;
        ctrl.party ={"name":'', "id":''};
        $scope.setAddPartyData = function(item){
            $scope.selecteduserid="";
             if (item){
                 ctrl.party = item;
                $scope.selecteduserid=ctrl.party.id;
                $scope.getuserInformation("add");
             }  
             
        }
		
		
      //Add Partty autocomplect  function Ends Here // Amol s
      
	// function to capitailize first letter // Affan
		 capitailizeletter = function (string) {
			 string.replace('mailedd','Mailedd');
			return (string.charAt(0).toUpperCase() + string.slice(1)).replace( /([A-Z])/g, " $1" ).replace('_'," ").replace('code',' Code').replace('judge',' Judge').replace('date',' Date').replace('time',' Time').replace('assistant',' Assistant').replace('requested',' Requested').replace('mode',' Mode').replace('ref',' Ref').replace('number',' Number').replace('Boxno',' Box No.').replace('site',' Site').replace('yesno',' ').replace( 'name', " Name" ).replace('mailedddate',"Mailed Date");
		};
		

       //Edit Partty autocomplect use this function Start Here // Amol s
      var edit_ctrl = this;
        edit_ctrl.party ={"name":'', "id":''};
        $scope.setEditPartyData = function(item){
            $scope.edit_selecteduserid="";
             if (item){
                 edit_ctrl.party = item;
                $scope.edit_selecteduserid=edit_ctrl.party.id;
                $scope.getuserInformation("edit");
             }  
             
        }
      //Edit Partty autocomplect  function Ends Here // Amol s

	  $scope.versement_each='';

      /* //rootScope.contactList_root */
	  
		$scope.getDocketinformation=function(){
		  $scope.docket_number = Base64.decode($stateParams.reqdt);
				 $scope.party_data = '';
          $scope.result = '';
				 /* 
					Function is used to display docket information
				 */
            DocketFactory.searchbydocket("docketsearch","caseid = '"+$scope.docket_number+"'").success(function(response){
                 $scope.result = response['peopleData'];
				  $scope.docketData = response['docketData'];
				if(response['docketData'] == '' || response['docketData'] == undefined){
					$rootScope.pageLeaveWarning.val = 0;
					$state.go("home");
  					$scope.empty_result_flag = '1';
  					$rootScope.errorMessageshow=1;
  					$rootScope.errorMessage="This docket does not exist in eCourt. Please try a different search.";
					console.log($rootScope.errorMessage);
				}
				  $scope.getstatues =  $scope.docketData[0].status;
                 $scope.ppldetail = response['peopleData'];
                 $scope.dockets = response['docketData'];
				 
				 

                $scope.agencyCode =  $scope.dockets[0].refagency;
                $scope.casetype = $scope.dockets[0].casetype;
                $scope.casefiletype = $scope.dockets[0].casefiletype;
                $scope.casetypeselect= $scope.dockets[0].casetype;
                $scope.county = $scope.dockets[0].county;
                $scope.countyselect = $scope.dockets[0].county;
                $scope.docketStatus = $scope.dockets[0].status;
                $scope.olddocketStatus= $scope.dockets[0].status;
				$scope.caseLocation = $scope.dockets[0].hearingsite;
				if($scope.docketStatus=="Closed")
				{
					$scope.readonly_flag = "1";
				}else{
					$scope.readonly_flag = "0";
				}
				if($scope.dockets[0].hearingdate == '0000-00-00' ||  $scope.dockets[0].hearingdate==null)
				{
					$scope.hearingDate = '';
					$scope.skip_hearingDate = "1";
				}else{

					/* edited by Faisal Khan	@Description: UTC issue because of this showing previous date @Edited on 	: 2017-04-03*/
					/*for not getting manual mode and utc issue*/
					var d = new Date($scope.dockets[0].hearingdate);
					d.setTime( d.getTime() + d.getTimezoneOffset()*60*1000 );
					viewDate = ($scope.dockets[0].hearingdate)?$filter('date')(new Date(d), 'MM-dd-yyyy'):'';
					$scope.elementDataLoader.lastAutomatedHearingDate=viewDate;
					/*for not getting manual mode and utc issue*/
					
					$scope.hearingDate = $scope.dockets[0].hearingdate;
					
				//PageLeaveWarning.reset();
				}
				$scope.previous_hearingDate =  $scope.dockets[0].hearingdate;
                $scope.hearingTime = $scope.dockets[0].hearingtime;
                $scope.judge = $scope.dockets[0].judge;
                $scope.judgeAssistant = $scope.dockets[0].judgeassistant;
                $scope.agencyRefnumber = $scope.dockets[0].agencyrefnumber;
			       	$scope.dateRequested = $scope.dockets[0].daterequested;
					console.log($scope.dateRequested);
                $scope.dateReceivedbyOsah = $scope.dockets[0].datereceivedbyOSAH;
                $scope.hearingMode = $scope.dockets[0].hearingmode;
                $scope.docketCreated= $scope.dockets[0].docketclerk;
                /*Show New Foramt of Docket #*/

                  var OlddocketNumber = $scope.dockets[0].docketnumber;
                  var SplitdocketNumber = OlddocketNumber.split('-');
                  var NewdocketNumber = SplitdocketNumber[2]+'-'+SplitdocketNumber[0]+'-'+SplitdocketNumber[1]+'-'+SplitdocketNumber[3]+'-'+SplitdocketNumber[4];
                  $scope.docket_no=NewdocketNumber;

                /* 
				Used to display typeofcontact at the top of the docket. 
				*/
				$scope.petitioner_flg = '0';
				$scope.respondent_flg = '0';
				
				angular.forEach($scope.result, function(value, key){
					$scope.respondentName = '';
					
					if(value.typeofcontact == "Petitioner")
					{
						$scope.petitioner_flg = value.typeofcontact;
						
						$scope.Firstname = value.Firstname;
						$scope.Lastname = value.Lastname;
						// $scope.docketCreated= value.docketclerk;
						// $scope.show_party='0';
						$scope.petitioner_flg = '1';
					}
					if(value.typeofcontact == "Respondent")
					{
						
						$scope.RespfirstName = value.Firstname;
						$scope.ReslastName = value.Lastname;
						// $scope.docketCreated= value.docketclerk;
						$scope.respondent_flg = '1';
						// $scope.show_party='0';
					}
				});
             /*Code needs to be optmised  Amol s 19-01-2017*/
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
				hearingDateLoadCounter=0;
				PageLeaveWarning.reset();
			});
			loader.hide();
			/* 
				Name : Neha Agrawal
				Description : Function is used to list the files data.
			*/
			$scope.documentListing = function()
			{
				$scope.decision_type = '0';
				$scope.listDocumentflag = '0';
				SearchFactory.searchbyvalue("documentstable","Caseid ='"+$scope.docket_number+"'").success(function(response){

					$scope.documentList = response;
					console.log($scope.documentList);
					if($scope.documentList!='')
					{
						$scope.listDocumentflag = '1';
						angular.forEach($scope.documentList, function(value, key){
							if(value.DocumentType == "Decision" && value.roc_flag==0){
								$scope.decision_type = '1';
							}
					  });
					}
					 

				}); 
			}
			$scope.documentListing();
        };
		
         /* 
        Author Name : Amol s.
        Description : below Factory will get the respective documnets of docket.
      */ 
		
      
      /* 
        Author Name : Amol s.
        Description : below Factory will get the hearing time from the table `judgescountymaping`
      */   
       // DocketFactory.getHearingtime("judgescountymaping","mappingid !=0  ORDER BY `hearingtime`").success(function(response){
            
               // console.log(response);

//            $scope.documentList = response;
//			if($scope.documentList=='')
//			{
//				$scope.empty_result_flag_document = '1';
//			}

    //  });   
      


        // }
   //Get contact type from databse
		DynamicFactory.getdynamicdata("typeofcontact","id","0","2").success(function(response){
			$scope.contactList=response;
		});
		/* 
			
		*/
		DynamicFactory.getdynamicdata("states","idstates","0","2").success(function(response){
			$scope.stateList=response;
		});
		$scope.statename = 'GA';
    // $scope.stateList = [{id:2, name : 'AK'},{id :1, name : 'AL'},{id :4, name : 'AR'},{id :3, name : 'AZ'},{id :5, name : 'CA'},{id :6, name : 'CO'},{id :7, name : 'CT'},{id :8, name : 'DE'},{id :9, name : 'FL'},{id :10, name : 'GA'},{id :11, name : 'HI'},{id :15, name : 'IA'},{id :12, name : 'ID'},{id :13, name : 'IL'},{id :14, name : 'IN'},{id :16, name : 'KS'},{id :17, name : 'KY'},{id :18, name : 'LA'},{id :21, name : 'MA'},{id :20, name : 'MD'},{id :19, name : 'ME'},{id :22, name : 'MI'},{id :23, name : 'MN'},{id :25, name : 'MO'},{id :24, name : 'MS'},{id :26, name : 'MT'},{id :33, name : 'NC'},{id :34, name : 'ND'},{id :27, name : 'NE'},{id :29, name : 'NH'},{id :30, name : 'NJ'},{id :31, name : 'NM'},{id :28, name : 'NV'},{id :32, name : 'NY'},{id :35, name : 'OH'},{id :36, name : 'OK'},{id :37, name : 'OR'},{id :38, name : 'PA'},{id :51, name : 'PR'},{id :39, name : 'RI'},{id :40, name : 'SC'},{id :41, name : 'SD'},{id :42, name : 'TN'},{id :43, name : 'TX'},{id :44, name : 'UT'},{id :46, name : 'VA'},{id :52, name : 'VI'},{id :45, name : 'VT'},{id :47, name : 'WA'},{id :49, name : 'WI'},{id :48, name : 'WV'},{id :50, name : 'WY'}];
   //Amol s Get the autopopulate party details 
      //Amol s Get the autopopulate party details 
    $scope.dataAutopopulate = function(){
		$scope.typeOfcontact = '';
		// if($scope.contactType=="Case Worker" || $scope.contactType=="Agency Attorney")
		// {
			// $scope.typeOfcontact = $scope.contactType;
		// }
		// if($scope.edit_contact_type=="Case Worker" || $scope.edit_contact_type=="Agency Attorney")
		// {
			// $scope.typeOfcontact = $scope.edit_contact_type;
		// }
		// if($scope.update_contact_type=="Case Worker" || $scope.update_contact_type=="Agency Attorney")
		// {
			// $scope.typeOfcontact = $scope.update_contact_type;
		// }
      DocketFactory.autopopulate($scope.typeOfcontact).success(function(response){
          $scope.dataSourceUserlist=response;
      });
    }
    $scope.dataAutopopulate();

    /* 
			Neha
			Description : Function is used to filtered the add party fields based on user type.
		*/
			$scope.TypeofContact = function(contact_type){
				$scope.dataAutopopulate();
				$scope.contact_type = contact_type;
				if($scope.contact_type == 'Minor/children')
				{
					$scope.flag_type = 1;
				}else if($scope.contact_type == 'Petitioner Attorney' || $scope.contact_type == 'Respondent Attorney' || $scope.contact_type == 'Agency Attorney' || $scope.contact_type == 'Other Attorney'){
					$scope.flag_type = 2;
}else{
					$scope.flag_type = 3;
}

};

			/* 
				Author Name : Neha
				Description : Function is used to add party information.
			*/
			$scope.addParty = function(){
				$rootScope.errorMessageshow=0;
				$rootScope.errorMessage = '';
				if($scope.contactType=='Minor/children')
				{
					if($scope.last_name=='' || $scope.last_name==undefined || $scope.contactType=='' || $scope.contactType==undefined || $scope.first_name=='' || $scope.first_name==undefined)
					{
						$('.req_data').each(function(){
							var cur = $(this);
							id = $(this).attr("id");
							if ($.trim(cur.val()) == '' ||  $.trim(cur.val()) == 0 ){
								$rootScope.errorMessageshow=1;
								$rootScope.errorMessage=$(this).attr("msg");
								return false;
							}
						});
					}else{
						  // $scope.formatted_dob = $filter('date')(new Date($scope.dob), 'yyyy-MM-dd');
						  loader.show();
						  var partyData = {docket_number:$scope.docket_number,contactType:$scope.contactType,last_name:$scope.last_name,first_name:$scope.first_name,middle_name:$scope.middle_name,dobyear:$scope.dobyear}
						  PartyFactory.addParty(partyData).success(function(response){
							  loader.hide();
							  if(response=="true"){
    								$rootScope.errorMessageshow=1;
    								$rootScope.errorMessage="Party added successfully!";
    								$('#addparty').modal('toggle');
									$scope.clearFieldonaddparty(); // To clear the add part fields when party is added sucessfully 
    								$scope.getDocketinformation();// To Get the Docket Information
    								$scope.partydetails(); // to Get the party listing
									$scope.dataAutopopulate();// To Get the  New added partys in autopopulate

							  }else if(response=="0")
							  {
								$rootScope.errorMessageshow=1;
								$rootScope.errorMessage="Party already exists!";
							  }
							  else{
								  $rootScope.errorMessageshow=1;
								  $rootScope.errorMessage="Some thing went wrong try again later";
							  }
						  

						  });
					}
				}
				
				else{
					$scope.last_name = $('#last_name').val();
					if($scope.last_name=='' || $scope.last_name==undefined || $scope.contactType=='' || $scope.contactType==undefined || $scope.first_name=='' || $scope.first_name==undefined || $scope.address1=='' || $scope.address1==undefined || $scope.city=='' || $scope.city==undefined || $scope.statename=='' || $scope.statename==undefined || $scope.zip_code=='' || $scope.zip_code==undefined)
					{
						$('.req_data').each(function(){
							var cur = $(this);
							id = $(this).attr("id");
							if ($.trim(cur.val()) == '' ||  $.trim(cur.val()) == 0 ){
								$rootScope.errorMessageshow=1;
								$rootScope.errorMessage=$(this).attr("msg");
								return false;
							}
						});
					}else{
						loader.show();
						if($scope.email=='' || $scope.email==undefined)
						{
							$scope.email = 'No Email';
						}else{
							$scope.email;
						}
						var partyData = {docket_number:$scope.docket_number,contactType:$scope.contactType,last_name:$scope.last_name,first_name:$scope.first_name,middle_name:$scope.middle_name,attorney:$scope.attorney_no,title:$scope.title,company_name:$scope.company_name,address1:$scope.address1,address2:$scope.address2,city:$scope.city,state:$scope.statename,zip_code:$scope.zip_code,phone:$scope.phone,email:$scope.email,fax:$scope.fax}
						PartyFactory.addParty(partyData).success(function(response){
							loader.hide();
							$.each(partyData, function(key, element) {
								if(element != ""){
									$scope.versement_each += '<p><span class="history-label">'+ capitailizeletter(key) +':</span><span class="history-data">'+ element+ '</span></p>';
								}
							});
							if(response=="true"){
								$rootScope.errorMessageshow=1;
								$rootScope.errorMessage="Party added successfully!";
								$('#addparty').modal('toggle');
								$scope.getDocketinformation();
								$scope.partydetails();
								$scope.dataAutopopulate();// To Get the  New added partys in autopopulate
								// $rootScope.errorMessage="Data updated successfully";
								$scope.HistoryMessage = '<p class="history-title">Party has been added with following:</p>'+$scope.versement_each;
								$scope.updateHistory($scope.docket_number,$scope.HistoryMessage);
								$scope.versement_each = "";							
									

							}else if(response=="0"){
								$rootScope.errorMessageshow=1;
								$rootScope.errorMessage="Party already exists!";
							}else{
								  $rootScope.errorMessageshow=1;
								  $rootScope.errorMessage="Some thnig went wrong tray again later";
							}
						  

						});
					}
				}
			};
     /* 
        Author Name : Amol s.
        Description : Function sort_by is used to on click documnet heading sorting.
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
                 $(this).removeClass().addClass('fa fa-chevron-down');
         });
        
         if ($scope.reverse){
           $('td .'+newSortingOrder+' i').removeClass().addClass('fa fa-chevron-up');
         }else{
           $('td .'+newSortingOrder+' i').removeClass().addClass('fa fa-chevron-down');
         }
    }
//Update the Docket General Details 
$scope.updateDocket = function(){
	 var casetypeid =  $('#casetypeselect').find('option:selected').attr('castyp');
	if(casetypeid!=undefined && casetypeid !='' && casetypeid!=null && casetypeid!= 'a0')
			  {
				condition="Casetypeid="+casetypeid;
				 SearchFactory.searchbyvalue("hearingdateskip",condition).success(function(response){
                  if(response==''|| response==null || response.empty ){
                  $scope.skip_hearingDate = "0";
                  }else{
					 $scope.skip_hearingDate = "1";
                  }
              });
			  }
    var flag=true;
  $rootScope.errorMessageshow= 0;
    //$('.top-error-msg').css({'display':'block'});
	if($scope.docketStatus=="Stayed" || $scope.skip_hearingDate == "1")
	{
		 $("#hearingDate").removeClass("req");
		 $("#hearingTime").removeClass("req");
	}else{
		$("#hearingDate").addClass("req");
		$("#hearingTime").addClass("req");
	}

    $('.req').each(function(){

      var cur = $(this);
                    //console.log($.trim(cur.val()));
                        
      id = $(this).attr("id");
            
      if ($.trim(cur.val()) == '' ||  $.trim(cur.val()) == 0 ||  $.trim(cur.val()) == 'a0'){
            $rootScope.errorMessageshow=1;
            $rootScope.errorMessage=$(this).attr("mesg");
            flag= false;
          return false;

      }

    });

    if(flag){

    if( $scope.docket_number!=undefined || $scope.docket_number!=''){
        var hearing_date=''; var requested_date=''; var received_date='';
            //$scope.hearingDate = $scope.hearingDate.replace("-", "/"); $scope.hearingDate = $scope.hearingDate.replace("-", "/");
            
            hearing_date=$scope.hearingDate.replace("-", "/"); hearing_date = hearing_date.replace("-", "/");

           requested_date = $scope.dateRequested.replace("-", "/"); requested_date = requested_date.replace("-", "/");
           received_date = $scope.dateReceivedbyOsah.replace("-", "/"); received_date = received_date.replace("-", "/");
			
            hearing_date = $filter('date')(new Date(hearing_date), 'yyyy-MM-dd');
            requested_date= $filter('date')(new Date(requested_date), 'yyyy-MM-dd');
            received_date= $filter('date')(new Date(received_date), 'yyyy-MM-dd');
			 if($scope.hearingDate!="" && $scope.checkHearingdate=="0")
			 {
				if($scope.previous_hearingDate==hearing_date)
				{
					$scope.docketStatus;
				}else{
					$scope.docketStatus = 'Rescheduled';
				}
			 }
            if($scope.agencyRefnumber=='' || $scope.agencyRefnumber==undefined) $scope.agencyRefnumber=null;

           var docketGeneraldetail="";
		   if($scope.docketStatus=="Stayed" && $scope.checkHearingdate=="1")
			{
				hearing_date = '0000-00-00';
			}else{
				hearing_date;
			}
       if($scope.loggeduser_type=='clerk'){
          docketGeneraldetail={hearingsite:$scope.caseLocation, hearingdate:hearing_date, hearingtime:$scope.hearingTime, judge:$scope.judge,judgeassistant:$scope.judgeAssistant,daterequested:requested_date,datereceivedbyOSAH:received_date,agencyrefnumber:$scope.agencyRefnumber,hearingmode:$scope.hearingMode,refagency:$scope.agencyCode,casetype:$scope.casetypeselect,county:$scope.countyselect,status:$scope.docketStatus,casefiletype:$scope.casefiletype};
       
       }else{
          docketGeneraldetail={hearingsite:$scope.caseLocation, hearingdate:hearing_date,hearingtime:$scope.hearingTime,judge:$scope.judge,judgeassistant:$scope.judgeAssistant,daterequested:requested_date,datereceivedbyOSAH:received_date,agencyrefnumber:$scope.agencyRefnumber,hearingmode:$scope.hearingMode,status:$scope.docketStatus,casefiletype:$scope.casefiletype};
       
       }
      //console.log(docketGeneraldetail); return false;
        //docketGeneraldetail={hearingsite:$scope.caseLocation, hearingdate:hearing_date,hearingtime:$scope.hearingTime,judge:$scope.judge,judgeassistant:$scope.judgeAssistant,daterequested:requested_date,datereceivedbyOSAH:received_date,agencyrefnumber:$scope.agencyRefnumber,hearingmode:$scope.hearingMode};
					loader.show();
	            DocketFactory.updateGeneralinfo(docketGeneraldetail , $scope.docket_number).success(function(response){
					loader.hide();
				console.log($scope.dockets );
				//$scope.resultOldvalue = ['refagency','casetype','county','status','hearingsite','hearingdate','hearingtime','judge','judgeassistant','daterequested','datereceivedbyOSAH','agencyrefnumber','hearingtime'];
				console.log(docketGeneraldetail);
				$.each(docketGeneraldetail, function(key, value) {					
					if($scope.dockets[0][key] != value){
						var date = Date.parse(value);
						if(isNaN(date))
						 value = value;
						else
						value = $filter('date')(new Date(date), 'MM-dd-yyyy');
					$scope.versement_each += '<p><span class="history-label">'+ capitailizeletter(key) +':</span><span class="history-data">'+value+'</span></p>';
					}
					
				});				
                 $scope.getDocketinformation();
				 $scope.partydetails();
                 $rootScope.errorMessageshow=1;
				 if($scope.reopenCaseflg=='1')
				{
					 $rootScope.errorMessage="Case was reopened successfully.";
					 $scope.decision_type = '1';
					 // $scope.show_disposition_button = '1';
					 $scope.reopenCaseflg='0';
					 $scope.documentListing();
				}else{
					$rootScope.errorMessage="Data updated successfully";
					$scope.changed_flag = '0';
				}
				
				
				
				  $scope.cmachange_lage='0';
				  $scope.checkHearingdate="0";
				  console.log($scope.getstatues);
				  console.log($scope.docketStatus);
				  if($scope.getstatues == "Closed" && $scope.docketStatus == 'Rescheduled'){
					$scope.new_hearing_date = $filter('date')(new Date(hearing_date), 'MM-dd-yyyy');
					$scope.HistoryMessage = "Hearing Date has been modified to "+$scope.new_hearing_date+"<br><br>Reason: "+$scope.reasons+"<br><br>Description: "+$scope.reopenCasedesc;  
				  }else{
					$scope.HistoryMessage = '<p class="history-title">Osah form has been updated with the following data :</p>'+ $scope.versement_each;
				  }
				 if($scope.versement_each != ""){
					$scope.updateHistory($scope.docket_number,$scope.HistoryMessage);
					$scope.versement_each = "";
				 }
				console.log($rootScope.errorMessageshow);

        });

    }

   }
}

$scope.updateHistory = function(docket_number,HistoryMessage){
 DocketFactory.updateHistory({
			caseid:docket_number,
			message:HistoryMessage
		}).success(function(response){
	     console.log(response);
});	
};

if($stateParams.reqdt!=''&& $stateParams.reqdt!=undefined){

    $scope.getDocketinformation();
}



 // When the document is ready value="{{hearingDate | date : 'MM-dd-y'}}"
		//$(document).ready(function () {
			// $('#hearingDate').datepicker({
   //              format: "mm-dd-yyyy",
   //              startValue: new Date('03-01-2018')
   //    });

        // $('#dateRequested').datepicker({
        //         format: "mm-dd-yyyy"
        // });

  // $('#dateReceivedbyOsah').datepicker('setValue','2018-03-05');


		//});
		
		/* 
			Name : Neha
			Description : Function is used to fetch the party details filtered by contact type based on docket number.
		*/
		$scope.partydetails = function()
		{
			PartyFactory.partyData($scope.docket_number).success(function(response){
				$scope.party_data = response;
				console.log($scope.party_data);
				if($scope.party_data =='')
				{
					$scope.listPartyflag='0';
				}else{
					$scope.listPartyflag='1';
				}
			});
		}
		$scope.partydetails();
		/* 
			Name : Neha
			Description : Function is used to delete the party as per contact vise.
			Created on : 25-10-2016
		*/
		
		$scope.deleteParty = function(contactId,MinorId,contactType,peopleId,attorneyId,index,firstname,lastname){
			$rootScope.errorMessageshow=0;
			PartyFactory.deleteParty(contactId,MinorId,contactType,peopleId,attorneyId).success(function(response){
				$scope.deletePartyresult = response;
				if($scope.deletePartyresult == 'true')
				{
					$rootScope.errorMessageshow=1;
					$rootScope.errorMessage="Party deleted successfully!";
					$scope.partydetails();
					$scope.getDocketinformation();
					 $scope.HistoryMessage = '<p class="history-title">Party has been Deleted:</p><p><span class="history-label">Name:</span><span class="history-data">'+ firstname
								 +'</span></p><p><span class="history-label">LastName:</span><spanclass="history-data">'+ lastname +'</p></span></p>';							
									$scope.updateHistory($scope.docket_number,$scope.HistoryMessage);
									$scope.versement_each = "";
	
					$('#deleteParty'+index).modal('toggle');
					$('.modal-backdrop.in').hide();
					
					
				}else{
					$rootScope.errorMessageshow=1;
					$rootScope.errorMessage="Some thnig went wrong tray again later";
				}
			});

		};	
		
		 $scope.checkDoc = function(docId){
		   $http.post('Osahform/checkdocument',{
			 id: docId,
			}).success(function(response) {
				console.log(response);
			 if(response == 1){
				$window.location.href ='/Osahform/downloaddocument/'+docId ;
			 }else{
				$rootScope.errorMessageshow=1;
				$rootScope.errorMessage="File Not Exist!";
			 } 
			 
			});
		   
			
		  };	
	
	/* 
		Author : Neha
		Date Created : 10-11-2016
		Description : Function is used to delete the documents/files against docket number.
	*/
	$scope.deleteDocuments = function(documentId,index,docketname){
			$rootScope.errorMessageshow=0;
			DocketFactory.deleteDocument(documentId).success(function(response){
					var getabspath = response.temp_path;
					var filename = getabspath.substring(getabspath.lastIndexOf('/')+1);
				if(response.result == 'true')

				$scope.deleteDocumentresult = response;
				if($scope.deleteDocumentresult != "")

				{
					$scope.deletedDate = new Date(); 
					$scope.delete_date = $filter('date')(new Date($scope.deletedDate), 'MM-dd-yyyy');
					 
					$rootScope.errorMessageshow=1;
					$rootScope.errorMessage="Document deleted successfully!";
					$scope.documentListing();
					$('#deleteDocuments'+index).modal('toggle');
				// $scope.HistoryMessage = "<p class='history-title'>Supporting Document have been Deleted:</p><p><span class='history-label'>Name:</span><span class='history-data'>"+ $scope.docket_number +"</span></p><p><span class='history-label'>Deleted Date:</span><span class='history-data'>"+ $scope.delete_date  +"</span></p><p><span class='history-label'>File Attachment Names:</span><span class='history-data'><a  ng-click='isExpired(\""+ new Date().getTime() +"\") || checkDoc(\""+ docketname +"\")' ng-class=\"{docexpired:isExpired('"+ new Date().getTime() +"')}\" >"+docketname +"</a></span></p>";
				
				$scope.HistoryMessage = "<p class='history-title'>The file has been deleted. The deleted file is accessible through the link below for up to 48 hours from the date the document was deleted:</p><p><span class='history-label'>Name:</span><span class='history-data'>"+ docketname +"</p><p><span class='history-label'>Document:</span><span class='history-data'><a  ng-click='isExpired(\""+ new Date().getTime() +"\") || checkDoc(\""+ docketname +"\")' ng-class=\"{docexpired:isExpired('"+ new Date().getTime() +"')}\" >"+docketname +"</a></span></p>";

					$scope.updateHistory($scope.docket_number,$scope.HistoryMessage);
					// $scope.getDocketinformation();
					// $scope.partydetails();
					
					
				}else{
					$rootScope.errorMessageshow=1;
				    $rootScope.errorMessage="Some thnig went wrong tray again later";
				}
			});

		};	
		
		/* 
			Name : Neha
			Date Created : 11-11-2016
			Description : Function is used to fetch the dispositions types.
		*/
			DocketFactory.dispositionType().success(function(response){
				$scope.dispositions_results = response;
			});
			
			/* 
				Name : Neha
				Date Created : 14-11-2016
				Description : Function is used to add the disposition.
			*/
			
			$scope.addDisposition = function()
			{
				$rootScope.errorMessageshow=0;
				if($scope.dispositionType=='' || $scope.dispositionType==undefined || $scope.dispositiondate=='' || $scope.dispositiondate==undefined || $scope.signedbyjudge=='' || $scope.signedbyjudge==undefined || $scope.maileddate=='' || $scope.maileddate==undefined)
					{
						$('.disposition_data').each(function(){
							var cur = $(this);
							// id = $(this).attr("id");
							if ($.trim(cur.val()) == '' ||  $.trim(cur.val()) == 0 ){
								$rootScope.errorMessageshow=1;
								$rootScope.errorMessage=$(this).attr("msg");
								return false;
							}
						});
					}else{
						loader.show();
						
						$scope.disposition_date = $filter('date')(new Date($scope.dispositiondate), 'yyyy-MM-dd');
						$scope.judge_date = $filter('date')(new Date($scope.signedbyjudge), 'yyyy-MM-dd');
						$scope.mailed_date = $filter('date')(new Date($scope.maileddate), 'yyyy-MM-dd');
						
						var dispositionData = {dispositioncode:$scope.dispositionType, dispositiondate:$scope.disposition_date,signedbyjudge:$scope.judge_date,mailedddate:$scope.mailed_date,hearingyesno:$scope.hearing,boxno:$scope.boxno,caseid:$scope.docket_number};
						DocketFactory.addDisposition(dispositionData).success(function(response){
							loader.hide();
							dispositionData.dispositiondate = $filter('date')(new Date($scope.dispositiondate), 'MM-dd-yyyy');
							dispositionData.signedbyjudge = $filter('date')(new Date($scope.signedbyjudge), 'MM-dd-yyyy');
							dispositionData.mailedddate = $filter('date')(new Date($scope.maileddate), 'MM-dd-yyyy');
							$.each(dispositionData, function(key, element) {
								console.log(key);
								if(element != ""){
									if(key == "mailedddate"){
										key = "Mailed Date";
									}
									if(key == "signedbyjudge"){
										key = "Date Signedby Judge";
									}
									$
									$scope.versement_each += '<p><span class="history-label">'+ capitailizeletter(key) +':</span><span class="history-data">'+ element+ '</span></p>';
								}
								
							});
							if(response=="1"){
								$rootScope.errorMessageshow=1;
								$rootScope.errorMessage="Disposition added successfully!";
								 $scope.HistoryMessage = '<p class="history-title">Disposition has been added :</p>'+ $scope.versement_each;
								$('#add-decision').modal('toggle');
								$('#disposition-form')[0].reset();
								$("#disposition-form").find("input[type=radio]").val("").removeAttr('checked');
								 $scope.getDisposition();
								 $scope.getDocketinformation();
								 $scope.partydetails();
								  $scope.dispositionType='';
								 $scope.dispositiondate = '';
								 $scope.signedbyjudge='';
								 $scope.maileddate='';
								 $scope.boxno='';
								 $scope.hearing='';
								 $scope.updateHistory($scope.docket_number,$scope.HistoryMessage);
								 
								 $scope.dateRequested;
								
							}else{
								$rootScope.errorMessageshow=1;
								$rootScope.errorMessage="Some thnig went wrong tray again later";
							}
						  
						});
					}
			}
			/* 
				Name : Neha Agrawal
				Date Created : 13-01-2017
				Description : Function is used to reset disposition form modal.
			*/
			$scope.closeDispositionmodal = function()
			{
				$('#disposition-form')[0].reset();
				$("#disposition-form").find("input[type=radio]").val("").removeAttr('checked');
			}
			
			/* 
			  Name : Amol S
			  Description : Function is used to get selected user information like  Attorney, Agency or Case worker .
			  Created on : 11-11-2016
			*/
		  $scope.getuserInformation = function(flage_party){
          if(flage_party=='edit'){
             //Edit Party when select the user will get the user all in formation from table Amol s.
             if($scope.edit_selecteduserid!=undefined && $scope.edit_selecteduserid!=null && $scope.edit_selecteduserid!=''){
                    DocketFactory.getuserdetails($scope.edit_selecteduserid).success(function(response){
						console.log($scope.edit_last_name);
                      $scope.edit_last_name="";
					  $('#edit_last_name').val('');
                      $scope.edit_first_name=response[0].Firstname;
                      $scope.edit_middle_name=response[0].Middlename;
                      $scope.edit_company_name=response[0].Company;
                      $scope.edit_address1=response[0].Address1;
                      $scope.edit_address2=response[0].Address2;
                      $scope.edit_city=response[0].City;
                      $scope.edit_state=response[0].State;
                      $scope.edit_zip_code=response[0].Zip;
                      $scope.edit_email=response[0].Email;
                      $scope.edit_fax=response[0].Fax;
                      $scope.edit_phone=response[0].Phone;
                      $scope.edit_title=response[0].Title;
                      $scope.edit_last_name = response[0].Lastname;
					  $('#edit_last_name').val($scope.edit_last_name);

                    });
             }

          }else{
              //Add Party when select the user will get the user all in formation from table Amol s.
				    if($scope.selecteduserid!=undefined && $scope.selecteduserid!=null && $scope.selecteduserid!=''){
          					DocketFactory.getuserdetails($scope.selecteduserid).success(function(response){
								$('#last_name').val('');
								$scope.first_name=response[0].Firstname;
          						$scope.middle_name=response[0].Middlename;
          						$scope.company_name=response[0].Company;
          						$scope.address1=response[0].Address1;
          						$scope.address2=response[0].Address2;
          						$scope.city=response[0].City;
          						$scope.state=response[0].State;
          						$scope.zip_code=response[0].Zip;
          						$scope.email=response[0].Email;
          						$scope.fax=response[0].Fax;
          						$scope.phone=response[0].Phone;
          						$scope.title=response[0].Title;
          						$scope.last_name = $.trim(response[0].Lastname);
								$('#last_name').val($scope.last_name);	

          					});
				     }

           }
			
		  };		
			 
     /* 
        Name : Amol S
        Description : Function is used to get selected user information like  Attorney, Agency or Case worker .
        Created on : 30-11-2016
      */
      $scope.updatecasestatus = function(){
            console.log($scope.updatedocketStatus);
          if($scope.updatedocketStatus!=undefined && $scope.updatedocketStatus!=null && $scope.updatedocketStatus!='' && $scope.updatedocketStatus!=0 ){
              //Check disposition is added or not before change the status
              $scope.getDisposition();
              if($scope.dispositions_data!='' && $scope.dispositions_data!=null &&  $scope.dispositions_data!=undefined){
                  var docketGeneraldetail={status:$scope.updatedocketStatus};
                  DocketFactory.updateGeneralinfo(docketGeneraldetail , $scope.docket_number).success(function(response){
                      $rootScope.errorMessageshow=1;
                      $rootScope.errorMessage="Docket Status changed sucessfully.";
                      $('#status_modal').modal('toggle');
                      $scope.docketStatus=$scope.updatedocketStatus;
                  });
              }else{
                    $rootScope.errorMessageshow=1;
                    $rootScope.errorMessage="Before change the status please add disposition.";
              }

         }else{
                    $rootScope.errorMessageshow=1;
                    $rootScope.errorMessage="Please select the docket case status";
         }
      
      };    

       /* 
        Name : Amol S
        Description : Function is used to get selected user information like  Attorney, Agency or Case worker .
        Created on : 11-11-2016
      */
      $scope.clearFieldonaddparty = function(){
            $scope.last_name="";
            $scope.first_name="";
            $scope.middle_name="";
            $scope.company_name="";
            $scope.address1="";
            $scope.address2="";
            $scope.city="";
            $scope.state="";
            $scope.zip_code="";
            $scope.email="";
            $scope.fax="";
            $scope.phone="";
            $scope.title="";
            $scope.company_name="";
            $scope.flag_type = ''; 
            $scope.dob='';
            $scope.attorney_no=''; 
            $scope.contactType='0';

      }

      /* 
        Name : Amol S
        Description : Function is casetype_agencywise is used to when select the agency the it will get respective case types
        Created on : 21-11-2016
      */
      $scope.casetype_agencywise = function(){
           
         var agnid =  $('#agencyCode').find('option:selected').attr('agnid');
         $scope.agencyCode =  $('#agencyCode').find('option:selected').val();
         if(agnid!=undefined && agnid !='' && agnid!=null){

              DynamicFactory.getdynamicdata("casetypes","AgencyID",agnid,1).success(function(response){
                  $scope.casetypeselect='a0'; 
                  $scope.casetypesList=response;
				  setConfidentialCaseType();
              });

         }else{
			$scope.casetypeselect='a0'; 
			$scope.casetypesList= $rootScope.casetypesList_root;
			
		 }
       }

       /* 
          Name : Amol S
          Description : Function is casetype_agencywise is used to when select the agency the it will get respective case types
          Created on : 21-11-2016
      */
      $scope.casetypeCountyChange = function(){
            
         var casetypeid =  $('#casetypeselect').find('option:selected').attr('castyp');
          $scope.casetypeselect= $('#casetypeselect').find('option:selected').val();
         var countyid =   $('#countyselect').find('option:selected').attr('conty');
       $scope.countyselect =   $('#countyselect').find('option:selected').val();
        var condition="";
          if(casetypeid!=undefined && casetypeid !='' && casetypeid!=null && casetypeid!= 'a0' && countyid!=undefined && countyid !='' && countyid!=null && countyid!='a0'){
                condition="CountyID="+countyid+" && Casetypeid="+casetypeid;
              SearchFactory.searchbyvalue("judgeassist_court_mapping",condition).success(function(response){
                  if(response==''|| response==null || response.empty ){
                    $scope.judgeAssistant="0";
                    $scope.judge="0";
                    $scope.caseLocation="0"; 
                    $scope.hearingTime='0'; 

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
		Name : Neha
		Date Created : 11-11-2016
		Description : Function is used to fetch the dispositions types.
	*/
		$scope.getDisposition = function()
		{
			DynamicFactory.getdynamicdata("docketdisposition","caseid",$scope.docket_number,"1").success(function(response){
				$scope.dispositions_data = response[0];
				if($scope.dispositions_data=='' || $scope.dispositions_data==undefined)
				{
					// $scope.show_disposition_button = "1";
					 $scope.listDispositionflag = '0';
				}else{
					// $scope.show_disposition_button = "0";
					 $scope.listDispositionflag = '1';
				}
			});
		}
		$scope.getDisposition();
		
		/* 
			Name : Neha
			Date Created : 16-11-2016
			Description : Function is used to fetch the party details to update.
		*/
		
		$scope.openEditpartyModal = function(contactId,minorId,contactType,peopleId,attorneyId)
		{
			$('#editpartymodal').modal();
			PartyFactory.getParty($scope.docket_number,contactId,minorId,contactType,peopleId,attorneyId).success(function(response){
				getEditResponse = response;
				$scope.contact_id = response[0].contactid;
				$scope.minor_id = response[0].Minorid;
				$scope.people_id = response[0].peopleid;
				$scope.attorney_id = response[0].attorneyid;
				$scope.edit_contact_type = response[0].typeofcontact;
				$scope.edit_last_name = response[0].Lastname;
				$scope.edit_first_name = response[0].Firstname;
				$scope.edit_middle_name = response[0].Middlename;
				$scope.edit_title = response[0].Title;
				$scope.edit_company_name = response[0].Company;
				$scope.edit_address1 = response[0].Address1;
				$scope.edit_address2 = response[0].Address2;
				$scope.edit_city = response[0].City;
				$scope.edit_state = response[0].State;
				$scope.edit_zipcode = response[0].Zip;
				$scope.edit_phone = response[0].Phone;
				$scope.edit_email = response[0].Email;
				$scope.created_date = response[0].created_date;
				// $scope.edit_fax = response[0].fax;
				if(response[0].fax=='' || response[0].fax==undefined)
				{
					$scope.edit_fax = response[0].Fax;
				}else{
					$scope.edit_fax = response[0].fax;
				}
				$scope.edit_dobyear = response[0].dobyear;
				// $scope.updated_dob = response[0].dob;
				// if($scope.updated_dob == "0000-00-00")
				// {
					// $scope.edit_dob = '';
				// }else{
					// $scope.edit_dob = $filter('date')(new Date($scope.updated_dob), 'MM-dd-yyyy');
				// }
				$scope.edit_attorney_no = response[0].AttorneyBar;
				$scope.previous_contacttype = response[0].typeofcontact;
				if($scope.minor_id!=undefined)
				{
					$scope.flag_type = 1;
					$scope.edit_contact_type = 'Minor/children';
					$scope.previous_contacttype = 'Minor/children';
				}else if($scope.edit_contact_type == 'Petitioner Attorney' || $scope.edit_contact_type == 'Respondent Attorney' || $scope.edit_contact_type == 'Agency Attorney' || $scope.edit_contact_type == 'Other Attorney'){
					$scope.flag_type = 2;
					$scope.edit_contact_type = response[0].typeofcontact;
					$scope.previous_contacttype = response[0].typeofcontact;
				}else{
					$scope.flag_type = 3;
					$scope.edit_contact_type = response[0].typeofcontact;
					$scope.previous_contacttype = response[0].typeofcontact;
				}
				if($scope.edit_contact_type=='Agency Attorney' || $scope.edit_contact_type=='Case Worker' || $scope.previous_contacttype=='Agency Attorney' || $scope.previous_contacttype=='Case Worker')
				{
					$scope.show_auto_lastname = "1";
				}else{
					$scope.show_auto_lastname = "0";
				}
			$scope.dataAutopopulate();
				
			});
			
		}
	/* 
	Name : Neha
	Date Created : 17-11-2016
	Description : This function is used to check docket status if status is closed and still no disposition added against that docket then it allowed to add disposition and if disposition is added against the docket number whose status is closed then it will pulled up the data.
	*/
	// $scope.checkDocketstatus = function()
	// {
		// DocketFactory.checkDocketstatus($scope.docket_number).success(function(response){
			// $scope.dispositions_data = response[0];
			// if($scope.dispositions_data=='' || $scope.dispositions_data==undefined)
			// {
				// $scope.show_disposition_button = "1";
			// }else{
				// $scope.show_disposition_button = "0";
			// }
		// });
	// }
	// $scope.checkDocketstatus();
	
	/* 
	Name : Neha
	Date Created : 17-11-2016
	Description : This function is used to update the party details.
 */
	$scope.editParty = function(contactId,minorId,peopleId,attorneyId)
	{
		$rootScope.errorMessageshow='0';
		$rootScope.errorMessage = '';
				if($scope.edit_contact_type=='Minor/children')
				{
					if($scope.edit_last_name=='' || $scope.edit_last_name==undefined || $scope.edit_contact_type=='' || $scope.edit_contact_type==undefined || $scope.edit_first_name=='' || $scope.edit_first_name==undefined)
					{
						$('.edit_req_data').each(function(){
							var cur = $(this);
							id = $(this).attr("id");
							if ($.trim(cur.val()) == '' ||  $.trim(cur.val()) == 0 ){
								$rootScope.errorMessageshow=1;
								$rootScope.errorMessage=$(this).attr("msg");
								return false;
							}
						});
					}else{
							// $scope.updated_dob = $filter('date')(new Date($scope.edit_dob), 'yyyy-MM-dd');


						loader.show();
						  var EditpartyData = {minorid:minorId,peopleid :peopleId,attorney_id:attorneyId,contactid :contactId,Lastname:$scope.edit_last_name,Firstname:$scope.edit_first_name,Middlename:$scope.edit_middle_name,dobyear:$scope.edit_dobyear,caseid:$scope.docket_number,previous_contacttype:$scope.previous_contacttype,Docket_caseid:$scope.docket_number,created_date:$scope.created_date}
						  editresponsevalue = EditpartyData.previous_contacttype;
						  console.log(getEditResponse);
							PartyFactory.editParty(EditpartyData).success(function(response){
								loader.hide();
								$.each(EditpartyData, function(key, value) {
									if(key == 'previous_contacttype' || key == 'attorney_id' || key == 'minorid'){
										return true;
									 }
									else if(value !="" || value != undefined || key != undefined ){
										 if(getEditResponse[0][key] != value){
											 console.log(getEditResponse[0][key]);
												$scope.versement_each += '<p><span class="history-label">'+ capitailizeletter(key) +':</span><span class="history-data">'+value+'</span></p>';
										 }
									 }
								});
								console.log($scope.versement_each);

							if(response=="true"){
								$rootScope.errorMessageshow=1;
								$rootScope.errorMessage="Party updated successfully!";
								 $scope.HistoryMessage = '<p class="history-title">'+ editresponsevalue +' information has been updated/modified for:</p><p><span class="history-label">Name:</span><span class="history-data">'+ EditpartyData.Firstname +'</span></p><p><span class="history-label">Last Name:</span><span class="history-data">'+ EditpartyData.Lastname+'</span></p></p><p>Modified Fields are listed below:</p><p><span class="history-label">Typeofcontact:</span><span class="history-data">"Minor/CHildren"</span></p>'+ $scope.versement_each;
								 if($scope.versement_each != ""){
									$scope.updateHistory($scope.docket_number,$scope.HistoryMessage);
									$scope.versement_each = "";
								 }
								$('#editpartymodal').modal('toggle');
								$scope.getDocketinformation();
								$scope.partydetails();
							}else if(response=="0"){
								$rootScope.errorMessageshow=1;
								$rootScope.errorMessage="Party already exists!";
							}else{
								$rootScope.errorMessageshow=1;
								$rootScope.errorMessage="Some thnig went wrong tray again later";
							}
						  

						});
					}
				}else{
					$scope.edit_last_name = $('#edit_last_name').val();
					if($scope.edit_last_name=='' || $scope.edit_last_name==undefined || $scope.edit_contact_type=='' || $scope.edit_contact_type==undefined || $scope.edit_first_name=='' || $scope.edit_first_name==undefined || $scope.edit_address1=='' || $scope.edit_address1==undefined || $scope.edit_city=='' || $scope.edit_city==undefined || $scope.edit_state=='' || $scope.edit_state==undefined || $scope.edit_zipcode=='' || $scope.edit_zipcode==undefined)
					{
						$('.edit_req_data').each(function(){
							var cur = $(this);
							id = $(this).attr("id");
							if ($.trim(cur.val()) == '' ||  $.trim(cur.val()) == 0 ){
								$rootScope.errorMessageshow=1;
								$rootScope.errorMessage=$(this).attr("msg");
								return false;
							}
						});
					}else{
						loader.show();
						if($scope.edit_email=='' || $scope.edit_email==undefined)
						{
							$scope.edit_email='No Email';
						}else{
							$scope.edit_email;
						}
						$scope.updated_dob = $filter('date')(new Date($scope.edit_dob), 'yyyy-MM-dd');
						console.log($scope.edit_email);
						console.log($scope.edit_last_name);
						var EditpartyData = {minorid:minorId,peopleid :peopleId,attorney_id:attorneyId,contactid :contactId,caseid:$scope.docket_number,typeofcontact:$scope.edit_contact_type,Lastname:$scope.edit_last_name,Firstname:$scope.edit_first_name,Middlename:$scope.edit_middle_name,AttorneyBar:$scope.edit_attorney_no,Title:$scope.edit_title,Company:$scope.edit_company_name,Address1:$scope.edit_address1,Address2:$scope.edit_address2,City:$scope.edit_city,State:$scope.edit_state,Zip:$scope.edit_zipcode,Phone:$scope.edit_phone,Email:$scope.edit_email,fax:$scope.edit_fax,caseid:$scope.docket_number,previous_contacttype:$scope.previous_contacttype,Docket_caseid:$scope.docket_number,created_date:$scope.created_date}
						 console.log(getEditResponse);
						 console.log($scope.edit_last_name);
						PartyFactory.editParty(EditpartyData).success(function(response){
							loader.hide();
								 $.each(EditpartyData, function(key, value) {
									 if(key == 'previous_contacttype' || key == 'attorney_id' || key == 'minorid' || key== 'peopleid' || key== 'Contactid'){
										return true;
									 }
									// console.log("Key="+key+ "value="+ value)
									if (value !="" || value != undefined || key != undefined ){
										//console.log(getEditResponse[0][key]);
										//key = key.replace( 'name', " Name" );
										// console.log(getEditResponse[0][key] +"!="+ value); 
										if(getEditResponse[0][key] != value ){
											console.log(getEditResponse[0][key] +"!="+ value); 
												$scope.versement_each += '<p><span class="history-label">'+ capitailizeletter(key) +':</span><span class="history-data">'+value+'</span></p>';
										 }
									 }
								}); 
							if(response=="true"){
								console.log($scope.versement_each);
								$rootScope.errorMessageshow=1;
								$rootScope.errorMessage="Party updated successfully!";
								 $scope.HistoryMessage = '<p class="history-title">'+  EditpartyData.previous_contacttype +' information has been updated/modified for:</p><p><span class="history-label">Name:</span><span class="history-data">'+ EditpartyData.Firstname
								 +'</span></p><p><span class="history-label">Last Name:</span><spanclass="history-data">'+ EditpartyData.Lastname+'</p></span></p><p>Modified Fields are listed below:</p>'+ $scope.versement_each;
								//console.log($scope.versement_each);
								 if($scope.versement_each != ""){
									$scope.updateHistory($scope.docket_number,$scope.HistoryMessage);
									$scope.versement_each = "";
									$scope.HistoryMessage = "";
								 }
								$('#editpartymodal').modal('toggle');
								$scope.getDocketinformation();
								$scope.partydetails();
							}else if(response=="0"){
								$rootScope.errorMessageshow=1;
								$rootScope.errorMessage="Party already exists!";
							}else{
								$rootScope.errorMessageshow=1;
								$rootScope.errorMessage="Some thnig went wrong tray again later";
							}
						  

						});
					}
				}
				
	}
	/* 
		Neha
		Description : Function is used to filtered the update party fields based on user type.
	*/
	$scope.UpdatetypeOfcontact = function(update_contact_type){
		$scope.update_contact_type = update_contact_type;
		if($scope.update_contact_type == 'Minor/children')
		{
			$scope.flag_type = 1;
		}else if($scope.update_contact_type == 'Petitioner Attorney' || $scope.update_contact_type == 'Respondent Attorney' || $scope.update_contact_type == 'Agency Attorney' || $scope.update_contact_type == 'Other Attorney'){
			$scope.flag_type = 2;
		}else{
			$scope.flag_type = 3;
		}

	};
	
	/* 
		Author : Neha
		Date Created : 29-11-2016
		Description : Function is used to fetch all the document types from documenttype table.
	*/
	
	$scope.getDocumenttypes = function()
		{
			DocketFactory.getDocumenttypes().success(function(response){
				$scope.document_types = response;
			});
		}
		$scope.getDocumenttypes();

  $scope.show_cma_dropdown = function(flage){
	  $scope.changed_flag = '1';
		$rootScope.pageLeaveWarning.watchCount = 1;
      if(flage==1){  $scope.docketStatus="Stayed"; $scope.checkHearingdate="1";$scope.cmachange_lage=1;}else{$scope.docketStatus=$scope.olddocketStatus;$scope.cmachange_lage=0;$scope.checkHearingdate="0";
	}
  }


	

$('#dob').datepicker({
        format: "mm-dd-yyyy",
		autoclose: true
});
$('#dispositiondate').datepicker({
        format: "mm-dd-yyyy",
		autoclose: true
});
$('#judgedate').datepicker({
        format: "mm-dd-yyyy",
		autoclose: true
});
$('#maileddate').datepicker({
        format: "mm-dd-yyyy",
		autoclose: true
});
$('#edit_dob').datepicker({
        format: "mm-dd-yyyy",
		autoclose: true
});	
$('#file_date').datepicker({
        format: "mm-dd-yyyy",
		autoclose: true
});	
$('#edit_file_date').datepicker({
        format: "mm-dd-yyyy",
		autoclose: true
});	
/* commented by Faisal Khan	@Description: instead b-datepicker @commented on 	: 2017-04-03*/
/*$('#hearingDate').datepicker({
        format: "mm-dd-yyyy"
});	*/

$scope.file_changed = function(element) {
	
	var files = element.files[0].name;
	$('#files').val(files);
};

/* 

 */
 $scope.addDocument = function()
 {
	 $scope.document_name = $('#files').val();
	$rootScope.errorMessageshow=0;
				if($scope.documentType=='' || $scope.documentType==undefined)
					{
						$('.document_data').each(function(){
							var cur = $(this);
							// id = $(this).attr("id");
							if ($.trim(cur.val()) == '' ||  $.trim(cur.val()) == 0 ){
								$rootScope.errorMessageshow=1;
								$rootScope.errorMessage=$(this).attr("msg");
								return false;
							}
						});
					}else{
						var documentData = {DocumentType:$scope.documentType,Description:$scope.description,DocumentName:$scope.document_name,Docket_caseid:$scope.docket_number,Caseid:$scope.docket_number};
						DocketFactory.addDocument(documentData).success(function(response){
							if(response=="true"){
								$rootScope.errorMessageshow=1;
								// $scope.empty_result_flag_document = '0';
								$scope.listDocumentflag = '1';
								$rootScope.errorMessage="Document added successfully!";
								$('#document-templates').modal('toggle');
								$scope.documentListing();
							}else{
								alert("Some error occured!");
							}
						  
						});
					}

 }

 /*
  Auther: Amol s.
  crated :09-12-2016
  modifyed:
  Use: Load The document Teplate model And get the
*/
$scope.loadDocumentTemplate = function(){
  if($scope.agencyCode!=undefined && $scope.agencyCode!='' && $scope.casetype!= undefined && $scope.casetype!=''){
     DocumentTemplateFactory.documet_templet_list($scope.casetype,$scope.agencyCode).success(function(response){
        $scope.decisionDocumentList=response[0];  
        $scope.nonDecisionDocumentList=response[1];
        $scope.document_types_list= $scope.nonDecisionDocumentList;
     });
  }
   $scope.document_template_id=0;
   $scope.documet_templet_clear();
}

/*
  Auther: Amol s.
  crated :18-05-2017
  modifyed:
  Use: Get All Document Tepmplats
*/

  
     DocumentTemplateFactory.documet_templet_list_all().success(function(response){
         
        //console.log(response); loadDocumentList $scope.document_types_list
    	$scope.allDocumentList=response;

     });
  
   
 




/*
  Auther: Amol s.
  crated :09-12-2016
  modifyed:
  Use: On party Selection set the party name
*/
  $scope.mailerlist=[];
  $scope.setMailerlist = function(index,contactType){
   
     if($("#"+index).prop('checked')){
          //Check Box is checked
            $scope.mailerlist.push(contactType);
          
        }else{
          //Check box is unchecked
                 var tempflag='';
                  tempflag=$scope.mailerlist.indexOf(contactType);
                  if (tempflag > -1) { $scope.mailerlist.splice(tempflag, 1); }
                    
        }
       // console.log($scope.mailerlist);
  }

/*
  Auther: Amol s.
  crated :12-12-2016
  modifyed:
  Use: documet_templet_clear Will clear the fields when clicl on documentTemplate
*/

$scope.documet_templet_clear = function(){
    $scope.templatedocumentType='0';  
    $scope.description='';
    $("#doctype1").prop('checked',true);
    $('.select-check input:checked').each(function(){
        $(this).prop('checked',false);
    });
    $scope.mailerlist=[];
    $scope.documents_types='';
    $scope.templatedescription='';
}
/*
  Auther: Amol s.
  crated :12-12-2016
  modifyed:
  Use: loadDocumentList Will change the document list based on selection
*/
$scope.loadDocumentList = function(documentflage){
  if (documentflage=='decision')
      $scope.document_types_list= $scope.decisionDocumentList;
  else if(documentflage=='all')
  		$scope.document_types_list = $scope.allDocumentList;
  else
       $scope.document_types_list= $scope.nonDecisionDocumentList;

  $scope.documents_types=documentflage;
   $scope.templatedocumentType='0';   
}

/*
  Auther: Amol s.
  crated :12-12-2016
  modifyed:
  Use: Attch Document will load the template and fill out with mailer list
*/
$scope.attachDocument = function(flage){
  /* flage 1 for show the document in other new tab  other wise don't show the documnet 
      only create the document template
  */
/*console.log($scope.templatedocumentType);*/
	var doc_name = $("#templatedocumentType option:selected").text();
	$scope.docNameattachDocket = $scope.docket_number+'_'+doc_name;
    $scope.party_data
    $rootScope.errorMessageshow=0;
    $rootScope.errorMessage="";
    /*Check Fields are not empty*/
    if($scope.templatedocumentType=='' || $scope.templatedocumentType=='0' ||$scope.templatedocumentType==undefined || $scope.templatedocumentType==null){

    $rootScope.errorMessageshow=1;
    $rootScope.errorMessage="Please select document from list";
    return false;
  }
/* Set The Description tesxt field lingth 500*/
   if($scope.templatedescription.length > 500){
      $rootScope.errorMessageshow=1;
      $rootScope.errorMessage="Description should be less than 500 character";
      return false;
  }

  if($scope.mailerlist=='' || $scope.mailerlist==undefined || $scope.mailerlist==null){

    $rootScope.errorMessageshow=1;
    $rootScope.errorMessage="Please select one of the mailer from list";
    return false;
  } else{
	  loader.show();
	  
	  
  DocumentTemplateFactory.documet_templet_Attch($scope.docket_number,$scope.agencyCode,$scope.casetype,$scope.mailerlist,$scope.documents_types,$scope.templatedocumentType,flage,$scope.templatedescription,$scope.document_template_id).success(function(response){
       loader.hide();
	  //if(flage==1)
		
		$('#document-templates').modal('toggle');
		loader.show();
        $window.open(response);
         $scope.documentListing(); //Document List function tolisting the document
       
       loader.hide();
	   var desc = $scope.templatedescription!='' ? '<p><span  class="history-label">Description :</span><span class="history-data">'+ $scope.templatedescription +'</p>':'';
	   // if($scope.documents_types == '')
	   // {
			// $scope.documents_types = 'non-decision';
	   // }
		 condition="casetype='"+$scope.casetype+"' && agency='"+$scope.agencyCode+"' && id="+$scope.templatedocumentType;
              SearchFactory.searchbyvalue("casetypedocuments",condition).success(function(response){
				  $scope.templateDocumenttypeName = response[0]['documenttype'];
				  $scope.HistoryMessage = '<p class="history-title">A Document template has been added.</p><p><span class="history-label">Name:</span><span class="history-data">'+ $scope.docNameattachDocket +'</p><p><span class="history-label">Document Type:</span><span class="history-data">'+ $scope.templateDocumenttypeName +'</p></span></p>'+desc;
				  $scope.updateHistory($scope.docket_number,$scope.HistoryMessage);
			  });
      /// $window.open('upload/ammama1500009/Decision/1484229686/Decision.pdf');

    });




  }

 

}




 
 /* 
	Name : Amol Shrawane
	Description : when clerk login and changing the docket status
	Created Date : 06-12-2016
 */
 $scope.changeDocketstatus = function(doc_status){
	 $scope.docketStatus = doc_status;
 }
 
 /* 
  	Name : Neha
  	Description : Function is used to add files.
  	Created Date : 
 */
 
 $scope.addFile = function()
 {
	 $rootScope.errorMessageshow=0;
				if($scope.fileType=='' || $scope.fileType==undefined || $scope.fileDate=='' || $scope.fileDate==undefined || $scope.file_name=='' || $scope.file_name==undefined)
					{
						$('.file_data').each(function(){
							var cur = $(this);
							// id = $(this).attr("id");
							if ($.trim(cur.val()) == '' ||  $.trim(cur.val()) == 0 ){
								$rootScope.errorMessageshow=1;
								$rootScope.errorMessage=$(this).attr("msg");
								return false;
							}
						});
					}else{
						loader.show();
						$scope.updated_fileDate = $filter('date')(new Date($scope.fileDate), 'yyyy-MM-dd');

						var fileData = {DocumentType:$scope.fileType,date_filed : $scope.updated_fileDate,Description:$scope.desc,DocumentName:$scope.file_name,Docket_caseid:$scope.docket_number,Caseid:$scope.docket_number};
						FileFactory.addFile(fileData).success(function(response){
							loader.hide();
							if(response.result=="true"){
								$scope.updated_fileDate = $filter('date')(new Date($scope.fileDate), 'MM-dd-yyyy');
								console.log(fileData.Description);

								$rootScope.errorMessageshow=1;
								// $scope.empty_result_flag_document = '0';
								// $scope.listDocumentflag = '1';
								$rootScope.errorMessage="Document added successfully!";
								var desc = (fileData.Description)?'<p><span  class="history-label">Description :</span><span class="history-data">'+ fileData.Description +'</p>':'';
								
								  // $scope.HistoryMessage = '<p class="history-title">Supporting document has been added as below.</p><p><span class="history-label">Docket Name:</span><span class="history-data">'+ $scope.docket_number
								 // +'</span></p><p><span class="history-label">Document Type:</span><span class="history-data">'+ $scope.fileType +'</p></span></p>'+desc+'<p><span class="history-label">Date Filed :</span><span class="history-data">'+ $scope.updated_fileDate+'</p><p><span class="history-label">File Attachment Name :</span><span class="history-data">'+ $scope.file_name +'</p>';
								 
								 $scope.HistoryMessage = '<p class="history-title">A file has been added.</p><p><span class="history-label">File Attachment Name:</span><span class="history-data">'+ $scope.file_name +'</p><p><span class="history-label">Document Type:</span><span class="history-data">'+ $scope.fileType +'</p></span></p>'+desc+'<p><span class="history-label">Date Filed:</span><span class="history-data">'+ $scope.updated_fileDate+'</p>';

								$scope.updateHistory($scope.docket_number,$scope.HistoryMessage);
								$('#add-files').modal('toggle');
								$scope.documentListing();
								$scope.getDisposition();
								$('#file_form').trigger("reset");
								$scope.fileType = '';
								 $scope.fileDate = '';
								 $scope.file_name = '';
								 $('div.dz-preview.dz-processing.dz-image-preview.dz-success.dz-complete').hide();
								 $('div.dz-success').remove();
								if($scope.file_name=='')
									{
										$('#removeimg').removeClass( "dz-max-files-reached" );
									}
								$('div.dz-default.dz-message').show();
								   var openFilenewTab = window.open(response.file_link, '_blank');
								    openFilenewTab.focus();
								
							}else{
								$rootScope.errorMessageshow=1;
								$rootScope.errorMessage="Some thnig went wrong tray again later";
							}
						});
						}
						
 }
$scope.closeFile = function()
{
	$('#file_form').trigger("reset");
	 $scope.fileType = '';
	 $scope.fileDate = '';
	 $scope.file_name = '';
	 $('div.dz-preview.dz-processing.dz-image-preview.dz-success.dz-complete').hide();
	 $('div.dz-success').remove();
	if($scope.file_name=='')
	{
		$('#removeimg').removeClass( "dz-max-files-reached" );
	}
	$('div.dz-default.dz-message').show();
}
 
 $scope.fileData12 = '';
 
 /* var categoryDropzone;
$(document).ready(function () {
    //Dropzone functionality - Amol A 12-03-2015
    // Dropzone.autoDiscover = false;
    // var attachmentSection = $('.attachment-section-cat');
    // var fileList = new Array();
    // var uploadedImages = new Array();
    // var fileListCounter = 0;
    // var maxImageFileLimit = 50;
    // var previewTemplate = $('#template').html();
    // $('#template').remove();
    // if ($('#addimagelink-dropzone').length) {
        categoryDropzone = new Dropzone("#addimagelink-dropzone");
    // }
}); */

Dropzone.autoDiscover = false;


 $scope.dzOptions = {
        url : '/Osahform/postimageupload',
        paramName : 'file',
        // maxFilesize : '10',
        // acceptedFiles : 'image/jpeg, images/jpg, image/png',
		dictDefaultMessage : 'Drag Files Here or Click to Choose Files to Upload',
        addRemoveLinks : true,
		// maxFiles:'1',
    };


    //Handle events for dropzone
    //Visit http://www.dropzonejs.com/#events for more events
    $scope.dzCallbacks = {
		
        'addedfile' : function(file){
			if(file.isMock){
                    $scope.myDz.createThumbnailFromUrl(file, file.serverImgUrl, null, true);
					$('#editrmvimg').addClass( "dz-max-files-reached" );
					$('div.dz-size').remove();
					$('div.dz-default.dz-message').hide();
            } else {
				$scope.newFile = file;
				$('div.dz-default.dz-message').hide();
			}
        },
        'success' : function(file, xhr){
			 $('div.dz-size').remove();
			 $('div.dz-default.dz-message').hide();
			var response = JSON.parse(xhr);
			$scope.file_name = response.file.name;
			$scope.file_path = response.file.tmp_name;
			
			if($scope.file_name!='')
			{
				console.log("add");
				console.log($scope.file_name);
				$('#removeimg').addClass( "dz-max-files-reached" );
				// $('#editrmvimg').addClass( "dz-max-files-reached" );
				
			}
			
        },
		
		 'removedfile' : function(file){
            $scope.file_name = '';
            $scope.newFile = file;
			if($scope.file_name=='')
			{
				console.log("remove");console.log($scope.file_name);
				$('#removeimg').removeClass( "dz-max-files-reached" );
				// $('#editrmvimg').removeClass( "dz-max-files-reached" );
				$('div.dz-default.dz-message').show();
			}
        },
    };
	
		$scope.myDz = null;
		$scope.dzMethods = {};
		$timeout(function(){
		    $scope.myDz = $scope.dzMethods.getDropzone();
		});
		
	/* $scope.$watch('editAttachedfile', function (newvalue) {
		console.log('editAttachedfile');
		console.log('newvalue');
		console.log(newvalue);
		$scope.myDz.files = [];
		 $('div.dz-preview.dz-complete.dz-image-preview').hide();
		if(newvalue!=undefined)
		{
			
		var demoThumbUrl = newvalue;
		// var demoThumbUrl = newvalue;
        $scope.mockFiles = [
            {name:$scope.file_name, size : 5000, isMock : true, serverImgUrl : demoThumbUrl},
        ];
		$timeout(function(){
		
			console.log('$scope.myDz');
			console.log($scope.myDz);
			console.log($scope.mockFiles);
		    $scope.mockFiles.forEach(function(mockFile){
				console.log('mockFile');
				console.log(mockFile);
                $scope.myDz.emit('addedfile', mockFile);
                $scope.myDz.emit('complete', mockFile);
                $scope.myDz.files.push(mockFile);
				console.log('files');
				console.log($scope.myDz.files);
				
				
            });
		});
		}
		
	}); */
	 
	
	/* 
		Author : Neha Agrawal
		Date Created - 27-12-2016
		Description - This function is used to open document edit modal and fetch the as per document and docket id.
	*/
	
	$scope.openDocumenteditModal = function(documentId,doc_flg){
		$scope.doc_flg = doc_flg;
		console.log($scope.doc_flg);
		$scope.editDescription = '';
	    // if(doc_flg=='1'){
				$scope.editAttachedfile='';
				$('#update-files').modal();
				$scope.documentId = documentId;
				FileFactory.getFile($scope.docket_number,documentId).success(function(response){
					$scope.Fileresult = response.result[0];
					// $scope.editDocumenttype = $scope.Fileresult.DocumentType;
					// $scope.editeFiledate = $filter('date')(new Date($scope.Fileresult.DateRequested), 'MM-dd-yyyy');
					$scope.editDescription = $scope.Fileresult.Description;
					$scope.file_name = $scope.Fileresult.DocumentName;
					// $scope.newFile = $scope.Fileresult.DocumentName;
					// $scope.editAttachedfile = response.file_link;
					// $scope.myDz.files = [];
					// $('div.dz-preview.dz-complete.dz-image-preview').hide();
					// if($scope.editAttachedfile!=undefined)
					// {
						// var demoThumbUrl = $scope.editAttachedfile;
						// $scope.mockFiles = [
							// {name:$scope.file_name, size : 5000, isMock : true, serverImgUrl : demoThumbUrl},
						// ];
						// $timeout(function(){
							// $scope.mockFiles.forEach(function(mockFile){
								// $scope.myDz.emit('addedfile', mockFile);
								// $scope.myDz.emit('complete', mockFile);
								// $scope.myDz.files.push(mockFile);
							// });
						// });
					// }
					
				});
		/* }else{
			 /* Document Template edit model open code here*/
			 	// $scope.loadDocumentTemplate();	
			 	 
			 	// FileFactory.getFile($scope.docket_number,documentId).success(function(response){
			 		// $scope.docinfo = response.result[0];

			 		// $scope.agencyCode =  $scope.dockets[0].refagency;
                	// $scope.docinfo = response['result'];
			 		// console.log("sgfhsgfshfsf" + $scope.docinfo[0].casetype_doc_id);
			 	
			 	// $scope.templatedocumentType=$scope.docinfo[0].casetype_doc_id;
			 	// $scope.templatedescription=$scope.docinfo[0].Description;
				// $scope.document_template_id=$scope.docinfo[0].documentid;
			 		// if($scope.docinfo[0].DocumentType!='Decision'){
			 			// document Type is non decision
			 			// $scope.document_types_list= $scope.nonDecisionDocumentList;
			 			// $("#doctype1").prop('checked',true);
			 			// $("#doctype2").prop('checked',false);
			 		// }else{
			 			// document Type is decision
			 			// $scope.document_types_list= $scope.decisionDocumentList;
			 			 // $("#doctype2").prop('checked',true);
			 			 // $("#doctype1").prop('checked',false);
			 		// }

					// $('#document-templates').modal('toggle');


				// });
			// } */
	}
	/* 
		Name : Neha Agrawal
		Description : Function is used to update description for files.
	*/
	$scope.editFile = function(updatedoc_id)
	{
			var data = {updatedoc_id:updatedoc_id};
			var updatedfileInfo = {Description:$scope.editDescription}
			loader.show();
			FileFactory.updateFile(updatedfileInfo,data).success(function(response){
				loader.hide();
				if(response.result=="true"){
					$rootScope.errorMessageshow=1;
					$rootScope.errorMessage="Document updated successfully!";
					var type = $scope.doc_flg == '1' ? "file" : "Document template";
					$scope.HistoryMessage = '<p class="history-title">The '+type+' description has been updated:</p><p><span class="history-label">Name:</span><span class="history-data">'+ $scope.file_name +'</p><p><span class="history-label">Description:</span><span class="history-data">'+ $scope.editDescription +'</p>';
					
					$scope.updateHistory($scope.docket_number,$scope.HistoryMessage);
					
					$('#update-files').modal('toggle');
					$scope.documentListing();
				}else{
					$rootScope.errorMessageshow=1;
					$rootScope.errorMessage="Some thnig went wrong tray again later";
				}
			});
	}
	
	/* 
		Name : Neha Agrawal
		Date Created : 28-12-2016
		Desc - Function is used to fetch data from years table for minor party.

	*/
	DynamicFactory.getdynamicdata("years","id","0","2").success(function(response){
      $scope.yearList=response;
  });
  /* 
	Name : Neha Agrawal
	Date Created : 06-01-2017
	Descriptions : Variable is used to store reasons of reopen case.
  */
  $scope.reopenCasereasons = [
		  {name:"Remand by Agency"},
		  {name:"Remand by Reviewing Court"},
		  {name:"Motion for Reconsideration Granted"},
		  {name:"Motion to Vacate Granted"},
		  {name:"OSAH Error to Close"},
		  {name:"Other"}
  ];
	  /* 
		Name : Neha Agrawal
		Date Created : 06-01-2017
		Descriptions : Function is used to reopen the case.
	  */
	  
	  $scope.reopenCase = function()
	  {
		$rootScope.errorMessageshow=0;
				if($scope.reasons=='' || $scope.reasons==undefined)
					{
						$rootScope.errorMessageshow=1;
						$rootScope.errorMessage="Please select reason.";
						return false;
					}else{
						
						$scope.reasons;
						$scope.reopenCasedesc;
						console.log($scope.reopenCasedesc);
						/* start edited by Faisal Khan	@Description:  "hearingDateAutomate for reopen case" @edited on 	: 2017-05-07*/
						//$scope.hearingDate = '';
						//$scope.hearingTime = '';
						$scope.hearingDateAutomateMode();
						/* end edited by Faisal Khan	@Description: "hearingDateAutomate for reopen case" @edited on 	: 2017-05-07*/
						$scope.docketStatus = 'Rescheduled';
						$scope.readonly_flag = "0";
						$scope.partydetails();
						$('#reopen-case').modal('toggle');
						/* start edited by Faisal Khan	@Description:  "hearingDateAutomate for reopen case" @edited on 	: 2017-05-07*/
						$rootScope.errorMessageshow=1;
						//$rootScope.errorMessage="Please fill in the hearing information to reopen the case.";
						$rootScope.errorMessage="Please save the docket to reopen the case.";
						/* start edited by Faisal Khan	@Description:  "hearingDateAutomate for reopen case" @edited on 	: 2017-05-07*/
						$scope.reopenCaseflg = "1";
						$('#reopen_form').trigger("reset");
						$scope.decision_type = '0';
						$scope.partydetails();	
					}
	  }
  
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
	var hearingDateLoadCounter=0;
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
		if(newValue.every(function(v,k){ return v;})&&hearingDateLoadCounter>0)
		{
			if($scope.elementDataLoader.hearingDateValEnteredByUser==false)hearingDateAutomation();
			if($scope.elementDataLoader.hearingDateValEnteredByUser)hearingDateManual();
		}
		hearingDateLoadCounter++; 
	});
	prepareHearingDateRequest=function(){
		obj = {};
		obj.judge_id = $('#docket-judge').find('option:selected').attr('judge_id');
		obj.judge_assistant_id = $('#docket-judgeAssistant').find('option:selected').attr('judge_assistant_id');
		obj.court_location_id = $('#caseLocation').find('option:selected').attr('location_id');
		obj.casetype_id = $('#casetypeselect').find('option:selected').attr('castyp');
		obj.casetype = $('#casetypereadonly').text()||$('#casetypeselect').val();
		obj.hearingTimeId=$('[name="hearingTime"]').find('option:selected').attr('time-id');
		obj.hearingTime=$('[name="hearingTime"]').val();
		obj.agencyCode = $('#agencyCodereadonly').text();
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
						$scope.elementDataLoader.fieldDisabled=false;
					}
					else{
						$scope.elementDataLoader.val=0;	
						$scope.elementDataLoader.fieldDisabled=false;
						$scope.elementDataLoader.submitDisabled=false;	
						$scope.elementDataLoader.text=$scope.elementDataLoader.defaultText;
					}
				}

			}
		});
	};
	
	/* 
		Name  : Neha Agrawal
		Date Created : 28-02-2017
		Description : Function is used to check changed value of docket for pageleaving warning message.
	*/
	$scope.changed_flag = '0';
	$scope.change_docket_value = function()
	{
		$scope.changed_flag = '1';
		$rootScope.pageLeaveWarning.watchCount = 1;
	}
	
	/* 
  Name  : Neha Agrawal
  Date Created : 28-02-2017
  Description : Function is used to check changed value of dateRequested,dateReceivedbyOsah,hearingDate for pageleaving warning message.
 */
	$scope.$watchGroup(['dateRequested','dateReceivedbyOsah','hearingDate'], function(newValue, oldValue) {
		if((newValue[0]!= undefined && newValue[0]!='' && newValue[0]!=null) || (newValue[1]!= undefined && newValue[1]!='' && newValue[1]!=null) || (newValue[2]!= undefined && newValue[2]!='' && newValue[2]!=null))
		{
		   $scope.old_value_0 = $filter('date')(new Date(oldValue[0]), 'MM-dd-yyyy');
		   $scope.old_value_1 = $filter('date')(new Date(oldValue[1]), 'MM-dd-yyyy');
		   $scope.old_value_2 = $filter('date')(new Date(oldValue[2]), 'MM-dd-yyyy');
		   if(($scope.old_value_0 == newValue[0]) && ($scope.old_value_1 == newValue[1]) && ($scope.old_value_2 == newValue[2]))
		   {
			$rootScope.pageLeaveWarning.val = 0;
		   }else{
			$rootScope.pageLeaveWarning.val = 1;
		   }
		}
	});
	
	/* added by Neha Agrawal	@Description: page-leave-warning-popup @Created on 	: 2017-01-30*/
	PageLeaveWarning.watch($scope,[
		'changed_flag'
	]);
	
	/*end */
	
	/* 
		Name : Neha Agrawal
		Date Created : 11-05-2017
		Description : Function is used to add '-' in zipcode after every 5 characters.
	*/
	$scope.zipcodeFormat = function(zip_code)
	{
		var total = zip_code.length;
		if(total==5)
		{
			zip_code = zip_code += "-";
			$scope.zip_code = zip_code;
			$scope.edit_zipcode = zip_code;
		}
	}
	
}]);


/*@Added by FaisalK 02-11-2016 @purpose U341 sticky header*/
osahApp.directive('stickyHead', function ($compile, $window) {
  
  function compile(tElement) {
   tElement.find('td').each(
  function(k,v){
   angular.element(v).width(angular.element(v).width()+10);
  }
   );
    var table = {
      clone: tElement.parent().clone().empty(),
      original: tElement.parent()
    };
    
    var header = {
      clone: tElement.clone(),
      original: tElement
    };
    
    // prevent recursive compilation
    header.clone.removeAttr('sticky-head').removeAttr('ng-if');
    
    table.clone.css({display: 'block', overflow: 'hidden'}).addClass('clone');
    header.clone.css('display', 'block');
    header.original.css('visibility', 'hidden');
    
    return function postLink(scope) {
      var scrollContainer = table.original.parent();
      
      // insert the element so when it is compiled it will link
      // with the correct scope and controllers
      header.original.after(header.clone);
      
      $compile(table.clone)(scope);
      $compile(header.clone)(scope);
      
      scrollContainer.parent()[0].insertBefore(table.clone.append(header.clone)[0], scrollContainer[0]);
      
      scrollContainer.on('scroll', function () {
        // use CSS transforms to move the cloned header when the table is scrolled horizontally
        header.clone.css('transform', 'translate3d(' + -(scrollContainer.prop('scrollLeft')) + 'px, 0, 0)');
      });
      
      function cells() {
        return header.clone.find('th').length;
      }
      
      function getCells(node) {
        return Array.prototype.map.call(node.find('th'), function (cell) {
          return jQLite(cell);
        });
      }
      
      function height() {
        return header.original.prop('clientHeight');
      }
      
      function jQLite(node) {
        return angular.element(node);
      }
      
      function marginTop(height) {
        table.original.css('marginTop', '-' + height + 'px');
      }
      
      function updateCells() {
        var cells = {
          clone: getCells(header.clone),
          original: getCells(header.original)
        };
        
        cells.clone.forEach(function (clone, index) {
          if(clone.data('isClone')) {
            return;
          }
          
          // prevent duplicating watch listeners
          clone.data('isClone', true);
          
          var cell = cells.original[index];
          var style = $window.getComputedStyle(cell[0]);
          
          var getWidth = function () {
            return style.width;
          };
          
          var setWidth = function () {
            marginTop(height());
            clone.css({minWidth: style.width, maxWidth: style.width});
          };
          
          var listener = scope.$watch(getWidth, setWidth);
          
          $window.addEventListener('resize', setWidth);
          
          clone.on('$destroy', function () {
            listener();
            $window.removeEventListener('resize', setWidth);
          });
          
          cell.on('$destroy', function () {
            clone.remove();
          });
        });
      }
      
      scope.$watch(cells, updateCells);
      
      header.original.on('$destroy', function () {
        header.clone.remove();
      });
    };
  }
  
  return {
    compile: compile
  };

});

osahApp.directive('partyAutoComplete',['$filter',partyAutoCompleteDir]); 
 function partyAutoCompleteDir($filter) {
            
            return {
                restrict: 'A',       
                link: function (scope, element, attrs) {
                   var element_name= "";
                   element.autocomplete({
                        source: function (request, response) {

                        element_name = attrs.name;
                          
                            //term has the data typed by the user
                            var params = request.term.toLowerCase();
							console.log(params);
                            scope.selecteduserid="";
                            //simulates api call with odata $filter
                            var data = scope.dataSourceUserlist;
							console.log(data);
							// angular.forEach(data, function(list)
							// {
								// console.log(list.LastName);
								
							// });
							
							
							
                                     // console.log(filter);  
								
                            if (data) { 
                                // var result = $filter('filter')(data, {LastName:params});
								filter_data=data.filter(
									function(v){
										// console.log(v);
										var lName = v.Lastname.toLowerCase();
										// console.log(lName);
										return lName.startsWith(params);
									}
								);
								
                                angular.forEach(filter_data, function (item) {
									console.log(item);
                                    item['value'] = item['name'];
                                });                       
                            }
                              
                            response(filter_data); 
							// if (data) { 
                                // var result = $filter('filter')(data, {name:params});
                                // angular.forEach(result, function (item) {
                                    // item['value'] = item['name'];
                                // });                       
                            // }
                              
                            // response(result);

                        },
                        minLength: 1,                       
                        select: function (event, ui) {
                           //force a digest cycle to update the views
                           console.log("Herererer" + element_name);
                           if(element_name=="edit_last_name"){
                              scope.$apply(function(){
                                scope.setEditPartyData(ui.item);
                              });
                           }else{
                              scope.$apply(function(){
                                scope.setAddPartyData(ui.item);
								console.log(ui.item);
                              });
                           }
                             

                        },
                       
                    });
                }

            };
        }

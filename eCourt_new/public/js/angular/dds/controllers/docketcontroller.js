             //Search Result controller
  osahApp.controller('docketcontroller',['$scope','$rootScope','$state','$stateParams','DocketFactory','DynamicFactory','Form1205Factory','PartyFactory','Base64','SearchFactory','$filter','loader','$http','$window','DocumentTemplateFactory','SessionFectory','FileFactory','$timeout','PageLeaveWarning',function($scope,$rootScope,$state,$stateParams,DocketFactory,DynamicFactory,Form1205Factory,PartyFactory,Base64,SearchFactory,$filter,loader,$http,$window,DocumentTemplateFactory,SessionFectory,FileFactory,$timeout,PageLeaveWarning){
      
	  loader.show();
     $scope.flag_type = '';
     $scope.validation_message = '';
	 $scope.listPartyflag = ''; // party listing flag.
	 $scope.encoded_docket_number = $stateParams.reqdt;
	 $scope.empty_result_flag = ''; // if no records found.
	 $scope.listDocumentflag = ''; // Files listing flag
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
	 $scope.flagSetforAddParty = false;
     $scope.desc = '';
	 $scope.document_template_id=0;
	 $rootScope.pageLeaveWarning.val = 0;
	 $scope.elgpermit = "0";
    $scope.nonDecisionDocumentList=''; //NonDecision Docuemet list 
      //Check The loged user type
    $scope.loggeduser_type = Base64.decode(SessionFectory.get('dds_user_type'));
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
		$('#new_docket-effectivedate').datepicker({
				format: "mm-dd-yyyy",
				endDate: '-0d',
				autoclose: true
		});

	
	
	
	$('#expirydate').datepicker({
        format: "mm-dd-yyyy",
		startDate: '-0d',
		autoclose: true
	});
	$('#dob').datepicker({
        format: "mm-dd-yyyy",
		startDate: '-0d',
		autoclose: true
	});
	$('#dateEntered').datepicker({
        format: "mm-dd-yyyy",
		startDate: '-0d',
		autoclose: true
	});

	$('#incident_date').datepicker({
        format: "mm-dd-yyyy",
		startDate: '-0d',
		autoclose: true
	});

      // console.log( $scope.countyList_root);
      //Add Partty autocomplect use this function Start Here // Amol s
      var ctrl = this;
        ctrl.party ={"name":'', "id":''};
        $scope.setAddPartyData = function(item){
			console.log(item);
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
			return (string.charAt(0).toUpperCase() + string.slice(1)).replace( /([A-Z])/g, " $1" ).replace('_'," ").replace('code',' Code').replace('judge',' Judge').replace('date',' Date').replace('time',' Time').replace('assistant',' Assistant').replace('requested',' Requested').replace('mode',' Mode').replace('ref',' Ref').replace('number',' Number').replace('site',' Site').replace('yesno',' ').replace( 'name', " Name" );
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
			loader.show();
		  $scope.docket_number = Base64.decode($stateParams.reqdt);
				 $scope.party_data = '';
          $scope.result = '';
				 /* 
					Function is used to display docket information
				 */
            DocketFactory.searchbydocket("docketsearch","caseid = '"+$scope.docket_number+"'").success(function(response){
				console.log(response);
				loader.hide();
                 $scope.result = response['peopleData'];
                 $scope.ppldetail = response['peopleData'];
                $scope.dockets = response['docketData'];
				if(response['docketData']=='')
				{
					$state.go("home");
  					$scope.empty_result_flag = '1';
  					$rootScope.errorMessageshow=1;
  					$rootScope.errorMessage="No records found";
				}
				else if(response['docketData'][0].casetype != 'ALS'){
					$state.go("home");
  					$scope.empty_result_flag = '1';
  					$rootScope.errorMessageshow=1;
  					$rootScope.errorMessage="No records found";
				}else{
				$scope.license_number  = $scope.dockets[0].agencyrefnumber;					
                $scope.agencyCode =  $scope.dockets[0].refagency;
                $scope.casetype = $scope.dockets[0].casetype;
                $scope.casefiletype = $scope.dockets[0].casefiletype;
                $scope.casetypeselect= $scope.dockets[0].casetype;
                $scope.county = $scope.dockets[0].county;
				$scope.countyselect = $scope.dockets[0].county;
				console.log($scope.countyselectdropdown);
				$scope.dateEntered =response['docketData'][0].docket_createddate; // added by affan for dds				
				$scope.docketStatus = $scope.dockets[0].status;
				$scope.telv_o_five = $scope.dockets[0].telv_o_five;
				$scope.days91flag = $scope.dockets[0].flag_91days;
/*               $scope.countyselect = $scope.dockets[0].county;
                $scope.docketStatus = $scope.dockets[0].status;
                $scope.olddocketStatus= $scope.dockets[0].status;
				 */
				//$scope.caseLocation = $scope.dockets[0].hearingsite;
				}
				console.log($scope.county);
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
					$scope.hearingDate =  $scope.chkForCurrentDateTimeASPerUTC($scope.dockets[0].hearingdate);
				}
				$scope.previous_hearingDate =  $scope.dockets[0].hearingdate;

                $scope.agencyRefnumber = $scope.dockets[0].agencyrefnumber;
				console.log($scope.dockets[0].daterequested);
				//var requestedReceaveDate = $scope.chkForCurrentDateTimeASPerUTC(d);
				/* var d = new Date($scope.dockets[0].daterequested);
				var da = d.setTime( d.getTime() + d.getTimezoneOffset()*60*1000 ); */
				$scope.dateRequested = $scope.chkForCurrentDateTimeASPerUTC($scope.dockets[0].daterequested); //$filter('date')(da, 'MM-dd-yyyy');				
				console.log($scope.dateRequested);
				console.log("sadf");
                $scope.dateReceivedbyOsah = $scope.dockets[0].datereceivedbyOSAH;
				console.log($scope.dateReceivedbyOsah)
                $scope.hearingMode = $scope.dockets[0].hearingmode;
				$scope.dateEntered = $filter('date')(new Date($scope.dateEntered), 'MM-dd-yyyy'); //added by affan for dds
			    $scope.docketCreated= $scope.dockets[0].docketclerk;
                /*Show New Foramt of Docket #*/

                  var OlddocketNumber = $scope.dockets[0].docketnumber;
                  var SplitdocketNumber = OlddocketNumber.split('-');
                  var NewdocketNumber = SplitdocketNumber[2]+'-'+SplitdocketNumber[0]+'-'+SplitdocketNumber[1]+'-'+SplitdocketNumber[3]+'-'+SplitdocketNumber[4];
                  $scope.docket_no=NewdocketNumber;
				  console.log($scope.docket_no);

                /* 
				Used to display typeofcontact at the top of the docket. 
				*/
				$scope.petitioner_flg = '0';
				$scope.respondent_flg = '0';
				
				angular.forEach($scope.result, function(value, key){
					$scope.respondentName = '';
					console.log(value.typeofcontact);
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
					}else{
						
						// $scope.docketCreated= value.docketclerk;
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

				Form1205Factory.searchby1205form("form1205offence", "caseid = '" + $scope.docket_number + "'").success(function(response) {
					console.log(response);		
					var date_createdfor1205 = response[0].date_created;				
					//console.log($scope.dockets[0].license_class_id);					
					var receaveDate = $scope.chkForCurrentDateTimeASPerUTC(date_createdfor1205);						
					//console.log($scope.dateEntered);	
					//var days91 = $scope.check91daysprocess();
					//console.log(days91);
					if(response[0].telv_o_five == 1 ){	
						console.log($scope.dockets[0].judgeassistant)
						$scope.cretedDate1205 =  $scope.dockets[0].datereceivedbyOSAH; // added by affan for 1205 date created
					    $scope.dateReceivedbyOsah = $filter('date')($scope.cretedDate1205, 'MM-dd-yyyy'); //added by affan for dds	
						$scope.caseLocation = $scope.dockets[0].hearingsite;
						$scope.str = $scope.dockets[0].hearingtime;
						$scope.hearingTime = $scope.str.replace(/^\s\n+|\s\n+$/g,'');						
						$scope.judge = $scope.dockets[0].judge;
						console.log($scope.judge);
						$scope.judgeAssistant = $scope.dockets[0].judgeassistant;
						$scope.incident_date = $scope.chkForCurrentDateTimeASPerUTC(response[0].incident_date);						
						$scope.dob = $scope.chkForCurrentDateTimeASPerUTC(response[0].dob);						
						}else{
						console.log($scope.dockets[0].datereceivedbyOSAH);
						if($scope.dockets[0].datereceivedbyOSAH!= undefined)
						{
							$scope.cretedDate91days = $scope.dockets[0].datereceivedbyOSAH; // added by affan for 1205 date created
							$scope.dateReceivedbyOsah = $filter('date')($scope.cretedDate91days, 'MM-dd-yyyy'); //added by affan for dds
							$scope.str = $scope.dockets[0].hearingtime;
							$scope.hearingTime = $scope.str.replace(/^\s\n+|\s\n+$/g,'');	
							console.log($scope.hearingTime);
						}else{
							$scope.hearingTime = 'Select';
						}							
							$scope.caseLocation = $scope.dockets[0].hearingsite;
							$scope.judge = $scope.dockets[0].judge;
							$scope.judgeAssistant = $scope.dockets[0].judgeassistant;
							 $scope.incident_date = $scope.chkForCurrentDateTimeASPerUTC(response[0].incident_date);
							 $scope.dob = $scope.chkForCurrentDateTimeASPerUTC(response[0].dob);	
							if($scope.incident_date == '01-01-1970' || $scope.dob ==  '01-01-1970' )	
							{
								$scope.incident_date = '';
								 $scope.dob =''
							}else{
								$scope.incident_date = $scope.chkForCurrentDateTimeASPerUTC(response[0].incident_date);
								$scope.dob = $scope.chkForCurrentDateTimeASPerUTC(response[0].dob);					
							}
							//console.log($scope.incident_date);
						}
				});
				
				/* Form1205Factory.searchby1205form("days91", "caseid = '" + $scope.docket_number + "'").success(function(response) {
					console.log(response);					
					var date_createdfor91days= response[0].date_created;
					var receaveDate = $scope.chkForCurrentDateTimeASPerUTC(date_createdfor91days);						
					//var days91 = $scope.check91daysprocess();
					if(response[0].flag_91days == 1 ){	
						$scope.cretedDate91days = response[0].date_created; // added by affan for 1205 date created
					    $scope.dateReceivedbyOsah = $filter('date')(date_createdfor91days, 'MM-dd-yyyy'); //added by affan for dds	
						$scope.caseLocation = $scope.dockets[0].hearingsite;
						$scope.str = $scope.dockets[0].hearingtime;
						$scope.hearingTime = $scope.str.replace(/^\s\n+|\s\n+$/g,'');						
						$scope.judge = $scope.dockets[0].judge;
						$scope.judgeAssistant = $scope.dockets[0].judgeassistant;
						}
				}); */
				
				// done by affan for dds
				DynamicFactory.getdynamicdata("permit_eligibility_effectivedate","caseid",$scope.docket_number,"1").success(function(response){
					console.log(response);
					//$scope.permiteligibilityeffective= [0:'No',1:'Yes'];
					
					$scope.elgpermit = response[0].eligibility;
					if($scope.elgpermit == 1){
						console.log()
						$scope.effectivedate =  $scope.chkForCurrentDateTimeASPerUTC(response[0].effective_date); 
						$scope.expirydate =  	 $scope.chkForCurrentDateTimeASPerUTC(response[0].expiry_date);						
					}
					else{
						$scope.effectivedate = '';
						$scope.expirydate = '';
						
					}
		
				});
				
				
				
			});
			loader.hide();
			//Get Current Time from utc.			
				$scope.chkForCurrentDateTimeASPerUTC = function(dateUTC){	
								var d = new Date(dateUTC);	
						var da = d.setTime( d.getTime() + d.getTimezoneOffset()*60*1000 );	
						var date = $filter('date')(da, 'MM-dd-yyyy');
						console.log(date);
						return date;
				};
			
		};
			 $scope.getDocketinformation();
			
			
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
		
		DynamicFactory.getdynamicdata("states","idstates","0","2").success(function(response){
			$scope.stateList=response;
		});
		$scope.statename = 'GA';
		
    // $scope.stateList = [{id:2, name : 'AK'},{id :1, name : 'AL'},{id :4, name : 'AR'},{id :3, name : 'AZ'},{id :5, name : 'CA'},{id :6, name : 'CO'},{id :7, name : 'CT'},{id :8, name : 'DE'},{id :9, name : 'FL'},{id :10, name : 'GA'},{id :11, name : 'HI'},{id :15, name : 'IA'},{id :12, name : 'ID'},{id :13, name : 'IL'},{id :14, name : 'IN'},{id :16, name : 'KS'},{id :17, name : 'KY'},{id :18, name : 'LA'},{id :21, name : 'MA'},{id :20, name : 'MD'},{id :19, name : 'ME'},{id :22, name : 'MI'},{id :23, name : 'MN'},{id :25, name : 'MO'},{id :24, name : 'MS'},{id :26, name : 'MT'},{id :33, name : 'NC'},{id :34, name : 'ND'},{id :27, name : 'NE'},{id :29, name : 'NH'},{id :30, name : 'NJ'},{id :31, name : 'NM'},{id :28, name : 'NV'},{id :32, name : 'NY'},{id :35, name : 'OH'},{id :36, name : 'OK'},{id :37, name : 'OR'},{id :38, name : 'PA'},{id :51, name : 'PR'},{id :39, name : 'RI'},{id :40, name : 'SC'},{id :41, name : 'SD'},{id :42, name : 'TN'},{id :43, name : 'TX'},{id :44, name : 'UT'},{id :46, name : 'VA'},{id :52, name : 'VI'},{id :45, name : 'VT'},{id :47, name : 'WA'},{id :49, name : 'WI'},{id :48, name : 'WV'},{id :50, name : 'WY'}];

   //AFFAN s Get the autopopulate party details 
      //AFFAN s Get the autopopulate party details 
     $scope.dataAutopopulate = function(){
		$scope.typeOfcontact = '';
		if($scope.contactType=="Officer" || $scope.contactType=="Petitioner Attorney")
		{
			$scope.typeOfcontact = $scope.contactType;
		}
		if($scope.edit_contact_type=="Officer" || $scope.edit_contact_type=="Petitioner Attorney")
		{
			$scope.typeOfcontact = $scope.edit_contact_type;
		}
		if($scope.update_contact_type=="Officer" || $scope.update_contact_type=="Petitioner Attorney")
		{
			$scope.typeOfcontact = $scope.update_contact_type;
		}
		console.log($scope.typeOfcontact);
		console.log("rat");
		DocketFactory.autopopulatedds($scope.typeOfcontact).success(function(response){
		  // console.log(response);
		  //$scope.companydatalist = response;
		 
          $scope.dataSourceUserlist=response;
		 // console.log($scope.companydatalist);
		   
			//$scope.company_name = 'Select Company';  

			//$scope.address1 = 'Select Address';  

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
				console.log($scope.contact_type);
				if($scope.contact_type == 'Officer' ){
					$scope.newpartyyesno = false;
					$scope.flag_type = 4;
				}else if($scope.contact_type == 'Petitioner Attorney' ){
					$scope.flag_type = 5;
					$scope.newpartyyesno = false;
				}else if($scope.contact_type == 'Petitioner' ){
					$scope.newpartyyesno = true;
					$scope.flag_type = 6;
				}else{
					$scope.flag_type = 3;
					$scope.newpartyyesno = false;
				}
				
			

};

			/* 
				Author Name : Neha
				Description : Function is used to add party information.
			*/
			$scope.addParty = function(){
				$rootScope.errorMessageshow=0;
				$rootScope.errorMessage = '';
				if($scope.contactType=='Officer'){
					if($scope.address1 != undefined){
						$scope.title = $scope.checkForDpsCompany($scope.address1);
						console.log($scope.title);
					}
				}
				console.log($scope.contactType);
				console.log($scope.last_name);
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
						  
						  var partyData = {docket_number:$scope.docket_number,contactType:$scope.contactType,last_name:$scope.last_name,first_name:$scope.first_name,middle_name:$scope.middle_name,dobyear:$scope.dobyear}
						  PartyFactory.addParty(partyData).success(function(response){
							  console.log(response);
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
					
					console.log($scope.last_name);
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
						if($scope.email=='' || $scope.email==undefined)
						{
							$scope.email = 'No Email';
						}else{
							$scope.email;
						}
						if($scope.license_number!=$scope.dockets[0].agencyrefnumber){
							$scope.updatelicensenumber($scope.license_number);
					    }
						
						var partyData = {docket_number:$scope.docket_number,contactType:$scope.contactType,last_name:$scope.last_name,first_name:$scope.first_name,middle_name:$scope.middle_name,attorney:$scope.attorney_no,title:$scope.title,company_name:$scope.company_name,address1:$scope.address1,address2:$scope.address2,city:$scope.city,state:$scope.statename,zip_code:$scope.zip_code,phone:$scope.phone,email:$scope.email,fax:$scope.fax}
						PartyFactory.addParty(partyData).success(function(response){
							console.log(response);
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
			
			
			// function change the agency from dds to dps on basis of city.
	
	$scope.checkForDpsCompany = function(address1) {
		console.log(address1);
		$scope.company_name = address1.toUpperCase();
		console.log($scope.docket_number);
		if($scope.address1 == 'GEORGIA STATE PATROL' || $scope.address1 == 'GEORGIA DEPARTMENT OF PUBLIC SAFETY'){
			 var countyid =   $('#countyselect').find('option:selected').attr('conty');
			 var county = $scope.county 
			 $scope.frontendofficer = 'frontendofficer';
			 console.log(countyid);
			 var docketDPSDetails={caseid:$scope.docket_number,agencey:'DPS',casetype:'ALS',county:county,countyid:countyid,Address1:address1,frontendofficer: $scope.frontendofficer};
			console.log(docketDPSDetails);
			Form1205Factory.updateddstodps("docket",docketDPSDetails ,"caseid = '" + $scope.docket_number + "'").success(function(response){
			console.log(response);
				if(response){
					//This code is use to get attorney data for Name "DEE Brophy".
					Form1205Factory.getattorney("attorney").success(function(response){
						console.log(response);
						$scope.attroneyDetails = response;	
							Form1205Factory.addAttorneyDetailsForDps('attorneybycase',$scope.attroneyDetails,"caseid = '" + $scope.docket_number + "'",$scope.docket_number).success(function(response){
							console.log(response);				
							}); 	
					}); 
			
				}	
			}); 
			$scope.title= 'Trooper';
			return $scope.title;
		}else{
			return $scope.title;
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
	/* 
	Name : Neha Agrawal
	Description : Function is used to update the docket information
	Created Date : 06-04-2017
	*/
	$scope.updateDdsdocket = function()
	{
		$rootScope.errorMessageshow=0;
		flag = true;
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
					if(flag){
					loader.show();
					
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
								var docketDetails = {agencyrefnumber:$scope.agencyRefnumber,eligiblepermit:$scope.elgpermit,permiteffectivedate:$scope.effectivedate,expiryDate:$scope.expirydate,DOB:$scope.dob,incidentDate:$scope.incident_date}
								DocketFactory.updateDdsdocket(docketDetails , $scope.docket_number).success(function(response){
									loader.hide();
									if(response=='1')
									{
										 $rootScope.errorMessageshow=1;
										 $rootScope.errorMessage="Data updated successfully";
										
										 $scope.getDocketinformation();
										 PageLeaveWarning.reset();
										 $scope.changed_flag = '0';
									}
								});
				
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
					 //$scope.HistoryMessage = '<p class="history-title">Party has been Deleted:</p><p><span class="history-label">Name:</span><span class="history-data">'+ firstname
								// +'</span></p><p><span class="history-label">LastName:</span><spanclass="history-data">'+ lastname +'</p></span></p>';							
								//	$scope.updateHistory($scope.docket_number,$scope.HistoryMessage);
								//	$scope.versement_each = "";
	
					$('#deleteParty'+index).modal('toggle');
					$('.modal-backdrop.in').hide();
					
					
				}else{
					$rootScope.errorMessageshow=1;
					$rootScope.errorMessage="Some thnig went wrong tray again later";
				}
			});

		};	
		

			/* 
			  Name : Amol S
			  Description : Function is used to get selected user information like  Attorney, Agency or Case worker .
			  Created on : 11-11-2016
			*/
		  $scope.getuserInformation = function(flage_party){
          if(flage_party=='edit'){
             //Edit Party when select the user will get the user all in formation from table Amol s.
             if($scope.edit_selecteduserid!=undefined && $scope.edit_selecteduserid!=null && $scope.edit_selecteduserid!=''){
                    DocketFactory.getuserdetailsdds($scope.edit_selecteduserid).success(function(response){
                      $scope.edit_last_name="";
					  $('#edit_last_name').val('');
                      $scope.edit_first_name=response[0].Firstname;
                      $scope.edit_middle_name=response[0].Middlename;
                      $scope.edit_company_name= response[0].Company.replace(/\\n/g, '');
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
          					DocketFactory.getuserdetailsdds($scope.selecteduserid).success(function(response){
								console.log(response);
						
								$('#last_name').val('');
								$scope.first_name=response[0].Firstname;
          						$scope.middle_name=response[0].Middlename;
          						$scope.company_name=response[0].Company.replace(/(\r\n|\n|\r)/gm," ");
          						$scope.address1=response[0].Address1;
          						$scope.address2=response[0].Address2;
          						$scope.city=response[0].City;
          						$scope.state=response[0].State;
          						$scope.zip_code=response[0].Zip;
          						$scope.email=response[0].Email;
          						$scope.fax=response[0].Fax;
          						$scope.phone=response[0].Phone;
          						$scope.title=response[0].Title;
          						$scope.officerrid = response[0].officerrid;
          						$scope.last_name = $.trim(response[0].Lastname);
								$('#last_name').val($scope.last_name);	
								console.log($scope.company_name);

          					});
				     }

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

         }
       }
	   
	   

        /* 
          Name : Amol S
          Description : Function is casetype_agencywise is used to when select the agency the it will get respective case types
          Created on : 21-11-2016
      */
	  
      $scope.casetypeCountyChange = function(){
            
         var casetypeid =  612;
         $scope.casetypeselect= $('#casetypeselect').find('option:selected').val();
         var countyid =   $('#countyselect').find('option:selected').attr('conty');
         $scope.countyselect =   $('#countyselect').find('option:selected').val();
		 console.log(casetypeid);
		 console.log($scope.countyselect);
		 console.log(countyid);
		 
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
			$scope.UpdatetypeOfcontact(contactType);
			PartyFactory.getParty($scope.docket_number,contactId,minorId,contactType,peopleId,attorneyId).success(function(response){
				console.log(response);
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
				$scope.title = response[0].Title;
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
					$scope.edit_contact_type = 'Minor/children';
					$scope.previous_contacttype = 'Minor/children';
				}else if($scope.edit_contact_type == 'Petitioner' ){
					$scope.edit_contact_type = response[0].typeofcontact;
					$scope.previous_contacttype = response[0].typeofcontact;
				}else{
					$scope.edit_contact_type = response[0].typeofcontact;
					$scope.previous_contacttype = response[0].typeofcontact;
				}
				if($scope.edit_contact_type=='Petitioner Attorney' || $scope.edit_contact_type=='Officer' || $scope.previous_contacttype=='Agency Attorney' || $scope.previous_contacttype=='Case Worker')
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
		console.log($scope.edit_last_name);
		console.log($scope.edit_first_name);
		$rootScope.errorMessageshow='0';
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
						if($scope.license_number!=$scope.dockets[0].agencyrefnumber){
							$scope.updatelicensenumber($scope.license_number);
					    }
							
						//	$scope.updated_dob = $filter('date')(new Date($scope.edit_dob), 'yyyy-MM-dd');

						  var EditpartyData = {minorid:minorId,peopleid :peopleId,attorney_id:attorneyId,contactid :contactId,Lastname:$scope.edit_last_name,Firstname:$scope.edit_first_name,Middlename:$scope.edit_middle_name,dobyear:$scope.edit_dobyear,caseid:$scope.docket_number,previous_contacttype:$scope.previous_contacttype,Docket_caseid:$scope.docket_number,created_date:$scope.created_date}
						  editresponsevalue = EditpartyData.previous_contacttype;
						  console.log(getEditResponse);
							PartyFactory.editParty(EditpartyData).success(function(response){
								$.each(EditpartyData, function(key, value) {
									if(key == 'previous_contacttype' || key == 'attorney_id' || key == 'minorid'){
										return true;
									 }
									else if(value !="" || value != undefined || key != undefined ){
										 if(getEditResponse[0][key] != value){
												$scope.versement_each += '<p><span class="history-label">'+ capitailizeletter(key) +':</span><span class="history-data">'+value+'</span></p>';
										 }
									 }
								});


							if(response=="true"){
								$rootScope.errorMessageshow=1;
								$rootScope.errorMessage="Party updated successfully!";
								//$scope.HistoryMessage = '<p class="history-title">'+ editresponsevalue +' information has been updated/modified for:</p><p><span class="history-label">Name:</span><span class="history-data">'+ EditpartyData.Firstname +'</span></p><p><span class="history-label">Last Name:</span><span class="history-data">'+ EditpartyData.Lastname+'</span></p></p><p>Modified Fields are listed below:</p><p><span class="history-label">Typeofcontact:</span><span class="history-data">"Minor/CHildren"</span></p>'+ $scope.versement_each;
								 /* if($scope.versement_each != ""){
									$scope.updateHistory($scope.docket_number,$scope.HistoryMessage);
									$scope.versement_each = "";
								 } */
								$('#editpartymodal').modal('toggle');
								$scope.getDocketinformation();
								$scope.partydetails();
							}else{
								$rootScope.errorMessageshow=1;
								$rootScope.errorMessage="Some thnig went wrong tray again later";
							}
						  

						});
					}
				}
				else{
					
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
						//Update Officer from DDS to DPS if address1 mathches 2 provided county
						if($scope.contactType=='Officer'){
							if($scope.edit_address1 != undefined){
								$scope.title = $scope.checkForDpsCompany($scope.edit_address1);
								console.log($scope.title);
							}
						}
						//console.log($scope.dockets[0].agencyrefnumber)
						if($scope.license_number!=$scope.dockets[0].agencyrefnumber){
							$scope.updatelicensenumber($scope.license_number);
					    } 
						
						$scope.updated_dob = $filter('date')(new Date($scope.edit_dob), 'yyyy-MM-dd');
						console.log($scope.edit_last_name);
						var EditpartyData = {minorid:minorId,peopleid :peopleId,attorney_id:attorneyId,contactid :contactId,caseid:$scope.docket_number,typeofcontact:$scope.edit_contact_type,Lastname:$scope.edit_last_name,Firstname:$scope.edit_first_name,Middlename:$scope.edit_middle_name,AttorneyBar:$scope.edit_attorney_no,Title:$scope.edit_title,Company:$scope.edit_company_name,Address1:$scope.edit_address1,Address2:$scope.edit_address2,City:$scope.edit_city,State:$scope.edit_state,Zip:$scope.edit_zipcode,Phone:$scope.edit_phone,Email:$scope.edit_email,fax:$scope.edit_fax,caseid:$scope.docket_number,previous_contacttype:$scope.previous_contacttype,Docket_caseid:$scope.docket_number,created_date:$scope.created_date}
						console.log(getEditResponse);
						console.log($scope.edit_last_name);
						console.log(EditpartyData);
						PartyFactory.editParty(EditpartyData).success(function(response){
							console.log(response);
								/*  $.each(EditpartyData, function(key, value) {
									 if(key == 'previous_contacttype' || key == 'attorney_id' || key == 'minorid' || key== 'peopleid' || key== 'Contactid'){
										return true;
									 }
									// console.log("Key="+key+ "value="+ value)
									if (value !="" || value != undefined || key != undefined ){
										//console.log(getEditResponse[0][key]);
										//key = key.replace( 'name', " Name" );
										console.log(getEditResponse[0][key] +"!="+ value); 
										if(getEditResponse[0][key] != value ){
											console.log(getEditResponse[0][key] +"!="+ value); 
												$scope.versement_each += '<p><span class="history-label">'+ capitailizeletter(key) +':</span><span class="history-data">'+value+'</span></p>';
										 }
									 }
								});  */
							if(response=="true"){
								loader.hide();
								//console.log($scope.versement_each);
								$rootScope.errorMessageshow=1;
								$rootScope.errorMessage="Party updated successfully!";
								// $scope.HistoryMessage = '<p class="history-title">'+  EditpartyData.previous_contacttype +' information has been updated/modified for:</p><p><span class="history-label">Name:</span><span class="history-data">'+ EditpartyData.Firstname
								// +'</span></p><p><span class="history-label">Last Name:</span><spanclass="history-data">'+ EditpartyData.Lastname+'</p></span></p><p>Modified Fields are listed below:</p>'+ $scope.versement_each;
								//console.log($scope.versement_each);
								 /* if($scope.versement_each != ""){
									$scope.updateHistory($scope.docket_number,$scope.HistoryMessage);
									$scope.versement_each = "";
									$scope.HistoryMessage = "";
								 } */
								$('#editpartymodal').modal('toggle');
								$scope.getDocketinformation();
								$scope.partydetails();
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
		$scope.dataAutopopulate();
		
			console.log($scope.update_contact_type);
				if($scope.update_contact_type == 'Officer' ){
					$scope.flag_type = 4;
				}else if($scope.update_contact_type == 'Petitioner Attorney' ){
					$scope.flag_type = 5;
				}else if($scope.update_contact_type == 'Petitioner' ){
					$scope.flag_type = 6;
				}else{
					$scope.flag_type = 3;
				}
				console.log($scope.flag_type)

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
      if(flage==1){  $scope.docketStatus="Stayed"; $scope.checkHearingdate="1";$scope.cmachange_lage=1;}else{$scope.docketStatus=$scope.olddocketStatus;$scope.cmachange_lage=0;$scope.checkHearingdate="0";
	}
  }


	

$('#dob').datepicker({
        format: "mm-dd-yyyy"
});
$('#dispositiondate').datepicker({
        format: "mm-dd-yyyy"
});
$('#judgedate').datepicker({
        format: "mm-dd-yyyy"
});
$('#maileddate').datepicker({
        format: "mm-dd-yyyy"
});
$('#edit_dob').datepicker({
        format: "mm-dd-yyyy"
});	
$('#file_date').datepicker({
        format: "mm-dd-yyyy"
});	
$('#edit_file_date').datepicker({
        format: "mm-dd-yyyy"
});	
$('#hearingDate').datepicker({
        format: "mm-dd-yyyy"
});	

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
 	
    DocumentTemplateFactory.documet_templet_Attch($scope.docket_number,$scope.agencyCode,$scope.casetype,$scope.mailerlist,$scope.documents_types,$scope.templatedocumentType,flage,$scope.templatedescription,$scope.document_template_id).success(function(response){
      //if(flage==1)
		
		$('#document-templates').modal('toggle');
		loader.show();
        $window.open(response);
        // $scope.documentListing(); //Document List function tolisting the document
       
       loader.hide();
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
						$scope.updated_fileDate = $filter('date')(new Date($scope.fileDate), 'yyyy-MM-dd');

						var fileData = {DocumentType:$scope.fileType,date_filed : $scope.updated_fileDate,Description:$scope.desc,DocumentName:$scope.file_name,Docket_caseid:$scope.docket_number,Caseid:$scope.docket_number};
						FileFactory.addFile(fileData).success(function(response){
							if(response.result=="true"){
								$scope.updated_fileDate = $filter('date')(new Date($scope.fileDate), 'MM-dd-yyyy');
								console.log(fileData.Description);

								$rootScope.errorMessageshow=1;
								// $scope.empty_result_flag_document = '0';
								$scope.listDocumentflag = '1';
								$rootScope.errorMessage="Document added successfully!";
								var desc = (fileData.Description)?'<p><span  class="history-label">Description :</span><span class="history-data">'+ fileData.Description +'</p>':'';
								 $scope.HistoryMessage = '<p class="history-title">Supporting document has been added as below.</p><p><span class="history-label">Docket Name:</span><span class="history-data">'+ $scope.docket_number
								 +'</span></p><p><span class="history-label">Document Type:</span><span class="history-data">'+ $scope.fileType +'</p></span></p>'+desc+'<p><span class="history-label">Date Filed :</span><span class="history-data">'+ $scope.updated_fileDate+'</p><p><span class="history-label">File Attachment Name :</span><span class="history-data">'+ $scope.file_name +'</p>';

								$scope.updateHistory($scope.docket_number,$scope.HistoryMessage);
								$('#add-files').modal('toggle');
								//$scope.documentListing();
								$scope.getDisposition();
								$('#file_form').trigger("reset");
								$scope.fileType = '';
								 $scope.fileDate = '';
								 $scope.file_name = '';
								 $('div.dz-preview.dz-processing.dz-image-preview.dz-success.dz-complete').hide();
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
				$('#removeimg').addClass( "dz-max-files-reached" );
				$('#editrmvimg').addClass( "dz-max-files-reached" );
				
			}
			
        },
		
		 'removedfile' : function(file){
            $scope.file_name = '';
            $scope.newFile = file;
			if($scope.file_name=='')
			{
				$('#removeimg').removeClass( "dz-max-files-reached" );
				$('#editrmvimg').removeClass( "dz-max-files-reached" );
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
      
	    if(doc_flg=='1'){
				$scope.editAttachedfile='';
				$('#update-files').modal();
				$scope.documentId = documentId;
				FileFactory.getFile($scope.docket_number,documentId).success(function(response){
					$scope.Fileresult = response.result[0];
					$scope.editDocumenttype = $scope.Fileresult.DocumentType;
					$scope.editeFiledate = $filter('date')(new Date($scope.Fileresult.DateRequested), 'MM-dd-yyyy');
					$scope.editDescription = $scope.Fileresult.Description;
					$scope.file_name = $scope.Fileresult.DocumentName;
					// $scope.newFile = $scope.Fileresult.DocumentName;
					$scope.editAttachedfile = response.file_link;
					$scope.myDz.files = [];
					$('div.dz-preview.dz-complete.dz-image-preview').hide();
					if($scope.editAttachedfile!=undefined)
					{
						var demoThumbUrl = $scope.editAttachedfile;
						$scope.mockFiles = [
							{name:$scope.file_name, size : 5000, isMock : true, serverImgUrl : demoThumbUrl},
						];
						$timeout(function(){
							$scope.mockFiles.forEach(function(mockFile){
								$scope.myDz.emit('addedfile', mockFile);
								$scope.myDz.emit('complete', mockFile);
								$scope.myDz.files.push(mockFile);
							});
						});
					}
					
				});
		}else{
			 /* Document Template edit model open code here*/
			 	$scope.loadDocumentTemplate();	
			 	 
			 	FileFactory.getFile($scope.docket_number,documentId).success(function(response){
			 		//$scope.docinfo = response.result[0];

			 		//$scope.agencyCode =  $scope.dockets[0].refagency;
                	$scope.docinfo = response['result'];
			 		// console.log("sgfhsgfshfsf" + $scope.docinfo[0].casetype_doc_id);
			 	
			 	$scope.templatedocumentType=$scope.docinfo[0].casetype_doc_id;
			 	$scope.templatedescription=$scope.docinfo[0].Description;
				$scope.document_template_id=$scope.docinfo[0].documentid;
			 		if($scope.docinfo[0].DocumentType!='Decision'){
			 			//document Type is non decision
			 			$scope.document_types_list= $scope.nonDecisionDocumentList;
			 			$("#doctype1").prop('checked',true);
			 			$("#doctype2").prop('checked',false);
			 		}else{
			 			//document Type is decision
			 			$scope.document_types_list= $scope.decisionDocumentList;
			 			 $("#doctype2").prop('checked',true);
			 			 $("#doctype1").prop('checked',false);
			 		}

					$('#document-templates').modal('toggle');


				});
			}
	}
	
	$scope.editFile = function(updatedoc_id)
	{
		if($scope.editDocumenttype=='' || $scope.editDocumenttype==undefined || $scope.editeFiledate=='' || $scope.editeFiledate==undefined || $scope.file_name=='' || $scope.file_name==undefined)
			{
				$('.edit_file_data').each(function(){
					var cur = $(this);
					// id = $(this).attr("id");
					if ($.trim(cur.val()) == '' ||  $.trim(cur.val()) == 0 ){
						$rootScope.errorMessageshow=1;
						$rootScope.errorMessage=$(this).attr("msg");
						return false;
					}
				});
			}else{
				$scope.updated_fileDate = $filter('date')(new Date($scope.editeFiledate), 'yyyy-MM-dd');
						var updatedfileInfo = {DocumentType:$scope.editDocumenttype,DateRequested : $scope.editeFiledate,Description:$scope.editDescription,DocumentName:$scope.file_name,Docket_caseid:$scope.docket_number,Caseid:$scope.docket_number};
						var data = {updatedoc_id:updatedoc_id,attached_path:$scope.editAttachedfile};
						FileFactory.updateFile(updatedfileInfo,data).success(function(response){
							if(response.result=="true"){
								console.log(response.file_link);
								$rootScope.errorMessageshow=1;
								// $scope.empty_result_flag_document = '0';
								$scope.listDocumentflag = '1';
								$rootScope.errorMessage="Document updated successfully!";
								$('#update-files').modal('toggle');
								//$scope.documentListing();
								 var openFilenewTab = window.open(response.file_link, '_blank');
								    openFilenewTab.focus();
							}else{
								$rootScope.errorMessageshow=1;
								$rootScope.errorMessage="Some thnig went wrong tray again later";
							}
						});
			}
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
						$scope.desc;
						$scope.hearingDate = '';
						$scope.hearingTime = '';
						$scope.docketStatus = 'Rescheduled';
						$scope.readonly_flag = "0";
						$scope.partydetails();
						$('#reopen-case').modal('toggle');
						$rootScope.errorMessageshow=1;
						$rootScope.errorMessage="Please fill in the hearing information to reopen the case.";
						$scope.reopenCaseflg = "1";
						$('#reopen_form').trigger("reset");
						$scope.decision_type = '0';
						$scope.partydetails();
						
						 
						/* var caseData = {others:$scope.others,caseid:$scope.docket_number,hearingdate:"",hearingtime:"",status:"Rescheduled"};
						console.log("true");
						DocketFactory.reopenCase(caseData).success(function(response){
							if(response=="true"){
								$rootScope.errorMessageshow=1;
								$rootScope.errorMessage="Case Reopen successfully!";
								$('#reopen-case').modal('toggle');
								$scope.getDocketinformation();
								$scope.show_disposition_button='1';
							}else{
								alert("Some error occured!");
							}
						  
						}); */
						$scope.getstatues = $scope.result[0].status;
					}
	  }
  
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
	};   */
	
	
	//AFFAN//
	//update license_number function//
	$scope.updatelicensenumber =function(updatelicensenumber){
		if($scope.contactType == 'Petitioner' || $scope.edit_contact_type=='Petitioner'){
				var officerlicennumber = {docket_number:$scope.docket_number,agencyrefnumber:updatelicensenumber}
				PartyFactory.updatelicensenumber(officerlicennumber).success(function(response){
					if(response){
						return true;
					}

			});	
					
		}
	}
	$scope.clearReset =function(clearResetvalue,company_name,address1){
		if(clearResetvalue == true && company_name=='Select Company' ){
			$scope.company_name = '';	
		}
		if(clearResetvalue == true &&   address1=='Select Address'){
			$scope.address1 = '';	
		}
		
	}
	
	/* 
		Name : Neha Agrawal
		Created Date : 17-04-2017
		Description : Function is used to delete the docket fom the database.
	*/
	
		$scope.deleteDocket = function()
		{
			DocketFactory.deleteDocket($scope.docket_number).success(function(response){
				$scope.result = response;
				if($scope.result == 'true')
				{
					$rootScope.errorMessageshow=1;
					$rootScope.errorMessage="Docket deleted successfully!";
					$('#deleteDocket').modal('toggle');
					$timeout(function() {
						$state.go('home');
					}, 1000);
					$('.modal-backdrop.in').hide();
					
				}else{
					$rootScope.errorMessageshow=1;
					$rootScope.errorMessage="Some thnig went wrong tray again later";
				}
			});
		}
	
	
	/*	Name  : Neha Agrawal
		Date Created : 06-04-2017
		Description : Function is used to check changed value of docket for pageleaving warning message.
	*/
		$scope.changed_flag = '0';
		$scope.change_value = function()
		{
			console.log($scope.changed_flag);
			$scope.changed_flag = '1';
			$rootScope.pageLeaveWarning.watchCount = 1;
		}
	/*	Name  : Neha Agrawal
		Date Created : 06-04-2017
		Description : page-leave-warning-popup
	*/
	PageLeaveWarning.watch($scope,[
		'changed_flag'
	]);
	
	 // when clerk change permit effective date, this function change expiration date automatically for 30 days after - affan shaikh
	  $scope.getPermitExpiryDate = function(effectivedate){
		  effe = $scope.effectivedate.replace("-", "/");
		  effe = effe.replace("-", "/");
		var effectiveDate = 	$filter('date')(new Date(effe), 'yyyy-MM-dd');
		var cur = new Date(effectiveDate);
		var after30days = cur.setDate(cur.getDate() + 30);
		$scope.expirydate = 	$scope.chkForCurrentDateTimeASPerUTC(after30days);
		if(eff == ''){
			$scope.expirydate = '';
		}
	  };
}]);


/*@Added by affan shaikh 08-03-2017 @purpose U341 sticky header*/
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
							console.log(scope.newpartyyesno);
							console.log(scope.flag_type);
							if(scope.flag_type == '6'){
								return false;
							}
						if(scope.newpartyyesno == false && ( scope.flag_type == '5' || scope.flag_type == '4' )){
							element_name = attrs.name;
                          
                            //term has the data typed by the user
                            var params = request.term.toLowerCase();
                            scope.selecteduserid="";
                            //simulates api call with odata $filter
                            var data = scope.dataSourceUserlist;
							// angular.forEach(data, function(list)
							// {
								// console.log(list.LastName);
								
							// });
							
							
							
                                     // console.log(filter);  
							console.log(data);
							
                            if (data) { 							
                                //var result = $filter('filter')(data, {LastName:params});
								filter_data=data.filter(
									function(v){
										//console.log(v);
										var lName = v.LastName.toLowerCase();
										return lName.startsWith(params);
									}
								);
								
                                angular.forEach(filter_data, function (item) {
                                    item['value'] = item['name'];
                                });                       
                            }
                              
                            response(filter_data);
						}
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


osahApp.controller('form1205Controller',['$scope','$rootScope','$state','$stateParams','DocketFactory','DynamicFactory','PartyFactory','Form1205Factory','Base64','SearchFactory','$filter','loader','$http','$window','SessionFectory','PageLeaveWarning',function($scope,$rootScope,$state,$stateParams,DocketFactory,DynamicFactory,PartyFactory,Form1205Factory,Base64,SearchFactory,$filter,loader,$http,$window,SessionFectory,PageLeaveWarning){
 loader.show();
	  $scope.stateList           = ""//Get status list
      $scope.hearingtimeList     =  $rootScope.hearingtimeList_root; //Get status list
	  //$scope.hearingTypedetails =   $rootScope.hearingTypedetails  //Get Hearing Type List
	  //$scope.skip_hearingDate = '0';
	  	// to check empty value affan.						
	  $scope.hearingType = "In Person";
	  $scope.elgpermit = "0";
	  $scope.agencyCode = "DDS";
	  $scope.casetypeselect = "ALS";
	  $scope.docketClerk = Base64.decode(SessionFectory.get('dds_user')); // get loggedin username
	  $scope.contacttype = 'Officer';
	  $scope.contactType = 'Officer';	  
	  $scope.dataSourceUserlist='';
      console.log($rootScope.officerCompony_root);
	  $rootScope.pageLeaveWarning.val = 0;
	  
		  

	 
  
  
		// dob datepicker 
		$('#form1205dob').datepicker({
			format: "mm-dd-yyyy",
			endDate: '+0d',
			autoclose: true
		});
		// Incident  datepicker 
		$('#incident_date').datepicker({
			format: "mm-dd-yyyy",
			autoclose: true
			});
		
		// factory for get statelist.
		 Form1205Factory.getstatelist("states").success(function(response){
			 console.log("STATES");
			   $scope.stateList=response;
		  }); 
		  
	
	$scope.encoded_docket_number = $stateParams.reqdt;
	console.log($scope.encoded_docket_number);
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

			console.log(response);
			$scope.refagency =response['docketData'][0].refagency;
			console.log($scope.refagency);
			console.log("AFFAn");
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
	
	/* 
			  Name : Amol S
			  Description : Function is used to get selected user information like  Attorney, Agency or Case worker .
			  Created on : 11-11-2016
			*/
		  $scope.getuserInformation = function(flage_party){
			  console.log(flage_party);
			  console.log("AFFAN");
          if(flage_party=='edit'){
             //Edit Party when select the user will get the user all in formation from table Amol s.
             if($scope.edit_selecteduserid!=undefined && $scope.edit_selecteduserid!=null && $scope.edit_selecteduserid!=''){
                    DocketFactory.getuserdetailsdds($scope.edit_selecteduserid).success(function(response){
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

          					DocketFactory.getuserdetailsdds($scope.selecteduserid).success(function(response){
								console.log(response);
								console.log("AFFAn");
								$('#last_name').val('');
								$scope.officerrid=response[0].officerrid;
								$scope.first_name=response[0].Firstname;
          						$scope.middle_name=response[0].Middlename;
          						$scope.company_name=(response[0].Company.trim());
          						$scope.address1=response[0].Address1;
          						$scope.address2=response[0].Address2;
          						$scope.city=response[0].City;
          						$scope.statename=response[0].State;
          						$scope.zip_code=response[0].Zip;
          						$scope.email=response[0].Email;
          						$scope.fax=response[0].fax;
          						$scope.phone=response[0].Phone;
          						$scope.title=response[0].Title;
          						$scope.last_name = $.trim(response[0].Lastname);
								$('#last_name').val($scope.last_name);	
								console.log($scope.company_name);

          					});
				     }

           }
			
		  };	
				$scope.chkForCurrentDateTimeASPerUTC = function(dateUTC){	
						var d = new Date(dateUTC);	
						var da = d.setTime( d.getTime() + d.getTimezoneOffset()*60*1000 );	
						var date = $filter('date')(da, 'MM-dd-yyyy');
						console.log(date);
						return date;
				};
	
	/* 
			  Name : Affan S
			  Description : Function is used to get 1205 and officer details as per docket case id .
			  Created on : 11-11-2016
			*/
			
		  $scope.getofficerpartyInformation = function(docket_number){    
				
					Form1205Factory.searchby1205form("form1205offence", "caseid = '" + docket_number + "'").success(function(response) {
						console.log(response);
						console.log(response[0].county_of_occurences);
						console.log(response[0].incident_date);
						console.log(response[0].dob);
						// $scope.incident_date = $scope.chkForCurrentDateTimeASPerUTC(response[0].incident_date);
						// $scope.dob = $scope.chkForCurrentDateTimeASPerUTC(response[0].dob);	
						if(response[0].incident_date == null || response[0].dob ==  null )	
						{
							console.log("abc");
							$scope.incident_date = '';
							$scope.dob =''
						}else{
						 	$scope.incident_date = $scope.chkForCurrentDateTimeASPerUTC(response[0].incident_date);
						 	$scope.dob = $scope.chkForCurrentDateTimeASPerUTC(response[0].dob);					
						}
						if(response[0].county_of_occurences != 'No County'){
							$scope.county_occur = response[0].county_of_occurences; 
						}
						if(response[0].telv_o_five == 1){
							$scope.result = response;
							$scope.officerrid=response[0].officerrid;
							$scope.citation=response[0].citiation;	
		
							$scope.incident_time= response[0].incident_time;
							
							//$scope.incident_time =  new Date($scope.incident_time);
							$scope.officer_badge_number=response[0].officer_badge_number;
							$scope.commercial_vehicle=response[0].commercial_vehicle;
							$scope.hazourdous_vehicle=response[0].hazourdous_vehicle;
							$scope.stateofissue =response[0].state_of_issue;
							$scope.licenseclass	=response[0].license_class_id;	
		
							$scope.restriction=response[0].restrictions;					
							$scope.gender	= response[0].gender
							$scope.height=response[0].height;
							if($scope.height == 'Null'){								
							}else{
							$scope.inches = $scope.height.toString().split(".")[1]; ///after
							$scope.feet =    $scope.height.toString().split(".")[0]; ///before
							$scope.weight=response[0].weight;		
							}
							$scope.driver_request = response[0].driver_request;
							
							console.log($scope.citation);
							console.log($scope.officerrid);
							console.log($scope.county_occur);
							console.log("AFFANID");
							if(response[0].telv_o_five == 0){
								console.log("1205 Form Not created")
							}else{
								var docketDetailsInfo = {caseid:docket_number,officerrid:$scope.officerrid}
								Form1205Factory.searchby1205form("agencycaseworkerbycase", docketDetailsInfo).success(function(response) {
									console.log(response);
															$scope.getofficerdetails = response;
									$scope.getofficerdetailsArray = $scope.getofficerdetails[0];
									console.log($scope.getofficerdetails);
									
										$scope.first_name=response[0].Firstname;
										$scope.middle_name=response[0].Middlename;
										$scope.company_name=(response[0].Company.trim());
										$scope.address1=response[0].Address1;
										$scope.address2=response[0].Address2;
										$scope.city=response[0].City;
										$scope.statename=response[0].State;
										$scope.zip_code=response[0].Zip;
										$scope.email =response[0].Email;
										$scope.fax=response[0].Fax;
										$scope.phone=response[0].Phone;
										$scope.title=response[0].Title; 
										$scope.last_name = $.trim(response[0].Lastname);
								
								});	
										
							}
					}else{
						$scope.getofficerdetailsflag = true;
					}
					});
					
					
				
		  };	
		 $scope.getofficerpartyInformation($scope.docket_number);
	
	
	// fullton county function start here.
	
	$scope.checkForFulTonCounty = function(county_occur,city) {
		console.log(county_occur);
		city = city.toLowerCase().replace(/\b[a-z]/g, function(letter) {
			return letter.toUpperCase();
		});		
		console.log(city);
		var getcity = city;		
		$scope.fulltoncity = ['Roswell','Alpharetta','Sandy Springs','Johns Creek','Milton'];
		var a = $scope.fulltoncity.indexOf(getcity);
		console.log(a);		
		$scope.fulltoncityCOunty = ['Roswell','Alpha','SSprings','JohnsCreek','Milton'];
		if(a != -1){
		var arraycontainsturtles = $scope.fulltoncity.indexOf(city);
		console.log($scope.fulltoncity[arraycontainsturtles]);
		$scope.county_occur = "FUL_"+$scope.fulltoncityCOunty[arraycontainsturtles];
		}else{
			$scope.county_occur = county_occur;
		}
		console.log($scope.county_occur);
	};

	// function change the agency from dds to dps on basis of city.
	
	$scope.checkForDpsCompany = function(address1,county) {
		console.log(address1);
		$scope.addressArray = ['GEORGIA STATE PATROL','GEORGIA DEPARTMENT OF PUBLIC SAFETY','georgia department of public safety','georgia state patrol'];
		if($scope.addressArray.indexOf(address1)){
			$scope.address1 = address1.toUpperCase();
		}
		if($scope.address1 == 'GEORGIA STATE PATROL' || $scope.address1 == 'GEORGIA DEPARTMENT OF PUBLIC SAFETY'){
			$scope.refagency = 'DPS';
			 var countyid =   $('#county_occur').find('option:selected').attr('conty');
			 var docketDPSDetails={caseid:$scope.docket_number,agencey:$scope.refagency,casetype:'ALS',county:county,countyid:countyid,Address1:address1};
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
	 //Get officerdetails from databse
	Form1205Factory.getdynamicdata("officerdetails").success(function(response){
		$scope.officerdata = response;
		console.log($scope.officerdata);
    }); 	
	console.log($scope.officerdata);
	$scope.receivedDate = $filter('date')(new Date(), 'MM-dd-yyyy');
	
	 //AFFAN s Get the autopopulate party details 
      //AFFAN s Get the autopopulate party details 
     $scope.dataAutopopulate = function(){
		$scope.typeOfcontact = '';
		console.log($scope.contactType);
		if($scope.contactType=="Officer")
		{
			$scope.typeOfcontact = $scope.contactType;
		}
		if($scope.edit_contact_type=="Officer" )
		{
			$scope.typeOfcontact = $scope.edit_contact_type;
		}
		if($scope.update_contact_type=="Officer")
		{
			$scope.typeOfcontact = $scope.update_contact_type;
		}
		console.log($scope.typeOfcontact);
		console.log("AFFAN");
		  DocketFactory.autopopulatedds($scope.typeOfcontact).success(function(response){
			  console.log(response);
			  $scope.dataSourceUserlist=response;
		  });
    }
    $scope.dataAutopopulate();
	
	 // console.log( $scope.countyList_root);
      //Add officer autocomplect use this function Start Here // Amol s
      var ctrl = this;
	  console.log(ctrl);
        ctrl.party ={"name":'', "id":''};
        $scope.setAddPartyData = function(item){
		console.log(item);	
            $scope.selecteduserid="";
             if (item){
                 ctrl.party = item;
				 console.log(ctrl.party.id);
                $scope.selecteduserid=ctrl.party.id;
				console.log($scope.selecteduserid);
				
                $scope.getuserInformation("add");
             }  
             
        }
		
		////
		
	

	
	/* 
		Name : Affan shaikh
		Description : Function is used to add 1205 form.
		Created On : 05-12-2016
	*/
	$scope.update1205 = function()
	{
		$scope.disable_button = '1'; 
			$rootScope.errorMessageshow=0;
			flag = true;
				// if($scope.agencyCode=='' || $scope.agencyCode==undefined || $scope.casetypeselect=='' || $scope.casetypeselect==undefined|| $scope.countyselect=='' || $scope.countyselect==undefined|| $scope.dateRequested=='' || $scope.dateRequested==undefined || $scope.hearingType=='' || $scope.hearingType==undefined || $scope.receivedDate=='' || $scope.receivedDate==undefined || $scope.caseLocation=='' || $scope.caseLocation==undefined || $scope.hearingDate=='' || $scope.hearingDate==undefined || $scope.hearingTime=='' || $scope.hearingTime==undefined || $scope.judge=='' || $scope.judge==undefined || $scope.judgeAssistant=='' || $scope.judgeAssistant==undefined)
					// {

						$scope.disable_button = '1'; 
						
						$('.add_1205').each(function(){
							console.log($(this).val());
							var cur = $(this);
							id = $(this).attr("id");
							console.log(id)
							if ($.trim(cur.val()) == '' ||  $.trim(cur.val()) == 0 ){
								
								$rootScope.errorMessageshow=1;
								$rootScope.errorMessage=$(this).attr("msg");
								flag= false;
								return false;
								
							
							}
							console.log($.trim(cur.val()));
							if ($.trim(cur.val()) != '' ||  $.trim(cur.val()) != 0 ){
								console.log($('input[name=driver_request]:checked').length);													
								if($scope.incident_time == 'Null' || $scope.incident_time == null ||  $scope.incident_time == '' ){
										$rootScope.errorMessageshow=1;
										$rootScope.errorMessage='Please enter Incident Time.';
										flag= false;
										return false;	
								}
								if ($('input[name=driver_request]:checked').length == 0) {
									$rootScope.errorMessageshow=1;
									$rootScope.errorMessage='Please Select Driver Request.'
									flag= false;
									return false;
								} 
									
							}
							
						});	
						
							console.log($scope.height);	
							console.log($scope.incident_time);	
						
						// function to check fulton county process.
						
						if(flag){
							loader.show();
						$scope.conty = $('#county_occur').find('option:selected').attr('conty');
						console.log($scope.conty);
						console.log($scope.refagency);
						
						// check for DPS Agency
						if($scope.refagency != 'DPS'){
							$scope.checkForFulTonCounty($scope.county_occur,$scope.city);
						}
						
						// check for Company Name
						if($scope.company_name != undefined){
							$scope.title = $scope.checkForDpsCompany($scope.address1,$scope.county_occur);
							console.log($scope.title);
						}
						console.log($scope.officeryesno);
						//if($scope.officeryesno == true){
							console.log($scope.title);
							console.log($scope.officerrid);	
							console.log($scope.refagency);							
							var officerDetails={contactid:$scope.officerrid,docket_number:$scope.docket_number,contactType:$scope.contacttype,Lastname:$scope.last_name,Firstname:$scope.first_name,Middlename:$scope.middle_name,Title:$scope.title,Company:$scope.company_name,Address1:$scope.address1,Address2:$scope.address2,City:$scope.city,State:$scope.statename,Zip:$scope.zip_code,Phone:$scope.phone,Email:$scope.email,fax:$scope.fax,refagency:$scope.refagency};						
							var officerDetailsMatch={Lastname:$scope.last_name,Firstname:$scope.first_name,Middlename:$scope.middle_name,Title:$scope.title,Company:$scope.company_name,Address1:$scope.address1,Address2:$scope.address2,City:$scope.city,State:$scope.statename,Zip:$scope.zip_code,Phone:$scope.phone,Email:$scope.email,fax:$scope.fax};						
								console.log(officerDetailsMatch);
								console.log($scope.getofficerdetailsArray);							
								
							if(officerDetailsMatch != undefined){
								if($scope.getofficerdetailsflag !=true){
								$.each(officerDetailsMatch, function(key, value) {
								var getkey = key;

									if($scope.getofficerdetailsArray[key] != value ){
										console.log($scope.getofficerdetailsArray [key]+"="+ value);
										if($scope.getofficerdetailsArray!= undefined || $scope.getofficerdetailsArray[key] != undefined || $scope.getofficerdetailsArray[key] == "" || $scope.getofficerdetailsArray[key]== null || value !='Officer' ||  getkey != 'docket_number' || getkey !='refagency' || getkey !='contactType' ){
											console.log($scope.getofficerdetailsArray[key]);
											$scope.officerDetailsUpdateFlag = true;	
											return false;
										}else{
											$scope.officerDetailsUpdateFlag = false;	
										}											
										
									}else{
										$scope.officerDetailsUpdateFlag = false;
									}
								});	
								}else{
									$scope.getofficerdetailsflag = false;
									$scope.officerDetailsUpdateFlag = true
								}									
							}else{
								$scope.officerDetailsUpdateFlag = true
							}
							if($scope.feet != undefined && $scope.inches == undefined){
								$scope.height = $scope.feet+".0";
							}
							else if($scope.feet == undefined || $scope.inches == undefined){
								$scope.height = 'Null';
							}else{
								$scope.height = $scope.feet+"."+$scope.inches;
							}
							console.log($scope.height);							

							if($scope.officerDetailsUpdateFlag == true){
								Form1205Factory.add1205Details(officerDetails).success(function(response){	
								//loader.hide();
								console.log(response);	
								$scope.officerrid = response.replace(/^"(.*)"$/, '$1');
								console.log($scope.officerrid);
								
								if(response){
									console.log($scope.stateofissue);
									console.log($scope.officerrid);
									
									dob=  $scope.dob.replace("-", "/");
									dob = dob.replace("-", "/");	
									
									incident_date=  $scope.incident_date.replace("-", "/");
									incident_date = incident_date.replace("-", "/");
									
									$scope.dob = $filter('date')(new Date(dob), 'yyyy-MM-dd');
								    $scope.incident_date = $filter('date')(new Date(incident_date), 'yyyy-MM-dd'); 
									
									var form1205Details={docket_number:$scope.docket_number,officerrid:$scope.officerrid,contactType:'form1205',citiation_num:$scope.citation,county_of_occurences:$scope.county_occur,incident_date:$scope.incident_date,incident_time:$scope.incident_time,officer_badge_number:$scope.officer_badge_number,commercial_vehicle:$scope.commercial_vehicle,hazardous_vehicle:$scope.hazardous_vehicle,state_of_issue:$scope.stateofissue,license_class_id:$scope.licenseclass,dob:$scope.dob,gender:$scope.gender,restrictions:$scope.restriction,height:$scope.height,weight:$scope.weight,driver_request:$scope.driver_request,countyid:$scope.conty,company_name:$scope.company_name,refagency:$scope.refagency};	
									console.log(form1205Details);
						 
										Form1205Factory.add1205Details(form1205Details).success(function(response){											
											console.log(response);
											if(response){												
												$rootScope.errorMessageshow=1;												
												// $rootScope.errorMessage="Party added successfully!";
												loader.hide();
												$rootScope.errorMessage="1205 form saved successfully.";
												PageLeaveWarning.reset();
												$scope.changed_flag = '0';
												//$('#addparty').modal('toggle');
												/* $scope.getDocketinformation();
												$scope.partydetails();
												$scope.dataAutopopulate();// To Get the  New added partys in autopopulate */
												// $rootScope.errorMessage="Data updated successfully";
												//$scope.HistoryMessage = '<p class="history-title">Party has been added with following:</p>'+$scope.versement_each;
												//$scope.updateHistory($scope.docket_number,$scope.HistoryMessage);
												$scope.versement_each = "";	
												$scope.officeryesno = false;
												$window.location.reload();
											}else{
												
												
												  $rootScope.errorMessageshow=1;
												  $rootScope.errorMessage="Some thnig went wrong tray again later";
								
											}
										});
								}else{
									console.log("od");
									
								}
								
								
							});	
							}else{
								$scope.dob = $filter('date')(new Date($scope.dob), 'yyyy-MM-dd');
								$scope.incident_date = $filter('date')(new Date($scope.incident_date), 'yyyy-MM-dd'); 
								var form1205Details={docket_number:$scope.docket_number,officerrid:$scope.officerrid,contactType:'form1205update',citiation_num:$scope.citation,county_of_occurences:$scope.county_occur,incident_date:$scope.incident_date,incident_time:$scope.incident_time,officer_badge_number:$scope.officer_badge_number,commercial_vehicle:$scope.commercial_vehicle,hazardous_vehicle:$scope.hazardous_vehicle,state_of_issue:$scope.stateofissue,license_class_id:$scope.licenseclass,dob:$scope.dob,gender:$scope.gender,restrictions:$scope.restriction,height:$scope.height,weight:$scope.weight,driver_request:$scope.driver_request,countyid:$scope.conty,refagency:$scope.refagency};	
								console.log(form1205Details);
								
									Form1205Factory.add1205Details(form1205Details).success(function(response){
										
										console.log(response);
										if(response){
											$rootScope.errorMessageshow=1;
											// $rootScope.errorMessage="Party added successfully!";
											loader.hide();
											$rootScope.errorMessage="1205 form saved successfully.";
											PageLeaveWarning.reset();
											$scope.changed_flag = '0';
											$('#addparty').modal('toggle');
											 $scope.getDocketinformation();
											//$scope.partydetails();
											$scope.dataAutopopulate();// To Get the  New added partys in autopopulate */
											// $rootScope.errorMessage="Data updated successfully";
											//$scope.HistoryMessage = '<p class="history-title">1205 Form has been added with following:</p>'+$scope.versement_each;
											//$scope.updateHistory($scope.docket_number,$scope.HistoryMessage); 
											//$scope.versement_each = "";	
											$scope.dob = $filter('date')(new Date($scope.dob), 'MM-dd-yyyy');
											$scope.incident_date = $filter('date')(new Date($scope.incident_date), 'MM-dd-yyyy'); 
									 	}else{
										  $rootScope.errorMessageshow=1;
											$rootScope.errorMessage="Some thnig went wrong tray again later";
							
										}
									});		
							}							

					
						}
						
					};	
									// Incident  Time Picker 
				   $scope.mytime = $scope.incident_time;
				   $scope.hstep = 1;
				   $scope.mstep = 15;

					$scope.options = {
						hstep: [1, 2, 3],
						mstep: [1, 5, 10, 15, 25, 30]
				   };

				  $scope.ismeridian = true;
				  $scope.toggleMode = function() {
					$scope.ismeridian = ! $scope.ismeridian;
				  };

				  $scope.update = function() {
					var d = new Date();
					d.setHours( 14 );
					d.setMinutes( 0 );
					$scope.mytime = d;
				  };

					$scope.updateHistory = function(docket_number,HistoryMessage){
						 DocketFactory.updateHistory({
									caseid:docket_number,
									message:HistoryMessage
								}).success(function(response){
								 console.log(response);
						});	
					};
	/* 
		Name  : Neha Agrawal
		Date Created : 28-02-2017
		Description : Function is used to check changed value of docket for pageleaving warning message.
	*/
	$scope.changed_flag = '0';
	$scope.change_value = function()
	{
		$scope.changed_flag = '1';
		$rootScope.pageLeaveWarning.watchCount = 1;
	}
	/* 
	Name : Neha Agrawal
	Description : Page leaving Warning pop-up
	Created Date : 05-04-2017
	*/
	PageLeaveWarning.watch($scope,[
		// 'citation',
		// 'county_occur',
		// 'incident_date',
		// 'incident_time',
		// 'officer_badge_number',
		// 'commercial_vehicle',
		// 'hazardous_vehicle',
		// 'stateofissue',
		// 'licenseclass',
		// 'dob',
		// 'restriction',
		// 'gender',
		// 'feet',
		// 'inches',
		// 'weight',
		// 'driver_request',
		// 'officeryesno',
		// 'contacttype',
		// 'last_name',
		// 'first_name',
		// 'middle_name',
		// 'title',
		// 'company_name',
		// 'address1',
		// 'address2',
		// 'city',
		// 'state',
		// 'zip_code',
		// 'phone',
		// 'email',
		// 'fax',
		'changed_flag'
	]);
	
	
	DynamicFactory.getdynamicdata("states","idstates","0","2").success(function(response){
			$scope.stateList=response;
		});
		$scope.statename = 'GA';
		
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
			// $scope.edit_zipcode = zip_code;
		}
	}
  
	
	}]);
	
	osahApp.directive('partyOfficerAutoComplete',['$filter',partyAutoCompleteDir]); 
  function partyAutoCompleteDir($filter) {
          
            return {
                restrict: 'A',       
                link: function (scope, element, attrs) {
                   var element_name= "";
                   element.autocomplete({
                        source: function (request, response) {
							if(scope.officeryesno == false  ){
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
loader.hide();
        }
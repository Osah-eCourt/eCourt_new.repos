
osahApp.controller('commancontroller',['$scope','$rootScope','$state','LoginFactory','SessionFectory','SearchFactory','DynamicFactory','Base64','loader','$timeout','DateFormat','$filter',function($scope,$rootScope,$state,LoginFactory,SessionFectory,SearchFactory,DynamicFactory,Base64,loader,$timeout,DateFormat,$filter){
    $scope.countyList='';
    $scope.AgencyList='';
    $scope.casetypesList='';
    $scope.judgeList='';
    $scope.Judge_AssistantList='';
    $scope.courtlocationList='';
    $scope.statusList=''; 
    $scope.docketerMessage="";
    $scope.contactList='';
    $scope.advance_error_message=".";
    $scope.expsymbol ={};
    $scope.expsymbol.additionalSearchBlock=false;
	
    $scope.county='0'; $scope.stas='0'; $scope.agency='0';	$scope.judge='0';
    $scope.casetype='0'; $scope.jdgasst='0'; $scope.hearingSite='0'; $scope.contactType='0';
	$scope.case_type = 'O';
	
	$scope.loggedUserType = Base64.decode(SessionFectory.get('user_type'));
		//This function will search docket detail docket no
        
        $scope.setbackpagename=function(pagename){
           //$state.back_page_name=pagename;
        } 
			   
        $scope.logoutUser=function(element){
            $scope.additionalSearchBlockFn(false);//$('.additional-search-block').slideUp();
          LoginFactory.logout().success(function(response){

               switch (response) {
                     case '1':
                             SessionFectory.destroy('user');
                             SessionFectory.destroy('user_type');
                             $state.go('login');
                             break;

                     default:
                             $state.go('login');
                             break;
               }

          });
		 //on logout clear the advance search.
		 $('.resetdata').each(function(){
				var cur = $(this);
				id = $(this).attr("id");
				$('#'+id).val("");
				$('#'+id).find('option:first').attr('selected', 'selected');		

		});
		  
        }
		/* 
		Added By Neha.
		*/
		$rootScope.docketSearch = {
			docketno: '',
		 }
        
    //This function will search docket detail docket no
	
   $scope.searchbydocket = function(docketno){
	   console.log(docketno);
      if(docketno!='' && docketno!=undefined){
         $scope.docket_no = Base64.encode(docketno);
		 $state.go("docket",{reqdt:$scope.docket_no},{reload: true});
      }else{
		   $rootScope.errorMessageshow=1;
		   $rootScope.errorMessage="Please enter docket# ";
      }
      $scope.additionalSearchBlockFn(false); 
   }; 
   
 // $rootScope.$on("$stateChangeSuccess", function(event, toState, toParams, fromState, fromParams) {
	 // console.log(toState.name);
	 // if(toState.name=='home')
	 // {
		 // console.log('yes');
		 // $rootScope.docketno = 'fggg';
	 // }
 // });
   
   $rootScope.advanceSearch = {
			lastName: '',
			firstName:'',
			contactType:'',
			agencyreference:'',
			county:'',
			stas:'',
			agency:'',
			casetype:'',
			judge:'',
			judgeass:'',
			hearingsite:'',
			hdf:'',
			hdto:'',
			drf:'',
			drto:'',
			hearingtime:'',
		}
        
		
   $rootScope.advanceSearch = function(lastName,firstName,contactType,agencyreference,county,status,agency,casetype,judge,judgeass,hearingsite,hdf,hdto,drf,drto,hearingtime,chdf=0){
				// $('.resetdata').each(function(){
				// var cur = $(this);
				// id = $(this).attr("id");
				// $('#'+id).val("");
				// $('#'+id).find('option:first').attr('selected', 'selected');		

		// });
	   $scope.advance_error_message=".";
       $scope.query_str={};
       $scope.query_str='';
       $scope.query_str_Fname='';
       $scope.query_str_Lname='';
       $scope.query_str_sataus='';
       $scope.query_str_contacttype='';
       $scope.caseStatusFalge=0;
       $scope.myquery={};
	   
	   $rootScope.advanceSearch.judge = judge;
	   $rootScope.advanceSearch.judgeass = judgeass;
	   $rootScope.advanceSearch.hearingsite = hearingsite;
	   
	   
      // if((lastName!='' && lastName!=undefined) || (firstName!='' && firstName!=undefined) || (contactType!='' && contactType!=0 && contactType!=undefined) || (agencyreference!='' && agencyreference!=undefined) || (county!=0 && county!=undefined) || (status!=0 && status!=undefined) || (agency!=0 && agency!=undefined) || (casetype!=0 && casetype!=undefined)|| (judge!=0 && judge!=undefined)|| (judgeass!=0 && judgeass!=undefined)|| (hearingsite!=0 && hearingsite!=undefined)|| (hdf!='' && hdf!=undefined)|| (hdto!='' && hdto!=undefined)||(hdto!='' && hdto!=undefined)||(drf!='' && drf!=undefined)||(drto!='' && drto!=undefined)){
		if(($rootScope.advanceSearch.lastName!='' && $rootScope.advanceSearch.lastName!=undefined) || ($rootScope.advanceSearch.firstName!='' && $rootScope.advanceSearch.firstName!=undefined) || ($rootScope.advanceSearch.contactType!='' && $rootScope.advanceSearch.contactType!=0 && $rootScope.advanceSearch.contactType!=undefined) || ($rootScope.advanceSearch.agencyreference!='' && $rootScope.advanceSearch.agencyreference!=undefined) || ($rootScope.advanceSearch.county!=0 && $rootScope.advanceSearch.county!=undefined) || ($rootScope.advanceSearch.stas!=0 && $rootScope.advanceSearch.stas!=undefined) || ($rootScope.advanceSearch.agency!=0 && $rootScope.advanceSearch.agency!=undefined) ||($rootScope.advanceSearch.casetype!=0 && $rootScope.advanceSearch.casetype!=undefined)||($rootScope.advanceSearch.judge!=0 && $rootScope.advanceSearch.judge!=undefined)||($rootScope.advanceSearch.judgeass!=0 && $rootScope.advanceSearch.judgeass!=undefined)||($rootScope.advanceSearch.hearingsite!=0 && $rootScope.advanceSearch.hearingsite!=undefined)|| ($rootScope.advanceSearch.hdf!='' && $rootScope.advanceSearch.hdf!=undefined)||($rootScope.advanceSearch.hdto!='' && $rootScope.advanceSearch.hdto!=undefined)||($rootScope.advanceSearch.drf!='' && $rootScope.advanceSearch.drf!=undefined)||($rootScope.advanceSearch.drto!='' && $rootScope.advanceSearch.drto!=undefined)){
		  
        loader.show();
    if($rootScope.advanceSearch.lastName!='' && $rootScope.advanceSearch.lastName!=undefined){
          //$scope.query_str +="Lastname ='"+lastName+"'";
         $scope.query_str_Lname ="Lastname ='"+$rootScope.advanceSearch.lastName+"'";
        $scope.myquery.Lastname = $rootScope.advanceSearch.lastName; 

      }
          
   if($rootScope.advanceSearch.firstName!='' && $rootScope.advanceSearch.firstName!=undefined){
     
      // $scope.query_str +=($scope.query_str=='')?"Firstname ='"+firstName+"'":" && Firstname ='"+firstName+"'";
     // $scope.query_str_name +=($scope.query_str_name=='')?"Firstname ='"+firstName+"'":" && Firstname ='"+firstName+"'";
      $scope.query_str_Fname="Firstname ='"+$rootScope.advanceSearch.firstName+"'";
      $scope.myquery.Firstname = $rootScope.advanceSearch.firstName; 
   
   }
   if($rootScope.advanceSearch.contactType!=0 && $rootScope.advanceSearch.contactType!=undefined){
       
         //$scope.query_str +=($scope.query_str=='')?"typeofcontact ='"+contactType+"'":" && typeofcontact ='"+contactType+"'";
        $scope.query_str_contacttype="typeofcontact ='"+$rootScope.advanceSearch.contactType+"'";
        $scope.myquery.typeofcontact = $rootScope.advanceSearch.contactType; 
   }
   
   if($rootScope.advanceSearch.agencyreference!='' && $rootScope.advanceSearch.agencyreference!=undefined) { 
        
         $scope.query_str +=($scope.query_str=='')?"agencyrefnumber ='"+$rootScope.advanceSearch.agencyreference+"'":" && agencyrefnumber ='"+agencyreference+"'";
        $scope.myquery.agencyrefnumber = $rootScope.advanceSearch.agencyreference;
   }
          
   if($rootScope.advanceSearch.county!=0 && $rootScope.advanceSearch.county!=undefined){
       
      $scope.query_str +=($scope.query_str=='')?"county ='"+$rootScope.advanceSearch.county+"'":" && county ='"+county+"'";
      $scope.myquery.county = $rootScope.advanceSearch.county;
   }
          
   if($rootScope.advanceSearch.stas!=0 && $rootScope.advanceSearch.stas!=undefined){
        $scope.query_str +=($scope.query_str=='')?"status ='"+$rootScope.advanceSearch.stas+"'":" && status ='"+$rootScope.advanceSearch.stas+"'";
         $scope.myquery.status = $rootScope.advanceSearch.stas;
       $scope.caseStatusFalge=1;   
   }
          
   if($rootScope.advanceSearch.agency!=0 && $rootScope.advanceSearch.agency!=undefined){
       $scope.query_str +=($scope.query_str=='')?"refagency ='"+$rootScope.advanceSearch.agency+"'":" && refagency ='"+$rootScope.advanceSearch.agency+"'";
      $scope.myquery.refagency = $rootScope.advanceSearch.agency;
   }
          
   if($rootScope.advanceSearch.casetype!=0 && $rootScope.advanceSearch.casetype!=undefined){
       $scope.query_str +=($scope.query_str=='')?"casetype ='"+$rootScope.advanceSearch.casetype+"'":" && casetype ='"+$rootScope.advanceSearch.casetype+"'";
      $scope.myquery.casetype = $rootScope.advanceSearch.casetype;
   }
          
   if($rootScope.advanceSearch.judge!=0 && $rootScope.advanceSearch.judge!=undefined){
      $scope.query_str +=($scope.query_str=='')?"judge ='"+$rootScope.advanceSearch.judge+"'":" && judge ='"+$rootScope.advanceSearch.judge+"'";
      $scope.myquery.judge = $rootScope.advanceSearch.judge;
   }
          
   if($rootScope.advanceSearch.judgeass!=0 && $rootScope.advanceSearch.judgeass!=undefined){
       $scope.query_str +=($scope.query_str=='')?"judgeassistant ='"+$rootScope.advanceSearch.judgeass+"'":" && judgeassistant ='"+$rootScope.advanceSearch.judgeass+"'";
      $scope.myquery.judgeassistant = $rootScope.advanceSearch.judgeass;
   }
         
   if($rootScope.advanceSearch.hearingsite!=0 && $rootScope.advanceSearch.hearingsite!=undefined){
        $scope.query_str +=($scope.query_str=='')?"hearingsite ='"+$rootScope.advanceSearch.hearingsite+"'":" && hearingsite ='"+$rootScope.advanceSearch.hearingsite+"'";
        $scope.myquery.hearingsite = $rootScope.advanceSearch.hearingsite;
    }
   
   if($rootScope.advanceSearch.hdf!='' && $rootScope.advanceSearch.hdf!=undefined ){
	    $scope.query_str +=($scope.query_str=='')?"hearingdate >='"+DateFormat.yyyymmdd($rootScope.advanceSearch.hdf)+"'":" && hearingdate >='"+DateFormat.yyyymmdd($rootScope.advanceSearch.hdf)+"'";
       $scope.myquery.hearingdate_From = DateFormat.yyyymmdd($rootScope.advanceSearch.hdf);
   }
   if(chdf!='' && chdf!=undefined && chdf!=0 ){
	    $scope.query_str +=($scope.query_str=='')?"calendarhearingdate ='"+DateFormat.yyyymmdd(chdf)+"'":" && calendarhearingdate ='"+DateFormat.yyyymmdd(chdf)+"'";
      $scope.myquery.calendarhearingdate = DateFormat.yyyymmdd(chdf);
   }
          
   if($rootScope.advanceSearch.hdto!='' && $rootScope.advanceSearch.hdto!=undefined){
        $scope.query_str +=($scope.query_str=='')?"hearingdate <='"+DateFormat.yyyymmdd($rootScope.advanceSearch.hdto)+"'":" && hearingdate <='"+DateFormat.yyyymmdd($rootScope.advanceSearch.hdto)+"'";
      $scope.myquery.hearingdate_To = DateFormat.yyyymmdd($rootScope.advanceSearch.hdto);
   }
   
   if($rootScope.advanceSearch.drf!='' && $rootScope.advanceSearch.drf!=undefined){
      $scope.query_str +=($scope.query_str=='')?"datereceivedbyOSAH >='"+DateFormat.yyyymmdd($rootScope.advanceSearch.drf)+"'":" && datereceivedbyOSAH >='"+DateFormat.yyyymmdd($rootScope.advanceSearch.drf)+"'";
      $scope.myquery.datereceivedbyOSAH_From = DateFormat.yyyymmdd($rootScope.advanceSearch.drf);
   }
   
   if($rootScope.advanceSearch.drto && $rootScope.advanceSearch.drto!=undefined){
        $scope.query_str +=($scope.query_str=='')?"datereceivedbyOSAH <='"+DateFormat.yyyymmdd($rootScope.advanceSearch.drto)+"'":" && datereceivedbyOSAH <='"+DateFormat.yyyymmdd($rootScope.advanceSearch.drto)+"'";
      $scope.myquery.datereceivedbyOSAH_To = DateFormat.yyyymmdd($rootScope.advanceSearch.drto);
   }
   // hearing time parameter added by affan.
   //28-12-2016
    if(hearingtime!=0 && hearingtime!=undefined){
      $scope.query_str +=($scope.query_str=='')?"hearingtime ='"+hearingtime+"'":" && hearingtime ='"+hearingtime+"'";
     $scope.myquery.hearingtime = hearingtime;
   }
     
    // console.log(contactType); 
        if($scope.caseStatusFalge==0){  /*$scope.query_str +=" && status !='Closed'";*/ $scope.myquery['status'] = "NA"; /*$scope.query_str_sataus="status !='Closed'";*/ }
         //$rootScope.advanceserachdata[0] = $scope.query_str;
            var mydata=JSON.stringify($scope.myquery);
     //console.log(JSON.stringify($scope.myquery));
        $scope.query_str=  $scope.query_str_Lname+"/"+$scope.query_str_Fname+"/"+$scope.query_str_contacttype+"/"+ $scope.query_str+"/"+$scope.query_str_sataus;
        //console.log($scope.query_str); 
        //$scope.query_string = Base64.encode($scope.query_str);
        mydata = Base64.encode(mydata);
       //console.log(Base64.encode(mydata));
        $scope.flag = Base64.encode('2');
        //$("#symbol").html("+");
        $scope.additionalSearchBlock=false;
        $scope.additionalSearchBlockFn(false);  
		loader.hide();
		
			$rootScope.advanceSearch.lastName = '';
			$rootScope.advanceSearch.firstName = '';
			$rootScope.advanceSearch.contactType = '';
			$rootScope.advanceSearch.agencyreference = '';
			$rootScope.advanceSearch.county = '';
			$rootScope.advanceSearch.stas = '';
			$rootScope.advanceSearch.agency = '';
			$rootScope.advanceSearch.casetype = '';
			$rootScope.advanceSearch.judge = '';
			$rootScope.advanceSearch.judgeass = '';
			$rootScope.advanceSearch.hearingsite = '';
			$rootScope.advanceSearch.hdf = '';
			$rootScope.advanceSearch.hdto = '';
			$rootScope.advanceSearch.drf = '';
			$rootScope.advanceSearch.drto = '';
			$rootScope.advanceSearch.hearingtime = '';
		
		
        $state.go("searchresult",{reqdt:mydata,flg:$scope.flag},{reload: true});   
       //console.log(contactType);
    }else{
       $rootScope.errorMessageshow=1;
       $rootScope.errorMessage="Please enter the search data";
    }
       
  }
  
          
  
  //Get contact type from databse
  DynamicFactory.getdynamicdata("typeofcontact","id","0","2").success(function(response){
      $scope.contactList=response;
      $rootScope.contactList_root=response;
  });
  
  //Get county from databse
  DynamicFactory.getdynamicdata("county","CountyID","0","2").success(function(response){
      $scope.countyList=response;
       $rootScope.countyList_root=response;
  });

  //Get Agency from databse
  DynamicFactory.getdynamicdata("agency","AgencyID","0","2").success(function(response){
       $scope.AgencyList=response;
        $rootScope.AgencyList_root=response;    
  });
  
  // Get casetypes from databse
  DynamicFactory.getdynamicdata("casetypes","Active","1","1").success(function(response){
       $scope.casetypesList=response;
       $rootScope.casetypesList_root=response; 
  }); 
  
  //Get Judge from databse
  DynamicFactory.getdynamicdata("judge_assistant_clerk","user_type","'judge'","1").success(function(response){
       $scope.judgeList=response;
        $rootScope.judgeList_root=response;
   
  }); 
  
  //Get Judge judgeassistant from databse
  DynamicFactory.getdynamicdata("judge_assistant_clerk","user_type","'cma'","1").success(function(response){
       $scope.Judge_AssistantList=response;
        $rootScope.Judge_AssistantList_root=response; 
  }); 

//Get Judge courtlocationList from databse
  DynamicFactory.getdynamicdata("courtlocations","courtlocationid","0","2").success(function(response){
       $scope.courtlocationList=response;
        $rootScope.courtlocationList_root=response; 
  }); 


//Get statuslist from databse
  DynamicFactory.getdocketstauslist().success(function(response){
       $scope.statusList=response;
       $rootScope.statusList_root=response;


  });

  //Get hearingtimelist from databse
  DynamicFactory.getdocketHearingTimelist().success(function(response){
       $rootScope.hearingtimeList_root=response;
  
  }); 
  
  //Get casetype Group from databse
   DynamicFactory.getcasetypegrouplist().success(function(response){
       $rootScope.getcasetypegroupList_root=response;
  
  }); 
	/* 
		Name : Neha Agrawal
		Description : Function is used to fetch the casetypes based on agency selected.
		Date created : 07-03-2017
	*/
	$scope.casetype_agencywise = function(){
         var agnid =  $('#agency').find('option:selected').attr('agnid');
		 console.log(agnid);
         $scope.agencyCode =  $('#agency').find('option:selected').val();
         if(agnid!=undefined && agnid !='' && agnid!=null){

              DynamicFactory.getdynamicdata("casetypes","AgencyID",agnid,1).success(function(response){
                  // $scope.casetypeselect='a0'; 
				   $rootScope.advanceSearch.casetype = '';
                  $scope.casetypesList=response;
              });

         }else{
			 $scope.casetypesList=$scope.casetypesList_root;
			 $rootScope.advanceSearch.casetype = '';
		 }
       }
	   
	   $scope.casetype_agencywise_cc = function(){
         var agnid =  $('#cc_agency').find('option:selected').attr('agnid_cc');
         $scope.agencyCode =  $('#cc_agency').find('option:selected').val();
         if(agnid!=undefined && agnid !='' && agnid!=null){

              DynamicFactory.getdynamicdata("casetypes","AgencyID",agnid,1).success(function(response){
                  $scope.casetypeselect='a0'; 
                  $scope.casetypesList=response;
              });

         }
       }

   //Get casetype Group from databse
   DynamicFactory.getpartylist().success(function(response){
       $rootScope.specialparty_root=response;
  
  }); 
   

	 /* 
        Author Name : Amol s.
        Description : Below Function is used to get the hearing type details .
      */
      SearchFactory.searchbyvalue("hearingmode","id !=0").success(function(response){

            $rootScope.hearingTypedetails  =  response;

      });  
   
        
  //This function will show and hide  Additional Search Options added by FaisalK
   $scope.additionalSearchBlockFn = function(dvalue){
        if(dvalue==undefined) $scope.expsymbol.additionalSearchBlock =! $scope.expsymbol.additionalSearchBlock;
        else $scope.expsymbol.additionalSearchBlock=dvalue;
       if($scope.expsymbol.additionalSearchBlock){
            $('.additional-search-block').slideDown();
            $('.additional-search-btn span').html('-');
        }else{
           $('.additional-search-block').slideUp();
           $('.additional-search-btn span').html('+');
        }
	   
   };        
        
   //To Remove the model Amol S.
   $scope.removemodel = function(){
      $rootScope.errorMessageshow=0;
      //console.log($rootScope.errorMessageshow);
   }  
	//@purpose - Hide alert after few second @FaisalK @03-11-2016
	$scope.$watch('errorMessageshow', function(newVal, oldVal){
		if(newVal==1)
		{
			$timeout(function(){$rootScope.errorMessageshow=0}, 3200);
		}
	}, true);
    
     // When the document is ready
            /* $(document).ready(function () {

            $('#hdf').datepicker({
                format: "yyyy-mm-dd"
            });
                
            $('#hdto').datepicker({
                format: "yyyy-mm-dd"
            });
                
            $('#drf').datepicker({
                format: "yyyy-mm-dd"
            });
                
            $('#drto').datepicker({
                format: "yyyy-mm-dd"
            });
        
        }); */
    
//    $('.additional-search-btn').click(function(){
//      $('.additional-search-block').slideToggle();
//    });



		$rootScope.fields = {
			dcfrom: '',
			dcto:'',
			cc_judge:'',
			cc_agency:'',
			cc_casetype:'',
			cc_county:'',
			cc_boxno:'',
		}
        
        /* 
			Name : Neha Agrawal
			Date Created : 06-03-2017
			Description : Function is used to search the closed cases.
		*/
		$rootScope.closeCasesearch = function(judge,cc_agency,cc_casetype,cc_county,closed_datefrom,closed_dcto,box_no)
		{
			if($rootScope.fields.dcto=='' ||$rootScope.fields.dcto==undefined || $rootScope.fields.dcfrom=='' || $rootScope.fields.dcfrom==undefined)
				{
					console.log("validation");
					$('.valid_closedCases').each(function(){
						var cur = $(this);
						if ($.trim(cur.val()) == '' ||  $.trim(cur.val()) == 0 ){
							$rootScope.errorMessageshow=1;
							$rootScope.errorMessage=$(this).attr("msg");
							return false;
						}
					});
					
					
				}else{
					loader.show();
					$('.resetdata').each(function(){
						var cur = $(this);
						id = $(this).attr("id");
						$('#'+id).val("");
						$('#'+id).find('option:first').attr('selected', 'selected');		
					});
					var date_closedFrom = $filter('date')(new Date($rootScope.fields.dcfrom), 'yyyy-MM-dd');
					var date_closedTo = $filter('date')(new Date($rootScope.fields.dcto), 'yyyy-MM-dd');
					var closed_caseData = {judge:$rootScope.fields.cc_judge,agency:$rootScope.fields.cc_agency,casetype:$rootScope.fields.cc_casetype,county:$rootScope.fields.cc_county,dcfrom:date_closedFrom,dcto:date_closedTo,boxno:$rootScope.fields.cc_boxno};
					
					var mydata=JSON.stringify(closed_caseData);
					 mydata = Base64.encode(mydata);
					$scope.additionalSearchBlock=false;
					$scope.additionalSearchBlockFn(false); 
					$scope.flag = Base64.encode('3');
					
					$rootScope.fields.dcfrom = '';
					$rootScope.fields.dcto = '';
					$rootScope.fields.cc_judge = '';
					$rootScope.fields.cc_agency = '';
					$rootScope.fields.cc_casetype = '';
					$rootScope.fields.cc_county = '';
					$rootScope.fields.cc_boxno = '';
					
					loader.hide();
					$state.go("searchresult",{reqdt:mydata,flg:$scope.flag}); 
				}
		};
		
		$scope.open_closed = function(case_flag)
		{
			console.log(case_flag);
			if(case_flag=='C')
			{
				$scope.case_type = 'C';
			}else{
				$scope.case_type = 'O';
			}
		}
		
          /* 
			Name : Neha Agrawal
			Date created : 08-05-2017
			Description : Function is used to empty the docket number from home page after search.
		  */
		$rootScope.$on("$stateChangeSuccess", function(event, toState, toParams, fromState, fromParams) {
				// if(toState.name=='home'){
					$rootScope.docketSearch.docketno = '';
				// }
		});
		 
}]);
                    
  


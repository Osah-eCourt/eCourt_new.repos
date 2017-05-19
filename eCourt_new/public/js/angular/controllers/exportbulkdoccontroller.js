osahApp.controller('exportbulkdoccontroller',['$scope','$rootScope','$state','$stateParams','DocketFactory','DynamicFactory','PartyFactory','Base64','SearchFactory','$filter','loader','BulkdocFectory',function($scope,$rootScope,$state,$stateParams,DocketFactory,DynamicFactory,PartyFactory,Base64,SearchFactory,$filter,loader,BulkdocFectory){

	 //$scope.AgencyList = $rootScope.AgencyList_root; //Get Agency list
	
    $scope.contact_type_list = $rootScope.specialparty_root;
    $scope.partycount='';
     $scope.lengths='';
        //BulkdocFectory.getpartylist().success(function(response){
            //console.log(response);
             
            //console.log();
             $scope.lengths = $scope.contact_type_list.length;
             $scope.partycount = $scope.contact_type_list.length % 3;
            // console.log($scope.partycount);
       // });
    //$scope.partycount);
    //console.log($scope.contact_type_list);
	 $scope.agencyCode='0';
	 $scope.casetype='0';
	 $scope.documentlist='';	 
	 $scope.documentid='0';
	 $scope.nine_one_day='no';
     $scope.party_list='';
     $scope.mailer_list='';
     $scope.row1=0;
     $scope.row3=0;
     $scope.row2=0;
     if($scope.partycount==0){
        $scope.row1=parseInt($scope.lengths/3);
        $scope.row2=$scope.row1+$scope.row1;
        $scope.row3=$scope.row2+$scope.row2;
     }else{
        $scope.row1=parseInt($scope.lengths/3);
        $scope.row2=$scope.row1+$scope.row1;
        $scope.row3=$scope.row2+$scope.row2;
        $scope.row1= $scope.row1+1;
        if($scope.partycount==2)
            $scope.row2=$scope.row2+2
     }
      
        
     $scope.mailerList1="";
     $scope.mailerList2="";
     $scope.mailerList3="";
     $scope.flag_data=1;
     angular.forEach($scope.contact_type_list, function(value, key) {
                 
                /*if (value.typeofcontact == "Petitioner"){
                    $scope.Firstname = value.Firstname;
                    $scope.Lastname = value.Lastname;
                    $scope.petitioner_flg = '1';
                }if(value.typeofcontact == "Respondent"){
                         $scope.ResfirstName = value.Firstname;
                         $scope.ReslastName = value.Lastname;
                         $scope.respondent_flg = '1';
                    }*/
                   

                        
                    if($scope.flag_data <= $scope.row1){
                        $scope.mailerList1 = `${$scope.mailerList1} <div class='mailer-parties-row'>
                                <div class='select-check mailer-check'>
                                    <span>
                                        <input id='${value.id}_mlr' ng-model='_${value.id}_mlr' name='Field' type='checkbox' utype='mlr' class='field radio mailer' value='${value.partycontact}' tabindex='1' />
                                        <label class='' for='${value.id}_mlr' >
                                            <span class='choice__text'></span>
                                        </label>
                                    </span>
                                </div>
                                <div class='select-check parties-check'>
                                    <span>
                                        <input id='${value.id}_party' ng-model='_${value.id}_party' name='Field' type='checkbox' utype='party' class='field radio party' value='${value.partycontact}' tabindex='1' />
                                        <label class='' for='${value.id}_party' >
                                            <span class='choice__text'></span>
                                        </label>
                                    </span>
                                </div>
                                <div class='lable-text'>${value.partycontact}</div>
                            </div>`;
                    }

                  else if($scope.flag_data > $scope.row1 && $scope.flag_data <=$scope.row2){
                    $scope.mailerList2=`${$scope.mailerList2} <div class='mailer-parties-row'>
                                <div class='select-check mailer-check'>
                                    <span>
                                        <input id='${value.id}_mlr' ng-model='_${value.id}_mlr' name='Field' type='checkbox' utype='mlr' class='field radio mailer' value='${value.partycontact}' tabindex='1' />
                                        <label class='' for='${value.id}_mlr' >
                                            <span class='choice__text'></span>
                                        </label>
                                    </span>
                                </div>
                                <div class='select-check parties-check'>
                                    <span>
                                        <input id='${value.id}_party' ng-model='_${value.id}_party' name='Field' type='checkbox' utype='party' class='field radio party' value='${value.partycontact}' tabindex='1' />
                                        <label class='' for='${value.id}_party' >
                                            <span class='choice__text'></span>
                                        </label>
                                    </span>
                                </div>
                                <div class='lable-text'>${value.partycontact}</div>
                            </div>`;
                    }  

                    else if($scope.flag_data > $scope.row2 && $scope.flag_data <= $scope.lengths){
                        $scope.mailerList3=`${$scope.mailerList3} <div class='mailer-parties-row'>
                                <div class='select-check mailer-check'>
                                    <span>
                                        <input id='${value.id}_mlr' ng-model='_${value.id}_mlr' name='Field' type='checkbox' utype='mlr' class='field radio mailer' value='${value.partycontact}' tabindex='1' />
                                        <label class='' for='${value.id}_mlr' >
                                            <span class='choice__text'></span>
                                        </label>
                                    </span>
                                </div>
                                <div class='select-check parties-check'>
                                    <span>
                                        <input id='${value.id}_party' ng-model='_${value.id}_party' name='Field' type='checkbox' utype='party' class='field radio party' value='${value.partycontact}' tabindex='1' />
                                        <label class='' for='${value.id}_party' >
                                            <span class='choice__text'></span>
                                        </label>
                                    </span>
                                </div>
                                <div class='lable-text'>${value.partycontact}</div>
                            </div>`;
                    }      
                 
                 $scope.flag_data++;
                             
                });

	 $scope.setAll = function(){

	 	$scope.clearAllcheckbox();
	 	 switch ($scope.agencyCode) {
	 	 	/*case '0':
	 	 			alert("1. Selected Name:0 " );
	 	 		break;*/
	 	  	case '7':
             		//CSS EST
             		$scope.casetypeList=[{"caseid":606,"casename":'EST'}];
             		$scope.documentlist=[{"id":768,"documentname":'CSS-EST NOH.docx',"documenttype":'NOH'}];
             		$scope.casetype='606';  $scope.documentid='768';
             		//$("#representative_mlr").prop('checked', true);
                    $('input[type="checkbox"]').each(function(){
                    
                        if($(this).val()=='Respondent' && $(this).attr('utype')=='mlr'){
                            $(this).prop('checked', true);
                        }   
    
                    });

                break;
            case '199':
            		//DDS ALS
                $scope.casetypeList=[{"caseid":612,"casename":'ALS'}];
                $scope.documentlist=[{"id":81,"documentname":'ALS NOH.docx',"documenttype":'NOH'},{"id":82,"documentname":'ALS_91-day letter.docx',"documenttype":'Decision'}];
                $scope.casetype='612'; 
                	
                    $('input[type="checkbox"]').each(function(){
                     

                     if($scope.documentid==82){
                        
                         
                        if($(this).val()=='Petitioner' && $(this).attr('utype')=='mlr'){
                            $(this).prop('checked', true);
                        } 
                        if($(this).val()=='Petitioner Attorney' && $(this).attr('utype')=='mlr'){
                            $(this).prop('checked', true);
                        }
                    }else{
                        $scope.documentid='81'; 
                        if($(this).val()=='Officer' && $(this).attr('utype')=='mlr'){
                            $(this).prop('checked', true);
                        }
                        if($(this).val()=='Petitioner' && $(this).attr('utype')=='mlr'){
                            $(this).prop('checked', true);
                        } 
                        if($(this).val()=='Petitioner Attorney' && $(this).attr('utype')=='mlr'){
                            $(this).prop('checked', true);
                        }
                                
                    }
                        
                });
                    
                

                break;

            case '125':
            	//DPS ALS
                $scope.casetypeList=[{"caseid":605,"casename":'ALS'}];
                $scope.documentlist=[{"id":84,"documentname":'ALS NOH.docx',"documenttype":'NOH'}];
                $scope.casetype='605'; $scope.documentid='84';
	    		//$("#officer_mlr").prop('checked', true);
	            //$("#petitioner_mlr").prop('checked', true);
	           // $("#attorney_petitioner_mlr").prop('checked', true);
	            //$("#attorney_respondent_party").prop('checked', true);


                $('input[type="checkbox"]').each(function(){
                    var cur = $(this);
                 
                    if($(this).val()=='Officer' && $(this).attr('utype')=='mlr'){
                        $(this).prop('checked', true);
                    }
                    if($(this).val()=='Petitioner' && $(this).attr('utype')=='mlr'){
                        $(this).prop('checked', true);
                    }   

                    if($(this).val()=='Petitioner Attorney' && $(this).attr('utype')=='mlr'){
                        $(this).prop('checked', true);
                    }
                    if($(this).val()=='Respondent Attorney' && $(this).attr('utype')=='party'){
                        $(this).prop('checked', true);
                    }
                         
                });


                break;
            
            case '237':
            	//OIG EBTFSF
                $scope.casetypeList=[{"caseid":823,"casename":'EBTFSF'}];
                $scope.documentlist=[{"id":138,"documentname":'EBT_NOH.docx',"documenttype":'NOH'}];
                $scope.casetype='823';$scope.documentid='138';
                //$("#representative_mlr").prop('checked', true);
                //$("#investigator_mlr").prop('checked', true);
                
                $('input[type="checkbox"]').each(function(){
                    var cur = $(this);
                 
                    if($(this).val()=='Investigator' && $(this).attr('utype')=='mlr'){
                        $(this).prop('checked', true);
                    }
                    if($(this).val()=='Respondent' && $(this).attr('utype')=='mlr'){
                        $(this).prop('checked', true);
                    }   

                         
                });

                break;
               
            default:
        }

        if($scope.documentid==82){
            $scope.nine_one_day='yes';
        }else{
             $scope.nine_one_day='no';
        }

	 }

	 $('#docReceivedDate').datepicker({
        format: "mm-dd-yyyy",
        autoclose: true
	 });

	 $scope.clearAllcheckbox = function(){
	 	$('input[type="checkbox"]').prop('checked', false);
	 }

     $scope.generateBulkdoc = function(){
         $rootScope.errorMessageshow= 0;
        //$('input[type="checkbox"]').prop('checked', true);
        $scope.mailer_count=0;
        $scope.party_count=0; $scope.mailer_list='';$scope.party_list='';
        $('input[type="checkbox"]').each(function(){
            var cur = $(this);
            if($(this). prop("checked") == true){
             
                if($(this).hasClass('mailer')){
                  $scope.mailer_list=($scope.mailer_list=='')?$(this).val():$scope.mailer_list+"+"+$(this).val(); 
                    $scope.mailer_count++; 
                }
                if($(this).hasClass('party')){
                    $scope.party_list=($scope.party_list=='')?$(this).val():$scope.party_list +"+"+ $(this).val();
                     $scope.party_count++;
                }   

             //console.log($scope.party_list); 
            }               
        });
        if($scope.docReceivedDate==undefined||$scope.docReceivedDate==null||$scope.docReceivedDate==''){
            $rootScope.errorMessageshow=1;
            $rootScope.errorMessage="Enter date received";
            return false;
        }
        if($scope.agencyCode==null||$scope.agencyCode==0||$scope.agencyCode==undefined){
            $rootScope.errorMessageshow=1;
            $rootScope.errorMessage="Please select agency";
            return false;
        }
        if($scope.casetype==null||$scope.casetype==undefined||$scope.casetype==0){
            $rootScope.errorMessageshow=1;
            $rootScope.errorMessage="Please select casetype";
            return false;
        }
        if($scope.documentid==null||$scope.documentid==undefined||$scope.documentid==0){
            $rootScope.errorMessageshow=1;
            $rootScope.errorMessage="Please select document";
            return false;
        }
        if($scope.mailer_count==0){
            $rootScope.errorMessageshow=1;
            $rootScope.errorMessage="Please select one party from mailer list";
            return false;
        }
        //var bothparty=$scope.mailer_list+"+"+$scope.party_list;

        if($scope.agencyCode!=''&& $scope.agencyCode!=0 && $scope.casetype!='' && $scope.casetype!=0 && $scope.documentid!=0 && $scope.documentid!='' && $scope.docReceivedDate!=''){
            var requested_date='';
            requested_date = $scope.docReceivedDate.replace("-", "/"); requested_date = requested_date.replace("-", "/");
            requested_date= $filter('date')(new Date(requested_date), 'yyyy-MM-dd');
             loader.show();
            var bulkdoc_information="";
                bulkdoc_information={refagency:$scope.agencyCode,casetype:$scope.casetype,mailer_count:$scope.mailer_count,mailer_contact:$scope.mailer_list,party_contact:$scope.party_list,nintyoneday:$scope.nine_one_day,date_received:requested_date,documentid:$scope.documentid};
             BulkdocFectory.generatebulkdoc(bulkdoc_information).success(function(response){
                //console.log(response);
                if(response!=''){
                    loader.hide();
                }
                if(response==0){
                    $rootScope.errorMessageshow=1;
                    $rootScope.errorMessage="No records found try again.";
                }
             });   

        }else{
            $rootScope.errorMessageshow=1;
            $rootScope.errorMessage="Something went wrong. Please try again";
        }


     }

}]);
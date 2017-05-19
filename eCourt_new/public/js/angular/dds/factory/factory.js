/*
    *Name:  Neha A
    *Date Created : 26-09-2016
    *Function Description: The factory file send the http request like ajax and pass response
    */     



osahApp.factory('LoginFactory',function($http){
        
    factory = {};
    // factory.checkLogin when user click on the login this function will call
    // and check login credential and ldap authantucation
    //Amol S
    factory.checkLogin = function(uname,password) {
        return $http.post('Osahform/validatein', {username:uname,password:password});
    };
    
    // factory.isuserloged will call on state change and check the user is loggad or not
    //Amol S
    factory.isuserloged = function(uname){
        return $http.post('Osahform/isuserloged', {username:uname});
    };
    // factory.logout This function Will Destory the php session if sucess then return 1 
    //Amol S
    factory.logout = function(){
      return $http.post('Osahform/logout', {});  
    }
    
    
    return factory;
});


osahApp.factory('DynamicFactory',function($http){
        
    factory = {};
    
    factory.getdynamicdata = function(tableName,fieldName,fieldValue,conditionType) {
        return $http.post('Osahform/getdatadynamic', {tblNm:tableName,field_nm:fieldName,field_val:fieldValue,cond_type:conditionType});
        
    };

    //Crated By Amol s 17-11-2016
   factory.getdocketstauslist = function() {
       return $http.post('Osahform/getdocketstatuslist', {});
   };
    
   //Crated By Amol s 17-11-2016
   factory.getdocketHearingTimelist = function() {
       return $http.post('Osahform/gethearingtimelist', {});
   }; 
   
   //Crated By Affan s 29-11-2016
    factory.getcasetypegrouplist = function() {
       return $http.post('Osahform/getcasetypegrouplist', {});
   }; 
    
    return factory;
});




osahApp.factory('SearchFactory',function($http){
        
    factory = {};
    
    factory.searchbyvalue = function(table_name,condition) {
        return $http.post('Osahform/searchdatabywhere', {tableName:table_name,condition:condition});
        
    };

    factory.advancesearch = function(table_name,condition,addtionalCondition) {
		console.log(condition);
		console.log(addtionalCondition);
        return $http.post('Osahform/search-result', {tableName:table_name,condition:condition,addtional_condition:addtionalCondition});
	};

	factory.exportData = function(data) {
        return $http.post('Osahform/exportdata', {data:data});
        
    };
    return factory;
});
/* 
Name : Neha
 */
osahApp.factory('DocketFactory',function($http){
        
    factory = {};
    
    factory.searchbydocket = function(tableName,docketno) {
        return $http.post('dds/searchdocketinfo', {tableName:tableName,condition:docketno});
   };
 
     factory.upcomingcalendar = function() {
      return $http.post('Osahform/upcomingcalendar');
            
     };
     //Update the DocketGeneral information Amol S.
    factory.updateGeneralinfo = function(docketInfo,docketId) {
      return $http.post('Osahform/updatedocket',{docketInfo:docketInfo,dockeid:docketId});
            
     };
     
       //Get the hearing time from judgescountymaping table   Amol S.
    factory.getHearingtime = function(docketInfo,docketId) {
      return $http.post('Osahform/gethearingtiem',{});
    };

	factory.fetchrecords = function() {
		return $http.post('Osahform/fetchrecords');
        
    };


    //Amol s Get the autopopulate party details 
    factory.autopopulate = function(contact_type) {
		console.log(contact_type);
        return $http.post('Osahform/autopopulate',{contact_type:contact_type});
        
    }
	 factory.autopopulatedds = function(contact_type) {
		 console.log(contact_type);
        return $http.post('dds/autopopulatedds',{contact_type:contact_type});
        
    };

    //Amol s Get the selected user Details  
    factory.getuserdetailsdds = function(party_id) {
        return $http.post('dds/getddsinformation',{pid:party_id});
        
    };
	
	 factory.getuserdetails = function(party_id) {
        return $http.post('Osahform/getpartyinformation',{pid:party_id});
        
    };

    
	
	factory.deleteDocument = function(documentId) {
		return $http.post('Osahform/deletedocument', {document_id : documentId});
        
    };
	
	factory.dispositionType = function() {
		return $http.post('Osahform/getdispositiontype');
        
    };
	//update History
	 factory.updateHistory = function(data) {
      return $http.post('Osahform/add-history',data);
     };
	 
	  factory.getHistory = function(data) {
      return $http.post('Osahform/get-history',data);
     };

	factory.addDisposition = function(data) {
		return $http.post('Osahform/adddisposition' ,{dispositiondata : data});
    };
	
	factory.getDisposition = function() {
		return $http.post('Osahform/getDisposition');
    };
	// factory.checkDocketstatus = function(caseid) {
		// return $http.post('Osahform/checkdocketstatus' ,{caseid : caseid});
    // };
	factory.getDocumenttypes = function() {
		return $http.post('Osahform/getdocumenttypes');
        
    };
	factory.addDocument = function(data) {
		return $http.post('Osahform/adddocument',{documentdata : data});
        
    };
	
	factory.addDocket = function(data,location_id) {
		return $http.post('dds/adddocket',{docketdetails : data,location_id:location_id});
        
    };
	//Added by Neha
	factory.updateDdsdocket = function(data,docket_id) {
		return $http.post('dds/updatedocket',{docketdetails : data,docket_id:docket_id});
        
    };
	factory.reopenCase = function(data) {
		return $http.post('Osahform/reopencase',{casedata : data});
        
    };
    //added by FaisalK @Date 2017-01-03 @Description: confidential case type
    factory.getConfidentialCaseType = function(condition) {
        return $http.post('Osahform/get-confidential-case-type', {condition:condition});
    };
	
	factory.deleteDocket = function(docket_number) {
        return $http.post('dds/deletedocket', {docket_number:docket_number});
    };

    return factory;
});
/* 
 *Author - Neha
 *Created date - 5-10-2016
 *Description - Function is used to encode and decode the string.
 */
osahApp.factory('Base64', function () {
    // / jshint ignore:start /
        factory = {};
		var keyStr = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=';
 
    return {
        encode: function (input) {
            var output = "";
            var chr1, chr2, chr3 = "";
            var enc1, enc2, enc3, enc4 = "";
            var i = 0;
 
            do {
                chr1 = input.charCodeAt(i++);
                chr2 = input.charCodeAt(i++);
                chr3 = input.charCodeAt(i++);
 
                enc1 = chr1 >> 2;
                enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
                enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
                enc4 = chr3 & 63;
 
                if (isNaN(chr2)) {
                    enc3 = enc4 = 64;
                } else if (isNaN(chr3)) {
                    enc4 = 64;
                }
 
                output = output +
                    keyStr.charAt(enc1) +
                    keyStr.charAt(enc2) +
                    keyStr.charAt(enc3) +
                    keyStr.charAt(enc4);
                chr1 = chr2 = chr3 = "";
                enc1 = enc2 = enc3 = enc4 = "";
            } while (i < input.length);
 
            return output;
        },
 
        decode: function (input) {
            var output = "";
            var chr1, chr2, chr3 = "";
            var enc1, enc2, enc3, enc4 = "";
            var i = 0;
 
            // remove all characters that are not A-Z, a-z, 0-9, +, /, or =
            var base64test = /[^A-Za-z0-9\+\/\=]/g;
            if (base64test.exec(input)) {
                window.alert("There were invalid base64 characters in the input text.\n" +
                    "Valid base64 characters are A-Z, a-z, 0-9, '+', '/',and '='\n" +
                    "Expect errors in decoding.");
            }
            if(input!=null && input !=undefined){
                input = input.replace(/[^A-Za-z0-9\+\/\=]/g, '');
 
            do {
                enc1 = keyStr.indexOf(input.charAt(i++));
                enc2 = keyStr.indexOf(input.charAt(i++));
                enc3 = keyStr.indexOf(input.charAt(i++));
                enc4 = keyStr.indexOf(input.charAt(i++));
 
                chr1 = (enc1 << 2) | (enc2 >> 4);
                chr2 = ((enc2 & 15) << 4) | (enc3 >> 2);
                chr3 = ((enc3 & 3) << 6) | enc4;
 
                output = output + String.fromCharCode(chr1);
 
                if (enc3 != 64) {
                    output = output + String.fromCharCode(chr2);
                }
                if (enc4 != 64) {
                    output = output + String.fromCharCode(chr3);
                }
 
                chr1 = chr2 = chr3 = "";
                enc1 = enc2 = enc3 = enc4 = "";
 
            } while (i < input.length);
 
            return output;
        }
       } 
    };
    
});

/* 
 *Author - Amol 
 *Created date - 13-10-2016
 *Description - SessionFectory is used to get the session data and set the session data.
 */    
 
   
   osahApp.factory('SessionFectory',function($http){

      factory = {};

       return {
                set:function(key,value){
                    return sessionStorage.setItem(key,value);

                },
                get:function(key){
                    return sessionStorage.getItem(key);
                },
                destroy:function(key){
                    return sessionStorage.removeItem(key);
                },

      }
  });
  
  /* 
Name : Neha
 */
osahApp.factory('PartyFactory',function($http){
        
    factory = {};
    
    factory.addParty = function(data) {
        return $http.post('Osahform/addPartyDetails', {partydetails:data});
    };
	// update license number for pettitioner. if it is changes // affan
	 factory.updatelicensenumber = function(data) {
		 console.log(data);
        return $http.post('dds/updatelicensenumber', {partydetails:data});
    };
   
    factory.partyData = function(docket_num) {
        return $http.post('Osahform/getpartydetails', {docket_no:docket_num});
    };
   factory.deleteParty = function(contactId,MinorId,contactType,peopleId,attorneyId){
     return $http.post('Osahform/deleteparty', {contact_id : contactId , minor_id : MinorId , typeofcontact : contactType , people_id:peopleId,attorney_id : attorneyId});
   };
   factory.getParty = function(caseid,contactId,MinorId,contactType,peopleId,attorneyId){
     return $http.post('Osahform/getparty', {caseid : caseid , contact_id : contactId , minor_id : MinorId , typeofcontact : contactType , people_id:peopleId,attorney_id : attorneyId});
   };

	factory.editParty = function(data) {
        return $http.post('dds/editpartydetails', {editpartydetails:data});
    };
    
    return factory;
});




/*To show loader when data is loading @created by FaisalK 21-10-2016 start*/
osahApp.factory('loader',function($rootScope){
        
    loader = {};
    
    loader.show = function() {
		$rootScope.loading = true;
	};
    
    loader.hide = function() {
		$rootScope.loading = false;
	};
    
    return loader;
});
/*To show loader when data is loading @created by FaisalK 21-10-2016 end*/
/*notes factory @created by FaisalK 08-11-2016 start*/
osahApp.factory('NotesFactory',function($rootScope,$http){
        
    notes = {};
    
    notes.add = function(data) {
		return $http.post('Osahform/add-notes',data);
	};
	
	notes.deleteNotes = function(notesId){
	    return $http.post('Osahform/deletenotes', {notes_id : notesId});
   };
    notes.updateNotes = function(data) {
		return $http.post('Osahform/updatenotes',data);
	};
    
    return notes;
});
/*notes factory @created by FaisalK 08-11-2016 end*/


/*
Created On:30-11-2016
Auther : Amol S.
perppose: Upcoming Relected factor Function Will Come Here Only
*/
osahApp.factory('UpcomingCalendarFactory',function($rootScope,$http){
        
    factory = {};
    
    
    
    factory.UpcomingCalendardataUserwise = function(userName,usertypeField,condition,searchFlage){
        return $http.post('Osahform/getupcomingcalendardata', {username : userName,tableField:usertypeField,searchFlage:searchFlage,condition:condition});
   };

   factory.UpcomingCalendarjudgelist = function(userName,usertypeField,condition,searchFlage){
        return $http.post('Osahform/getupcomingcalendarjudgeslist', {username : userName,tableField:usertypeField,searchFlage:searchFlage,condition:condition});
   };
    
    return factory;
});

/*calendarManagement factory @created by FaisalK 2016-11-29 start*/
osahApp.factory('calendarManagementFactory',function($rootScope,$http){
        
    calendarManagement = {};
	
    calendarManagement.get = function(data) {
		return $http.post('Osahform/calendar-management',data);
	}; 
	
	calendarManagement.insertcalendardata = function(data) {
		return $http.post('Osahform/insertcalendardata', data);
	};
	calendarManagement.update = function(data) {
		return $http.post('Osahform/update-calendar',data);
	};
	calendarManagement.delete = function(data) {
		return $http.post('Osahform/delete-calendar',data);
	}; 
	calendarManagement.getDates = function(calendarId,viewDates) {
		return $http.post('Osahform/get-calendar-dates', {Calendarid:calendarId,view_dates:viewDates});
	};
	calendarManagement.deleteDate = function(data) {
		return $http.post('Osahform/delete-calendar-dates',data);
	}; 
	calendarManagement.updateDate = function(data) {
		return $http.post('Osahform/update-calendar-dates',data);
	}; 
    return calendarManagement;
});
/*calendarManagement factory @created by FaisalK 2016-11-29 end*/

/*
  Created On:19-12-2016
  Auther : Amol S.
  perppose: Document Template Relected factor Function Will Come Here Only
*/
osahApp.factory('DocumentTemplateFactory',function($rootScope,$http){
        
    factory = {};
    
   
    factory.documet_templet_list = function(casetype,agency){
        return $http.post('Osahform/documenttemplatelist', {casetype:casetype,agency:agency});
   };

   //on click Template attchdocumet function will call this
  factory.documet_templet_Attch = function(docketNo,agency,casetype,partytypes,documet_type,document_id,flage,desc,document_template_id){
        return $http.post('Osahform/attachdocsfunc', {docketNo:docketNo,agency:agency,casetype:casetype,partytypes:partytypes,documet_type:documet_type,document_id:document_id,pdf_doc_flage:flage,description:desc,doc_stable_id:document_template_id}); 
        
        /*return $http.post('Osahform/attachdocsfunc', {}); */

        
   };
    
    
    return factory;
});

 /* 
	Name : Neha
	Created Date : 16-12-2016
*/
osahApp.factory('FileFactory',function($http){
        
    factory = {};
    
    factory.addFile = function(data) {
        return $http.post('Osahform/addfile', {file_data:data});
   };
   factory.getFile = function(docno,doc_id) {
        return $http.post('Osahform/getfile', {docket_number:docno,doc_id:doc_id});
   };
    factory.updateFile = function(file_info,data) {
        return $http.post('Osahform/updatefile', {file_info:file_info,data:data});
   };
    
    return factory;
});
/* 
	Name 			: Faisal Khan
	Created Date 	: 2016-12-29
*/
osahApp.factory('DateFormat',function($filter){
        
    factory = {};
    /* convert from mm-dd-yyyy to yyyy-mm-dd */
    factory.yyyymmdd = function(mmddyyyy) {
		return $filter('date')(new Date(mmddyyyy.replace(/-/g, "/")), 'yyyy-MM-dd');
   };
    
    return factory;
});

/* factory for 1205 form handling
 created by AFFAN.	
*/
osahApp.factory('Form1205Factory',function($http){
        
    factory = {};
     factory.searchby1205form = function(tableName,docketno) {
        return $http.post('dds/search1205info', {tableName:tableName,condition:docketno});
     };
	
	
	
    factory.getdynamicdata = function(tableName) {
        return $http.post('dds/getofficerdata', {tblNm:tableName});
        
    };
	
	factory.getstatelist = function(tableName) {
		
        return $http.post('dds/getstatelist', {tblNm:tableName});
        
    };
	factory.getcountySelected = function(tableName,docketno) {
		console.log("zsc");
		console.log(tableName);
		console.log(docketno);
        return $http.post('dds/getselectedcounty', {tableName:tableName,condition:docketno});
        
    };

   factory.add1205Details = function(data) {
        return $http.post('dds/addPartyDetails', {partydetails:data});
   };
    factory.addAttorneyDetailsForDps = function(tableName,data,docketno,caseid) {
        return $http.post('dds/addattorneyrespondent', {tableName:tableName,partydetails:data,condition:docketno,caseid:caseid} );
   };
   
    factory.getattorney = function(tableName) {
        return $http.post('dds/getattorney', {tblNm:tableName});
        
    };
   
  
   
    factory.updateddstodps = function(tableName,docketDPSDetails,docketno) {
        return $http.post('dds/updateddstodps', {tableName:tableName,docketDPSDetails:docketDPSDetails,condition:docketno});
   };
   
    return factory;
});

/* added by Faisal Khan @Description: page-leave-warning-popup @Created on  : 2017-01-30*/
osahApp.factory('PageLeaveWarning',function($rootScope,$state){
    factory = {};
	$rootScope.pageLeaveWarning={};
	factory.proceedAhead=()=>{
		$rootScope.pageLeaveWarning.val = 0;
		console.log($rootScope.pageLeaveWarning.val);
		$('#page-leave-warning-popup').modal('hide');
		$state.go($rootScope.pageLeaveWarning.toState,$rootScope.pageLeaveWarning.toParams,{reload: true} );
		$('.modal-backdrop').remove();
	};
	factory.check=(event, toState, toParams)=>{
		if ($rootScope.pageLeaveWarning.val == 1) {
			console.log($rootScope.pageLeaveWarning.val);
			$rootScope.pageLeaveWarning.toState = toState;
			$rootScope.pageLeaveWarning.toParams = toParams;
			event.preventDefault();
			loader.hide();
			$('#page-leave-warning-popup').modal('show');
		}
	};
	factory.watch = function($scope,obj) {
		$scope.$watchGroup(obj, function(newValue, oldValue) {
			if($rootScope.pageLeaveWarning.watchCount>0){
				$rootScope.pageLeaveWarning.val = 1;
			}
			$rootScope.pageLeaveWarning.watchCount++;
		});
	};
	factory.reset=()=>{
		$rootScope.pageLeaveWarning.val=0;
		$rootScope.pageLeaveWarning.watchCount=0;
	};
    
    return factory;
});


/* added by Affan Shaikh @Description:Tem Permits Factory @Created on  : 201704-21*/
osahApp.factory('PrintPermitsFactory',function($http){
    factory = {};
	
	 factory.printpermits = function(tableName,clerkname) {
        return $http.post('dds/printpermits', {tblNm:tableName,clerkName:clerkname});        
     };
	 
	  factory.printsinglepermits  = function(tableName,license_number) {
        return $http.post('dds/printpermits', {tblNm:tableName,license_number:license_number});        
     };
	
    
    return factory;
});
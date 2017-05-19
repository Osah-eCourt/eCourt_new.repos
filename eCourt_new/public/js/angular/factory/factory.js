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


   //Crated By Amol s 17-03-2017
   factory.getpartylist = function(){
        return $http.post('Osahform/partylist', {});
  };
    
    return factory;
});




osahApp.factory('SearchFactory',function($http){
        
    factory = {};
    
    factory.searchbyvalue = function(table_name,condition) {
        return $http.post('Osahform/searchdatabywhere', {tableName:table_name,condition:condition});
        
    };

    factory.advancesearch = function(table_name,condition,addtionalCondition) {
        return $http.post('Osahform/search-result', {tableName:table_name,condition:condition,addtional_condition:addtionalCondition});
	};

	factory.exportData = function(data) {
        return $http.post('Osahform/exportdata', {condition:data});
        
    };
	
	factory.printResult = function(data) {
        return $http.post('Osahform/printresult');
        
    };
	factory.closecasesearch = function(data,addtionalCondition) {
        return $http.post('Osahform/closecasesearch', {condition : data,addtional_condition:addtionalCondition});
    };
    return factory;
});
/* 
Name : Neha
 */
osahApp.factory('DocketFactory',function($http){
        
    factory = {};
    
    factory.searchbydocket = function(tableName,docketno) {
        return $http.post('Osahform/searchdocketinfo', {tableName:tableName,condition:docketno});
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
        
    };

    //Amol s Get the selected user Details  
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
		return $http.post('Osahform/adddocket',{docketdetails : data,location_id:location_id});
        
    };
	factory.reopenCase = function(data) {
		return $http.post('Osahform/reopencase',{casedata : data});
        
    };
    //added by FaisalK @Date 2017-01-03 @Description: confidential case type
    factory.getConfidentialCaseType = function(condition) {
        return $http.post('Osahform/get-confidential-case-type', {condition:condition});
    };
    //added by FaisalK @Date 2017-01-30 @Description: hearingDateAutomation
    factory.hearingDateAutomation = function(condition) {
        return $http.post('Osahform/hearing-date-automation', {condition:condition});
    };
    //added by FaisalK @Date 2017-03-29 @Description: hearingDateManual
    factory.hearingDateManual = function(condition) {
        return $http.post('Osahform/hearing-date-manual', {condition:condition});
    };
	
	factory.printOsahform = function() {
		console.log('printosahform');
        return $http.post('Osahform/printosahform');
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
        return $http.post('Osahform/editpartydetails', {editpartydetails:data});
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
	/*validateCalendar factory @created by FaisalK 2017-03-16 start*/
	calendarManagement.validateCalendar = function(data) {
		return $http.post('Osahform/validate-calendar',data);
	}; 
	/*validateCalendar factory @created by FaisalK 2017-03-16 end*/
	calendarManagement.getDates = function(calendarId,viewDates) {
		return $http.post('Osahform/get-calendar-dates', {Calendarid:calendarId,view_dates:viewDates});
	};
	calendarManagement.deleteDate = function(data) {
		return $http.post('Osahform/delete-calendar-dates',data);
	}; 
	calendarManagement.updateDate = function(data) {
		return $http.post('Osahform/update-calendar-dates',data);
	}; 
	calendarManagement.updateHistory = function(calendarid,data) {
		return $http.post('Osahform/update-calendar-history',{Calendarid:calendarid,data:data});
	}; 
	calendarManagement.getCalendarhistory = function() {
		return $http.post('Osahform/getcalendarhistory');
	}; 
	
	calendarManagement.getupdatedates = function(oldvalue,newvalue) {
		return $http.post('Osahform/getupdatedates',{oldvalue:oldvalue,newvalue:newvalue});
	}; 
	
    return calendarManagement;
});

/* 
	Name : Neha Agrawal
	Description : PrintOsahForm Factory
	Created Date : 21-04-2017
 */
osahApp.factory('DDSForm1Factory',function($rootScope,$http){
	factory = {};
		factory.printOsahform1 = function(data) {
			return $http.post('Osahform/printosahform',{data:data});
		}; 
	
    return factory;	
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
   /*Get All Document List*/
   factory.documet_templet_list_all = function(){
        return $http.post('Osahform/documenttemplatelistall', {});
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

/* added by Faisal Khan @Description: page-leave-warning-popup @Created on  : 2017-01-30*/
osahApp.factory('PageLeaveWarning',function($rootScope,$state){
    factory = {};
	$rootScope.pageLeaveWarning={};
	factory.proceedAhead=function(){
		$rootScope.pageLeaveWarning.val = 0;
		$('#page-leave-warning-popup').modal('hide');
		$state.go($rootScope.pageLeaveWarning.toState,$rootScope.pageLeaveWarning.toParams,{reload: true});
		$('.modal-backdrop').remove();
	};
	factory.check=function(event, toState, toParams){
		if ($rootScope.pageLeaveWarning.val == 1) {
			// console.log(toState);
			$rootScope.pageLeaveWarning.toState = toState;
			$rootScope.pageLeaveWarning.toParams = toParams;
			event.preventDefault();
			loader.hide();
			$('#page-leave-warning-popup').modal('show');
		}
	};
	factory.watch = function($scope,obj,skipWatch=0) {
		$scope.$watchGroup(obj, function(newValue, oldValue) {
			if($rootScope.pageLeaveWarning.watchCount>skipWatch){
				$rootScope.pageLeaveWarning.val = 1;
			}
			$rootScope.pageLeaveWarning.watchCount++;
		});
	};
	factory.reset=function(){
		$rootScope.pageLeaveWarning.val=0;
		$rootScope.pageLeaveWarning.watchCount=0;
	};
    
    return factory;
});

/* 
 *Author - Amol 
 *Created date - 28-02-2017
 *Description - BulkdocFectory is used to clerk should generate the bulk documents .
 */    
 
   
   osahApp.factory('BulkdocFectory',function($http){

      factory = {};

      factory.generatebulkdoc = function(bulkdocinfo){
        return $http.post('Osahform/exportdocsfunc', {docketinfo:bulkdocinfo});
      };
      
      

      return factory;
  });

   /* 
 *Author - Amol 
 *Created date - 08-03-2017
 Modifyed Date-
 *Description - PrintlabelFectory is used to should print the Lable .
  
 */    
 
   
   osahApp.factory('PrintlabelFectory',function($http){

      factory = {};

      factory.getclerkList = function(){
        return $http.post('Osahform/getclerklist', {});
      };
      factory.generatelabel = function(labelinfo){
        return $http.post('Osahform/printlabelsdocket', {printlbl_info:labelinfo});
      };
      return factory;
  });
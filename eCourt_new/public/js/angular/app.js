/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor. 
 */

//App .js
var osahApp = angular.module('osah',['ui.router','oc.lazyLoad','thatisuday.dropzone']);

osahApp.config(['$stateProvider','$urlRouterProvider',function($stateProvider,$urlRouterProvider){
    $urlRouterProvider.otherwise('/login');
	
	$stateProvider
      .state('login', {
            url: '/login',
            data: {pageTitle: 'login'},
            templateUrl: 'Osahform/templateload?name=login',
			cache:false,
            controller: 'logincontroller',
                resolve: {
                    deps: ['$ocLazyLoad', function($ocLazyLoad) {
                        return $ocLazyLoad.load({ 
                            name: 'osah',
                            files: ['/js/angular/controllers/logincontroller.js']                    
                        }); 
                    }]
                }  
      })
	
      .state('home', {
            url: '/home',
            data: {pageTitle: 'home'},
            templateUrl: 'Osahform/templateload?name=home',
			cache:false,
            controller: 'homecontroller',
                resolve: {
                    deps: ['$ocLazyLoad', function($ocLazyLoad) {
                        return $ocLazyLoad.load({ 
                            name: 'osah',
                            files: ['/js/angular/controllers/homecontroller.js']                    
                        }); 
                    }]
                }  
      })  
	  
       .state('searchresult', {
            url: '/searchresult/reqdt/:reqdt/flg/:flg',
            data: {pageTitle: 'searchresult'},
            templateUrl: 'Osahform/templateload?name=searchresult',
			cache:false,
            controller: 'searchresultcontroller',
                resolve: {
                    deps: ['$ocLazyLoad', function($ocLazyLoad) {
                        return $ocLazyLoad.load({ 
                            name: 'osah',
                            files: ['/js/angular/controllers/searchresultcontroller.js']                    
                        }); 
                    }]
                }  
      }) 
   
     .state('docket', {
            url: '/docket/reqdt/:reqdt',
            data: {pageTitle: 'docket'},
            templateUrl: 'Osahform/templateload?name=docket',
			cache:false,
            controller: 'docketcontroller',
                resolve: {
                    deps: ['$ocLazyLoad', function($ocLazyLoad) {
                        return $ocLazyLoad.load({ 
                            name: 'osah',
                            files: ['/js/angular/controllers/docketcontroller.js']                    
                        }); 
                    }]
                }  
      })

     .state('newdocket', {
            url: '/newdocket',
            data: {pageTitle: 'newdocket'},
            templateUrl: 'Osahform/templateload?name=newdocket',
			cache:false,
            controller: 'new-docketcontroller',
                resolve: {
                    deps: ['$ocLazyLoad', function($ocLazyLoad) {
                        return $ocLazyLoad.load({ 
                            name: 'osah',
                            files: ['/js/angular/controllers/new-docketcontroller.js']                    
                        }); 
                    }]
                }  
      })

      .state('printlabel', {
            url: '/printlabel',
            data: {pageTitle: 'printlabel'},
            templateUrl: 'Osahform/templateload?name=printlabel',
			cache:false,
            controller: 'printlabelcontroller',
                resolve: {
                    deps: ['$ocLazyLoad', function($ocLazyLoad) {
                        return $ocLazyLoad.load({ 
                            name: 'osah',
                            files: ['/js/angular/controllers/printlabelcontroller.js']                    
                        }); 
                    }]
                }  
      })

      .state('exportbulkdoc', {
            url: '/exportbulkdoc',
            data: {pageTitle: 'printlabel'},
            templateUrl: 'Osahform/templateload?name=exportbulkdoc',
			cache:false,
            controller: 'exportbulkdoccontroller',
                resolve: {
                    deps: ['$ocLazyLoad', function($ocLazyLoad) {
                        return $ocLazyLoad.load({ 
                            name: 'osah',
                            files: ['/js/angular/controllers/exportbulkdoccontroller.js']                    
                        }); 
                    }]
                }  
      })


.state('dochistory', {
            url: '/dochistory/reqdt/:reqdt',
            data: {pageTitle: 'printlabel'},
            templateUrl: 'Osahform/templateload?name=dochistory',
			cache:false,
            controller: 'dochistorycontroller',
                resolve: {
                    deps: ['$ocLazyLoad', function($ocLazyLoad) {
                        return $ocLazyLoad.load({ 
                            name: 'osah',
                            files: ['/js/angular/controllers/dochistorycontroller.js']                    
                        }); 
                    }]
                }  
      })


.state('docnotes', {
    url: '/docnotes/reqdt/:reqdt',
    data: {pageTitle: 'printlabel'},
    templateUrl: 'Osahform/templateload?name=docnotes',
	cache:false,
    controller: 'docnotescontroller',
        resolve: {
            deps: ['$ocLazyLoad', function($ocLazyLoad) {
                return $ocLazyLoad.load({ 
                    name: 'osah',
                    files: ['/js/angular/controllers/docnotescontroller.js']                    
                }); 
            }]
        }  
})

.state('ddsimport', {
    url: '/ddsimport',
    data: {pageTitle: 'ddsimport'},
    templateUrl: 'Osahform/templateload?name=ddsimport',
	cache:false,
    controller: 'ddsimportcontroller',
        resolve: {
            deps: ['$ocLazyLoad', function($ocLazyLoad) {
                return $ocLazyLoad.load({ 
                    name: 'osah',
                    files: ['/js/angular/controllers/ddsimportcontroller.js']                    
                }); 
            }]
        }  
})

.state('upcalendar', {
    url: '/upcalendar',
    data: {pageTitle: 'upcalendar'},
    templateUrl: 'Osahform/templateload?name=upcalendar',
	cache:false,
    controller: 'upcomingcalendarcontroller',
        resolve: {
            deps: ['$ocLazyLoad', function($ocLazyLoad) {
                return $ocLazyLoad.load({ 
                    name: 'osah',
                    files: ['/js/angular/controllers/upcomingcalendarcontroller.js']                    
                }); 
            }]
        }  
})

.state('ddsreport', {
    url: '/ddsreport',
    data: {pageTitle: 'ddsreport'},
    templateUrl: 'Osahform/templateload?name=ddsreport',
	cache:false,
    controller: 'ddsreportcontroller',
        resolve: {
            deps: ['$ocLazyLoad', function($ocLazyLoad) {
                return $ocLazyLoad.load({ 
                    name: 'osah',
                    files: ['/js/angular/controllers/ddsreportcontroller.js']                    
                }); 
            }]
        }  

})		

.state('calendar-management', {
    url: '/calendar-management',
    data: {pageTitle: 'Calendar Management'},
    templateUrl: 'Osahform/templateload?name=calendar-management',
	cache:false,
    controller: 'calendarManagementController',
        resolve: {
            deps: ['$ocLazyLoad', function($ocLazyLoad) {
                return $ocLazyLoad.load({ 
                    name: 'osah',
                    files: ['/js/angular/controllers/calendar-management-controller.js']                    
                }); 
            }]
        }  
})

.state('calendarhistory', {
            url: '/calendarhistory',
            data: {pageTitle: 'printlabel'},
            templateUrl: 'Osahform/templateload?name=calendarhistory',
            controller: 'calendarhistorycontroller',
                resolve: {
                    deps: ['$ocLazyLoad', function($ocLazyLoad) {
                        return $ocLazyLoad.load({ 
                            name: 'osah',
                            files: ['/js/angular/controllers/calendarhistorycontroller.js']                    
                        }); 
                    }]
                }  
      })
		

}]);

osahApp.run(['$state','$rootScope','Base64','LoginFactory','SessionFectory','PageLeaveWarning',function($state,$rootScope,Base64,LoginFactory,SessionFectory,PageLeaveWarning){
   $rootScope.$state = $state;
   
    $rootScope.countyList_root=''; $rootScope.AgencyList_root='';  $rootScope.casetypesList_root='';  $rootScope.judgeList_root='';
    $rootScope.Judge_AssistantList_root='';  $rootScope.courtlocationList_root=''; $rootScope.statusList_root='';  $rootScope.contactList_root='';
    $rootScope.hearingtimeList_root=''; $rootScope.specialparty_root='';
    $rootScope.errorMessage='';
    $rootScope.errorMessageshow=0;
   var userName='';
   var loginflage='';
  var routSeeeionpages =['login'];
     
  /* added by Faisal Khan   @Description: page-leave-warning-popup @Created on  : 2017-01-30*/
    $rootScope.pageLeaveWarning.proceedAhead=PageLeaveWarning.proceedAhead;
    /*end added by Faisal Khan  @Description: page-leave-warning-popup @Created on  : 2017-01-30*/

     $rootScope.$on("$stateChangeStart", function(event, toState, toParams, fromState, fromParams) {
            
			console.log("change");
			$rootScope.errorMessageshow=0;
			loader.show();// display the loader whenever the route changes(the content part started loading) added by FaisalK 21-10-2016
         /* console.log(SessionFectory.get('user_type'));
              return false; */
//			$state.set_flag = "0" ; 
//			$state.alert_name='';` 
//			$state.back_page_name='';
                    userName = Base64.decode(SessionFectory.get('user')); 

                    loginflage = LoginFactory.isuserloged(userName);
                    
               loginflage.then(function(response) {
                if(routSeeeionpages.indexOf(toState.name)== -1 && response.data == '2' ){
                    if(toState.name!='login'){
                        $state.go('login');
                        event.preventDefault();
                    }
                }
            });
             /* added by Faisal Khan    @Description: page-leave-warning-popup @Created on  : 2017-01-30*/
                PageLeaveWarning.check(event, toState, toParams);
        /* end added by Faisal Khan @Description: page-leave-warning-popup @Created on  : 2017-01-30*/ 
    
         });
     

	$rootScope.$on('$stateChangeSuccess', function() {
		// hide the loader on route change success(after the content loaded)
		loader.hide();

        /* added by Faisal Khan @Description: page-leave-warning-popup @Created on  : 2017-01-30*/
          PageLeaveWarning.reset();
        /* end added by Faisal Khan @Description: page-leave-warning-popup @Created on  : 2017-01-30*/
	});
       
}]);
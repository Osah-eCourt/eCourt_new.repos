/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor. 
 */

//App .js
var osahApp = angular.module('osah',['ui.router','oc.lazyLoad','thatisuday.dropzone','ui.bootstrap','ui.bootstrap.datetimepicker']);

osahApp.config(['$stateProvider','$urlRouterProvider',function($stateProvider,$urlRouterProvider){
    $urlRouterProvider.otherwise('/login');
	
	$stateProvider
      .state('login', {
            url: '/login',
            data: {pageTitle: 'login'},
            templateUrl: 'dds/templateload?name=login',
			cache:false,
            controller: 'logincontroller',
                resolve: {
                    deps: ['$ocLazyLoad', function($ocLazyLoad) {
                        return $ocLazyLoad.load({ 
                            name: 'osah',
                            files: ['/js/angular/dds/controllers/logincontroller.js']                    
                        }); 
                    }]
                }  
      })
	
      .state('home', {
            url: '/home',
            data: {pageTitle: 'home'},
            templateUrl: 'dds/templateload?name=home',
			cache:false,
            controller: 'homecontroller',
                resolve: {
                    deps: ['$ocLazyLoad', function($ocLazyLoad) {
                        return $ocLazyLoad.load({ 
                            name: 'osah',
                            files: ['/js/angular/dds/controllers/homecontroller.js']                    
                        }); 
                    }]
                }  
      })  
	  
       .state('searchresult', {
            url: '/searchresult/reqdt/:reqdt/flg/:flg',
            data: {pageTitle: 'searchresult'},
            templateUrl: 'dds/templateload?name=searchresult',
			cache:false,
            controller: 'searchresultcontroller',
                resolve: {
                    deps: ['$ocLazyLoad', function($ocLazyLoad) {
                        return $ocLazyLoad.load({ 
                            name: 'osah',
                            files: ['/js/angular/dds/controllers/searchresultcontroller.js']                    
                        }); 
                    }]
                }  
      }) 
   
     .state('docket', {
            url: '/docket/reqdt/:reqdt',
            data: {pageTitle: 'docket'},
            templateUrl: 'dds/templateload?name=docket',
			cache:false,
            controller: 'docketcontroller',
                resolve: {
                    deps: ['$ocLazyLoad', function($ocLazyLoad) {
                        return $ocLazyLoad.load({ 
                            name: 'osah',
                            files: ['/js/angular/dds/controllers/docketcontroller.js']                    
                        }); 
                    }]
                }  
      })

     .state('newdocket', {
            url: '/newdocket',
            data: {pageTitle: 'newdocket'},
            templateUrl: 'dds/templateload?name=newdocket',
            controller: 'new-docketcontroller',
                resolve: {
                    deps: ['$ocLazyLoad', function($ocLazyLoad) {
                        return $ocLazyLoad.load({ 
                            name: 'osah',
                            files: ['/js/angular/dds/controllers/new-docketcontroller.js']                    
                        }); 
                    }]
                }  
      })




.state('dochistory', {
            url: '/dochistory/reqdt/:reqdt',
            data: {pageTitle: 'printlabel'},
            templateUrl: 'dds/templateload?name=dochistory',
            controller: 'dochistorycontroller',
                resolve: {
                    deps: ['$ocLazyLoad', function($ocLazyLoad) {
                        return $ocLazyLoad.load({ 
                            name: 'osah',
                            files: ['/js/angular/dds/controllers/dochistorycontroller.js']                    
                        }); 
                    }]
                }  
      })


.state('docnotes', {
    url: '/docnotes/reqdt/:reqdt',
    data: {pageTitle: 'printlabel'},
    templateUrl: 'dds/templateload?name=docnotes',
    controller: 'docnotescontroller',
        resolve: {
            deps: ['$ocLazyLoad', function($ocLazyLoad) {
                return $ocLazyLoad.load({ 
                    name: 'osah',
                    files: ['/js/angular/dds/controllers/docnotescontroller.js']                    
                }); 
            }]
        }  
})

.state('form1205', {
     url: '/form1205/reqdt/:reqdt',
    data: {pageTitle: 'Form 1205'},
    templateUrl: 'dds/templateload?name=form1205',
    controller: 'form1205Controller',
        resolve: {
            deps: ['$ocLazyLoad', function($ocLazyLoad) {
                return $ocLazyLoad.load({ 
                    name: 'osah',
                    files: ['/js/angular/dds/controllers/form1205-controller.js']                    
                }); 
            }]
        }  
})

.state('temporarypermits', {
    url: '/temporarypermits',
    data: {pageTitle: 'Temporary Permits'},
    templateUrl: 'dds/templateload?name=temporarypermits',
    controller: 'temporarypermitscontroller',
        resolve: {
            deps: ['$ocLazyLoad', function($ocLazyLoad) {
                return $ocLazyLoad.load({ 
                    name: 'osah',
                    files: ['/js/angular/dds/controllers/temporarypermitscontroller.js']                    
                }); 
            }]
        }  
})		

}]);

osahApp.run(['$state','$rootScope','Base64','LoginFactory','SessionFectory','PageLeaveWarning',function($state,$rootScope,Base64,LoginFactory,SessionFectory,PageLeaveWarning){
   $rootScope.$state = $state;
   
    $rootScope.countyList_root=''; $rootScope.AgencyList_root='';  $rootScope.casetypesList_root='';  $rootScope.judgeList_root='';
    $rootScope.Judge_AssistantList_root='';  $rootScope.courtlocationList_root=''; $rootScope.statusList_root='';  $rootScope.contactList_root='';
    $rootScope.hearingtimeList_root='';
    $rootScope.errorMessage='';
    $rootScope.errorMessageshow=0;
   var userName='';
   var loginflage='';
     var routSeeeionpages =['login'];
     
	 /* added by Faisal Khan   @Description: page-leave-warning-popup @Created on  : 2017-01-30*/
    $rootScope.pageLeaveWarning.proceedAhead=PageLeaveWarning.proceedAhead;
    /*end added by Faisal Khan  @Description: page-leave-warning-popup @Created on  : 2017-01-30*/
	 
     $rootScope.$on("$stateChangeStart", function(event, toState, toParams, fromState, fromParams) {
            
			$rootScope.errorMessageshow=0;
			loader.show();// display the loader whenever the route changes(the content part started loading) added by FaisalK 21-10-2016
         /* console.log(SessionFectory.get('user_type'));
              return false; */
//			$state.set_flag = "0" ; 
//			$state.alert_name='';
//			$state.back_page_name='';
                    userName = Base64.decode(SessionFectory.get('dds_user')); 
					$rootScope.username = userName;
                    loginflage = LoginFactory.isuserloged(userName);
                    console.log(loginflage);
                    console.log(userName);
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
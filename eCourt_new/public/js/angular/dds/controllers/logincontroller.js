 //Login controller
  osahApp.controller('logincontroller',['$scope','$state','LoginFactory','SessionFectory','Base64',function($scope,$state,LoginFactory,SessionFectory,Base64){
         $scope.validation_message = '';
//    console.log($state.current.name);
// console.log($scope.test);
 /* 
 Name : Neha
 Date Created : 26-09-2016
 */
 //console.log('DDS routing'); return false;
 $scope.login = function(username,password)
 {
	 console.log("aasdf");
     //Destory the storage session before login
     SessionFectory.destroy('user');
    
   if(!username && !password){
    $scope.validation_message = "Please enter username and password!";
   }
   else if(!username){
    $scope.validation_message = "Please enter username!";
   }
   else if(!password){
    $scope.validation_message = "Please enter password!";
   }
   else{
	  
        LoginFactory.checkLogin($scope.username,$scope.password).success(function(response){
		console.log(response);
		console.log(response[0].user_type);
            $scope.validation_message =='';
            if(response[0].user_type == 'dds_clerk'){
                SessionFectory.set('dds_user',Base64.encode($scope.username));
                SessionFectory.set('dds_user_type',Base64.encode(response[0].user_type));
                SessionFectory.set('dds_user_id',Base64.encode(response[0].user_id));
                SessionFectory.set('dds_FirstName',Base64.encode(response[0].FirstName));
                SessionFectory.set('dds_LastName',Base64.encode(response[0].LastName));
               // SessionFectory.set('MiddleInitial',Base64.encode(response[0].MiddleInitial));
                $state.go("home");
            }else{
                $scope.validation_message = "Please enter valid username and password!";
            }
            
            
        });
   }
   
 };
             
}]);
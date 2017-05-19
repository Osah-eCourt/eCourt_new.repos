 //Login controller
  osahApp.controller('logincontroller',['$scope','$state','LoginFactory','SessionFectory','Base64',function($scope,$state,LoginFactory,SessionFectory,Base64){
         $scope.validation_message = '';
//    console.log($state.current.name);
// console.log($scope.test);
 /* 
 Name : Neha
 Date Created : 26-09-2016
 */
 $scope.login = function(username,password)
 {
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
            
            $scope.validation_message =='';
            if(response !='false'){
                SessionFectory.set('user',Base64.encode($scope.username));
                SessionFectory.set('user_type',Base64.encode(response[0].user_type));
                SessionFectory.set('user_id',Base64.encode(response[0].user_id));
                SessionFectory.set('FirstName',Base64.encode(response[0].FirstName));
                SessionFectory.set('LastName',Base64.encode(response[0].LastName));
               // SessionFectory.set('MiddleInitial',Base64.encode(response[0].MiddleInitial));
                $state.go("home");
            }else{
                $scope.validation_message = "Please enter valid username and password!";
            }
            
            
        });
   }
   
 };
             
}]);
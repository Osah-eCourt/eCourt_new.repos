             //Search Result controller
/* @FaisalK @edited on 16-11-2016 @description search result pagination*/
osahApp.controller('searchresultcontroller',['$scope','$rootScope','$state','$stateParams','SearchFactory','Base64','loader',function($scope,$rootScope,$state,$stateParams,SearchFactory,Base64,loader){
	//loader.show();
	$scope.validation_message = '';
	$scope.empty_result_flag = '';
	$rootScope.errorMessageshow=0;
	$scope.entriesPerPage=50;
	$scope.showPrintflag = '';
	$scope.result={
		total:0,
		data:{}
	};
	/*searchCondition for search data*/
	$scope.searchCondition={
		order	:0,//1 for desc//0 for asc
		orderby :'datereceivedbyOSAH',
		start   :0,
		length  :50,
	};
	
	
	/*pagination functionality start*/
	/*entriesPerPage*/
	$scope.entriesPerPageFn=function (){
		entriesPerPage=[];
		for(i=50;i<=300;i=i+50)
		{
			entriesPerPage.push(i);
		}
		return entriesPerPage;
	};
	/*entriesPerPage*/
	$scope.paginationFn=function (){
		if($scope.total_data>0)
		{
			pg_length=4;
			pg_start=0;
			pg_end=pg_length;
			if($scope.searchCondition.start>$scope.searchCondition.length*(pg_length/2)){
				pg_start=parseInt(($scope.searchCondition.start/$scope.searchCondition.length)-(pg_length/2));
				pg_end=pg_start+pg_length;
			}
			if(pg_end>=$scope.lastPagination())
			{
				pg_end=$scope.lastPagination();
				pg_start=pg_end-pg_length;
				if(pg_start<(pg_length/2))
				{
					pg_start=pg_end-pg_length;
					pg_start=(pg_start<0)?0:pg_start;
				}
			}
			pagination=[];
			for(i=pg_start;i<=pg_end;i++)
			{
				pagination.push(i);
			}
			return pagination;
		}
	};
	$scope.entriesPerPageChanged=function(old_val){
		if($scope.total_data>0)
		{
			if($scope.searchCondition.length>old_val){
				$scope.searchCondition.start=0;
			}
			listingSearchResult();
		}
	};
	$scope.lastRecordNo=function(){
		if($scope.total_data>0)
		{
			return parseInt($scope.searchCondition.start)+parseInt($scope.result.data.length);
		}
	};
	$scope.lastPagination=function(){
		lastPg=parseInt($scope.result.total/$scope.searchCondition.length);
		if(($scope.result.total%$scope.searchCondition.length)==0){
			return lastPg-1;
		}
		return lastPg;
	};
	$scope.paginationClick=function(start){
		$scope.searchCondition.start=start*$scope.searchCondition.length;
		listingSearchResult();
	};
	$scope.sortByClick=function(column){
		if($scope.searchCondition.orderby==column){$scope.searchCondition.order=($scope.searchCondition.order==1)?0:1;}
		$scope.searchCondition.orderby=column;
		$scope.searchCondition.start=0;
		listingSearchResult();
		$('.search-results-table i').addClass('fa-angle-down').removeClass('fa-angle-up');
		if($scope.searchCondition.order==1)
		$('[ng-click="sortByClick(\''+column+'\')"]').find('i').removeClass('fa-angle-down').addClass('fa-angle-up');
	};
	/*pagination functionality end*/
	
	listingSearchResult=function (){
		// console.log($rootScope.advanceserachdata[0]);
		//return false;
		//loader.show();
		if($stateParams.reqdt!=''&& $stateParams.reqdt!=undefined){
			$scope.params_data = Base64.decode($stateParams.reqdt);
			 myObj = JSON.parse($scope.params_data);
			 angular.forEach(myObj, function(value, key){
			  if(key=='calendarhearingdate')
			  {
				$scope.showPrintflag = '1';
			  }
		   });
			$scope.flag = Base64.decode($stateParams.flg);
			  if($scope.flag=='1'){
				  loader.show();
				 SearchFactory.advancesearch("docketsearch","hearingdate = '"+$scope.params_data+"'",$scope.searchCondition).success(function(response){
					 loader.hide();
					  $scope.result = response;
					  if($scope.result.data=='')
					  {
						 $rootScope.errorMessageshow=1;
						 $rootScope.errorMessage="No records found";
						 $scope.empty_result_flag = '1';
					  }
					  else{$scope.empty_result_flag = '';}

					//  loader.hide();

					});
			 }
			 if($scope.flag=='2'){
				 loader.show();
			 	$scope.params_data12 = JSON.parse($scope.params_data);
					SearchFactory.advancesearch("docketsearch",$scope.params_data12,$scope.searchCondition).success(function(response){
						$scope.total_data = response.total;
						loader.hide();
					  $scope.result = response;
					   console.log($scope.result);
					  if($scope.result.data=='')
					  {
						  //$rootScope.errorMessageshow=1;
						 // $rootScope.errorMessage="No records found";
						  $scope.empty_result_flag = '1';
					  }
					  else{$scope.empty_result_flag = '';}

					  loader.hide();

					});
			 }
			 if($scope.flag=='3'){
				 loader.show();
				$scope.closed_cases_param = JSON.parse($scope.params_data);
				SearchFactory.closecasesearch($scope.closed_cases_param,$scope.searchCondition).success(function(response){
					$scope.total_data = response.total;
					loader.hide();
					$scope.result = response;
				});
			 }
		}
		$scope.paginationFn();
	};
	listingSearchResult();
		
		/* 
			Name : Neha
			Date Created : 21-11-2016
			Description : Function is used to export search result data in CSV Format.
		*/
		$scope.exportData = function()
		{
			// console.log($scope.result.total);
			if($scope.result.total==0)
			{
				$rootScope.errorMessageshow=1;
				$rootScope.errorMessage="Your search displayed no results. Please search again in order to export cases.";
			}else{
				var f = document.createElement("form");    
				f.setAttribute('method',"post");    
				f.setAttribute('action',"/Osahform/exportdata"); 
				
				var i = document.createElement("input");    
				i.setAttribute('type',"hidden");    
				i.setAttribute('value',$scope.flag);    
				i.setAttribute('name',"flag");
				f.appendChild(i);
				
				var i = document.createElement("input");    
				i.setAttribute('type',"hidden");    
				i.setAttribute('value',$scope.params_data);    
				i.setAttribute('name',"condition");
				f.appendChild(i);
				document.getElementById("exportDataId").appendChild(f).submit();
			}
		}
		
		$scope.CalendarexportData = function()
		{
			if($scope.result.total==0)
			{
				$rootScope.errorMessageshow=1;
				$rootScope.errorMessage="Your search displayed no results. Please search again in order to export cases.";
			}else{
				var f = document.createElement("form");    
				f.setAttribute('method',"post");    
				f.setAttribute('action',"/Osahform/calendarexportdata"); 
				
				var i = document.createElement("input");    
				i.setAttribute('type',"hidden");    
				i.setAttribute('value',$scope.params_data);    
				i.setAttribute('name',"condition");
				f.appendChild(i);
				document.getElementById("calendarexportDataId").appendChild(f).submit();
			}
		}
		
		/* 
			Name : Neha
			Date Created : 10-02-2016
			Description : Function is used to export search result data in CSV Format.
		*/
		
			$scope.printResult = function()
			{
				// SearchFactory.printResult($scope.params_data).success(function(response){
					
				// });
				
				// if($scope.result.total==0)
			// {
				// $rootScope.errorMessageshow=1;
				// $rootScope.errorMessage="Your search displayed no results. Please search again in order to export cases.";
			// }else{
				var f = document.createElement("form");    
				f.setAttribute('method',"post");    
				f.setAttribute('action',"/Osahform/printresult"); 
				
				var i = document.createElement("input");    
				i.setAttribute('type',"hidden");    
				i.setAttribute('value',"docketsearch");    
				i.setAttribute('name',"tableName");
				f.appendChild(i);
				var i = document.createElement("input");    
				i.setAttribute('type',"hidden");    
				i.setAttribute('value',$scope.params_data);    
				i.setAttribute('name',"condition");
				f.appendChild(i);
				document.getElementById("printDataId").appendChild(f).submit();
				// var data = {$scope.params_data};
				// SearchFactory.exportData($scope.params_data).success(function(response){
					
				// });
			// }
				
			}
		
		 //This function will search docket detail docket no
	   $scope.searchbydocket = function(docketno){
		  if(docketno!='' && docketno!=undefined){
			 $scope.docket_no = Base64.encode(docketno);
			 $state.go("docket",{reqdt:$scope.docket_no},{reload: true});
		  }else{
			   $rootScope.errorMessageshow=1;
			   $rootScope.errorMessage="Please enter docket# ";
		  }
		  $scope.additionalSearchBlockFn(false); 
	   };  
}]);


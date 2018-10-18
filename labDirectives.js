angular
	.module("spellingy")
	.directive("textBar",function(){
	
	return {
		scope:true,
		controller:function($scope, laemeFct, $log, labFct){
			
			$scope.texts=[];
			
			
			$scope.getText=function()
			{
				laemeFct.loadProfile($scope.gt,$scope);
				$scope.tids["t"+$scope.gt]={alts:"-",st:"st0",tid:$scope.gt};
				
				$log.info($scope.chck);
				
			}
			
		
		},
		
		templateUrl:"templates/textbar.html"
		
		
	}
	
	
	
  });
  
  
  angular
	.module("spellingy")
	.directive("labHelper",function(){
	
	return {

		templateUrl:"templates/labhelper.html"
		
		
	}
	
	
	
  });
  
  
  
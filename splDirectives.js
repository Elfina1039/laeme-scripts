angular
	.module("spellingy")
	.directive("miniForm",function(){
	
	return {
		scope:true,
		controller:function($scope, laemeFct){
				
			$scope.dict=[];	
				
			$scope.saveFix=function(data)
				{
					laemeFct.saveAnalysis("saveFix","http://localhost:8080/mylaeme/php/updates.php",[data]);
				}
				
				
			$scope.showForms=function(data)
				{
					laemeFct.getDict("loadForms",[data.l,data.g],$scope);
		
				}	
		
		},
		
		templateUrl:"templates/miniform.html"
		
		
	}
	
	
	
  });
  
  
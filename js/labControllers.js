angular
	.module("spellingy")
	.controller("methinker",function($scope,$log,phgrsFactory,actFactory,$http,labFct,laemeFct,$filter,localFct){
	
	
	$scope.chck="ok";
	
	$scope.rsl=[];
    $scope.clusterFilter=function(expr)
    {
        $filter('clusterFilter')($scope.rsl,expr);
     
    }
    
    $scope.cFilter=null;
	
	$scope.helper=[];
			
		
    
    $scope.compareSlots=function()
			{
			$log.info("comparing SLOTS (ctrl)");
				labFct.compareSlots($scope);
			}
    
     $scope.drawSlots=function(t)
			{
			$log.info("drawing SLOTS (ctrl)");
         var cluster=$filter('clusterCdFilter')($scope.rsl, $scope.cFilter);
         
         //$log.info(txtSlots);
         var txt=localFct.findItem(txtSlots,"id",t);
         
         loadData(txt.slots,cluster);
         
			}
	
    
	
			$scope.compare=function(lt,t,txts)
			{
			$log.info("comparing from parent: "+lt.gr);
				labFct.compare(lt,t,txts,$scope);
			}
	
	
	$scope.getForms=function(ps)
			{
			$log.info("getting forms: "+ps);
				laemeFct.laemeData("stridForms",ps,$scope);
			}
    
    $scope.drawAlts=function()
    {
        laemeFct.getSlotAlts(6,"ea");
        
    }
    
    
	
  });
  
  angular
	.module("spellingy")
	.controller("texter",function($scope,$log,laemeFct,$http){

  });
  

  
  
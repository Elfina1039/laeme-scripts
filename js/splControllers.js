angular
	.module("spellingy")
	.controller("methinker",function($scope,$log,phgrsFactory,actFactory,$http){
	
	
	
  });
  
  angular
	.module("spellingy")
	.controller("analyser",function($scope,$log,laemeFct,analyserFct,$http){
	
	$scope.q={offs:0, lmt:20};
	$scope.dict=[];
	
	$scope.miniform={s:"-",posb:"-",strid:0};
	
	$scope.done={dict:[]};
	
	

	
	$scope.getDict=function()
	{
		laemeFct.getDict("loadDict",[$scope.q.offs,$scope.q.lmt],$scope);
	}
	

	
		$scope.analyse=function(word)
	{
	$log.info("analysing");
		word.suggs=analyserFct.analyse(word);
		
		//$log.info("done");
		//$log.info(word.suggs);
		
		
	}
	
		$scope.analyseAll=function(list)
	{
	$log.info("analysing ALL");
		
		list.forEach(function(word,wi){
		word.suggs=analyserFct.analyse(word);
		
		//$log.info("done");
		//$log.info(word.suggs);
		});
	
		
	}
	
		$scope.saveAnalysis=function(list)
	{
		laemeFct.saveAnalysis("saveAnalysis","http://localhost/mylaeme/php/inserts.php",list);
	}
	
	$scope.fixStr=function(d)
	{
		$scope.miniform=d;
	}
	
  });
  
  angular
	.module("spellingy")
	.controller("positioner",function($scope,$log,laemeFct,$http){
	
	
	$scope.dict=[];
	
	
			$scope.getPoss=function()
	{
		laemeFct.getDict("loadPoss",[0,1000],$scope);
	}
	
			$scope.procPoss=function()
	{
	
	if($scope.dict.length>0)
	{
	var rw=$scope.dict.shift();
		rw.lst=rw.poss.split("/");
		$log.info(rw.lst);
		laemeFct.savePoss(rw,$scope.procPoss);
	}
	else
	{
		$log.info("Processing complete");
	}
		
	}
	
	
	
  });
  
  
  
  
angular
	.module("spellingy")
	.controller("methinker",function($scope,$log,phgrsFactory,actFactory,$http){
	
	$scope.grphs=phgrsFactory.getGrphs();
	$scope.phgrs=phgrsFactory.getPhgrs();

	$scope.texty=texty;
	$scope.vskt=new Array();
	
	$scope.aktivni="";

	$scope.lsc=lsc;
	$scope.navrzene=[];
	
	

$scope.corrs=function(texty)
	{
	
	var spl=new Array();
	
	for(i in phgrs)
	{
		//document.write(i+"=");
		//document.write(phgrs[i].ph[y]+", ");
		var rx=new RegExp(i,"g");
		
		
		for(g in texty)
{
var cnt=0;

for(r=0;r<texty[g].length;r++)
{

for(s=0;s<texty[g][r]["sl"].length;s++)
{
//$("body").append("<h3>GO3");	
if(rx.test(nahradit(texty[g][r]["sl"][s].f)))
{
cnt++;	
}
	
	}
	
	
}
if(cnt>0)
{
spl.push({l:i,c:cnt});

//$("#t"+g).append("<li>"+i+" : "+cnt);		
}

}
		
	}

 return spl;	
	}
	
	$scope.nahradit=function(ms){
	
ms=ms.replace(yogh,"?");
ms=ms.replace(thorn,"þ");
ms=ms.replace(wynn,"?");
ms=ms.replace(edh,"ð"); 
ms=ms.replace(ig,"?"); 
ms=ms.replace(ash,"æ"); 

ms=ms.toLowerCase();

return ms;	
	};
	
$scope.gpole=function(ci){
	return phgrsFactory.najdiGraph(ci);
}	
	
$scope.prirad=function(co){
	$scope.aktivni=co;
	//vyskyty=new Array();
	$scope.vskt=[];
	actFactory.zvyraznit($scope.aktivni.l.toUpperCase(),"f","cervena",$scope.vskt);

}

$scope.navrhni=function(co){
	$scope.navrzene=phgrsFactory.najdiGraph(co).ph;

}

$scope.pripis=function(komu){
//alert(komu.rps);
	komu.rps.push($scope.aktivni.l);
	phgrsFactory.najdiGraph($scope.aktivni.l).rps.push(komu.ph);	
}

$scope.dalsiMoznosti=function(lx)
{
	var dalsi=actFactory.dalsiMoznosti(lx);
	return dalsi;
}

$scope.uloz=function(){


var nove=[];

	for(gi=0;gi<$scope.grphs.length;gi++)
	{
	if($scope.grphs[gi].rps.length>0)
	{
		//$("#ovladac").append("<b>"+$scope.grphs[gi].ph+"</b> = "+$scope.grphs[gi].rps+"<br>");
		nove.push({ph:$scope.grphs[gi].ph, rps:$scope.grphs[gi].rps});
		
		phgrsFactory.najdiPhoneme($scope.grphs[gi].ph).RPS.push($scope.grphs[gi].rps);
		$scope.grphs[gi].rps=[];
	}
	}
	
		$http.post("php/spl_save.php",
	          {data:{txt:txt,corrs:nove}})
			  .then(function(response){$log.info(response.data)});
}
	
	
  });
  
  
  
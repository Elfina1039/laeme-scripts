
angular
	.module("spellingy")
	.factory("labFct",function($http,$log,localFct, laemeFct){

	var ref=laemeFct.getRef();
	
	function compare(lt,t,txts,target)
	{
	$log.info("comparing usage: "+lt.lit);
	
	occs={};

		
		$log.info(target.tids);
		
	txts.forEach(function(ti){
		
		//$log.info(ti.slots[10].lst);
		
	for(n in ti.slots)
		{
		//slot={cd:"a-e", lits:[a,e], lst:[[1,2],[1,3]]}
            
		var merged = [].concat.apply([], ti.slots[n].lst);
		//$log.info(ti.slots[n].lst);
		if($.inArray(lt.lit,merged)!=-1)
			{
			//$log.info("item found");
			var nr=jQuery.extend({},target.tids);
				if(occs[ti.slots[n].slot]=="undefined" || occs[ti.slots[n].slot]==null)
				{
				//$log.info("adding row ("+ti.tid+")");
				var pos=ti.slots[n].slot.split("-");
				
                if(ref[pos[0]+"_"+pos[1]]!=null){
                    var refRef=pos[0]+"_"+pos[1];
                    //$log.info("rr:" + refRef + " / " + pos[0]+"_"+pos[1]);
                } 
                    else{
                        var refRef=pos[0]+"_";
                      //   $log.info("elserr:" + refRef  + " / " + pos[0]+"_"+pos[1]);
                    }
				
				occs[ti.slots[n].slot]={cat:ref[refRef].cat,l:ref[refRef].lexel,g:ref[refRef].grammel,rps:nr,strid:pos[0],pos:pos[1]};	
				//$log.info(occs[ti.slots[n].slot]);
				}
			
			}
		}
		
		for(o in occs)
		{
	//$log.info("slot: "+ occs[o].l);
	
	occs[o].patt="p";
	
			txts.forEach(function(tx){
				//occs[o].rps["t"+tx.tid]=alternatives(localFct.findItem(tx.slots,"slot",o).lst,lt.lit,tx.tid);
				occs[o].rps["t"+tx.tid]=alternatives(localFct.findItem(tx.slots,"slot",o).lst,lt.lit,tx.tid);
				occs[o].patt+=occs[o].rps["t"+tx.tid].st.replace("st","");
				
			});
			
			
	
	
		}
		
	
		var rsl=[];
		//$log.info("check: "+target.chck);
		
		for(o in occs)
		{
		rsl.push(occs[o]);	
		
		}
		
		
		
		target.rsl=rsl;
			
			
		});
		
	}
	
    function compareSlots(target)
	{
	$log.info("comparing slots: ");
	
        
	occs={};

	txtSlots.forEach(function(ti){
		
		//$log.info(ti.slots[10].lst);
		
	for(n in ti.slots)
		{
		//var nr=jQuery.extend({},target.tids);st:""
            target.tids={"t4":{tid:4,st:"st0",alts:""},"t5":{tid:5,st:"st0",alts:""},"t6":{tid:6,st:"st0",alts:""},"t7":{tid:7,st:"st0",alts:""},"t8":{tid:8,st:"st0",alts:""},"t9":{tid:9,st:"st0",alts:""},"t10":{tid:10,st:"st0",alts:""}};
            var nr={"t4":{tid:4,st:"st0",alts:""},"t5":{tid:5,st:"st0",alts:""},"t6":{tid:6,st:"st0",alts:""},"t7":{tid:7,st:"st0",alts:""},"t8":{tid:8,st:"st0",alts:""},"t9":{tid:9,st:"st0",alts:""},"t10":{tid:10,st:"st0",alts:""}};
        nr["t"+ti.id].alts=ti.slots[n].lst.length;
        nr["t"+ti.id].st="st1";
            
				if(occs[ti.slots[n].cd]=="undefined" || occs[ti.slots[n].cd]==null)
				{
				occs[ti.slots[n].cd]={l:ti.slots[n].cd,g:"-",rps:nr};	
				$log.info(occs[ti.slots[n].cd]);
				}
			else
                {
                occs[ti.slots[n].cd].rps["t"+ti.id].alts=ti.slots[n].lst.length;
                occs[ti.slots[n].cd].rps["t"+ti.id].st="st1";
                    $log.info("updating existing line ("+ti.id+")");
                }
		}
		
	
		var rsl=[];
		//$log.info("check: "+target.chck);
		
		for(o in occs)
		{
		rsl.push(occs[o]);	
		
		}
		
		
		
		target.rsl=rsl;
			
			
		});
		
	}
	
	function compareSlt(ref,cr)
	{
		var st=0;
		
		ref.forEach(function(sl){
			
			if(sl.s==cr.slot)
			{
				st=1;
			}
			
		});
		
		return st;
		
		
	}
	
	function alternatives(lst,prim,tid)
	{
	//$log.info("alternatives");
	//$log.info(lst);
		var rsl=[];
		var st=0;
		lst.forEach(function(itm){
			
			if(itm[0]!=prim && $.inArray(itm[0],rsl)==-1 && st!=1)
			{
				rsl.push(itm[0]+" ("+itm[1]+")");
				st=2;
			}
			
			if(itm[0]==prim  && $.inArray(itm[0],rsl)==-1)
			{
				rsl.push(itm[0]+" ("+itm[1]+")");
				st=1; 
			}
			
			
			
		});
	
	
	
	return {alts:rsl.join(", "),st:"st"+st,tid:tid};	
	}
	
    
    
    
   
	
return {
	compare:compare, compareSlots:compareSlots
};
	
	});
	

angular
	.module("spellingy")
	.factory("localFct",function($http,$log){

var yogh=new RegExp("z","g");
var thorn=new RegExp("y","g");
var bthorn=new RegExp("y~","g");
var wynn=new RegExp("w","g");
var edh=new RegExp("d","g");
var ig=new RegExp("g","g");
var ash=new RegExp("ae","g");

var aa=new RegExp("Ax","g");
var ee=new RegExp("Ex","g");
var ii=new RegExp("Ix","g");
var oo=new RegExp("Ox","g");
var uu=new RegExp("Ux","g");
var yy=new RegExp("Yx","g");
var aee=new RegExp("æx","g");
var jj=new RegExp("Jx","g");



	

function nahradit(ms)
{
ms=ms.replace(yogh,"ȝ");
ms=ms.replace(bthorn,"ꝥ"); 
ms=ms.replace(thorn,"þ");
ms=ms.replace(wynn,"ƿ");
ms=ms.replace(edh,"ð"); 
ms=ms.replace(ig,"ᵹ"); 
ms=ms.replace(ash,"æ"); 


ms=ms.replace(aa,"á"); 
ms=ms.replace(ee,"é"); 
ms=ms.replace(ii,"í"); 
ms=ms.replace(oo,"ó"); 
ms=ms.replace(uu,"ú"); 
ms=ms.replace(yy,"ý"); 
ms=ms.replace(aee,"ǣ"); 
ms=ms.replace(jj,"J"); 


//$log.info("replaced");

ms=ms.toLowerCase();

return ms;
}
	
	function findItem(arr,prop,val)
	{
	
	//$log.info("searching for: " + val +" in "+prop+" of");
	//$log.info(arr);
	
		for(a in arr)
		{
			if(arr[a][prop]==val)
			{
				return arr[a];
			}
			
		}
		
		//$log.info("nothing found");
		return {lst:[]};
		
	}
	
return {
	findItem:findItem, nahradit:nahradit
};
	
	});

angular.module("spellingy")
.filter("clusterFilter", function($log)
{
return function(input,anch){
    
    $log.info("filtering: "+anch);
    
    var zeros=new RegExp("[#0]","g");
    
    if(anch==null || anch=="undefined" || anch=="")
        {
            return input;
        }
    else
        {
            var clstr=anch.split("-");
            var output=[];
            input.forEach(function(itm){
                
                var lits=itm.l.split("-");
                
                lits.forEach(function(lt){
                    
                    if($.inArray(lt,clstr)!=-1 && $.inArray(itm, output)==-1 && zeros.test(itm.l)==false)
                    {
                        output.push(itm);
                        clstr.concat(lits);
                    }
                    
                });
                
                
                
            });
                return output;
        }
    
}
});

angular.module("spellingy")
.filter("clusterCdFilter", function($log)
{
return function(input,anch){
    
    $log.info("filtering: "+anch);
    
    var zeros=new RegExp("[#0]","g");
    
    if(anch==null || anch=="undefined" || anch=="")
        {
            return input;
        }
    else
        {
            var clstr=anch.split("-");
            var output=[];
            input.forEach(function(itm){
                
                var lits=itm.l.split("-");
                
                lits.forEach(function(lt){
                    
                    if($.inArray(lt,clstr)!=-1 && $.inArray(itm, output)==-1 && zeros.test(itm.l)==false)
                    {
                        output.push(itm.l);
                        clstr.concat(lits);
                    }
                    
                });
                
                
                
            });
                return output;
        }
    
}
});
	
	
	
angular
	.module("spellingy")
	.factory("analyserFct",function($http,$log,phgrsFactory){
	
		var grphs=phgrsFactory.getGrphs();
	var phgrs=phgrsFactory.getPhgrs();

	//EVIL: v-ue-le OR v-u-e-l-e?
	//cr^ist 
	//BELIEVE: ileuve
	//ae:ht 	ayhte 
	//before{p} 	bifore 	CV0CVCVN 
	//than CVC yanne
	//what 	hƿi 	CVC 
	//evereach 	*eurich 	VCCVC 
	//-  	her 	CVCV 
	//while 	ðe-hƿile 	012CVCV 
	//? wunian 	wunye 	CVCV0 ->> diphtong?
	
	var optional=
		{"E":"e",
		"N":"n(nn)",
		"R":"n(nn)þðtmre",
		"P":"sþ(th)nþ",
		"S":"sþ(th)",
		"H":"h",
		"I":"iyíýaJe",
		"L":"l",
		"W":"wuvƿ",
		"D":"tdðþ",
		"T":"tðþ",
		"M":"mn",
		"-":"-",
		"J":"jyᵹȝihg(ch)",
		"A":"aáe",
		"F":"fvu",
		"U":"uve",
		"B":"b",
		"O":"aeiouy"};
		
	
	function makeRg(str,ins)
{

if(ins!=null)
{
var nchs=ins.split("");
	nchs.forEach(function(nch,ni){
		str=str.replace(ni,"(["+optional[nch]+"0]/)");
		
	});	
}
	
	
	var rpl2=new RegExp("[CVG]","g");
	str=str.replace(rpl2,"[^/]+/");
	
	var trg=new RegExp("^"+str+"$","i");
	
	return trg;

}	
	
	function analyse(tag)
	{
	
	$log.info("analysing: "+tag);
	
	var trg=makeRg(tag.s,tag.posb);
	
	var word=tag.w.replace("*","");
	word=word.replace("\\","");
	word=word.replace(/(^-)|(-$)/gi,"");

	
	//$log.info(word);
	
	
	if(tag.s=="0")
	{
		ok=[tag.f];
		status="st1";
		notok=[]
	}
	else
	{
		var cnd=findCandidates(phgrs,word.toLowerCase());
		
		//$log.info(cnd);
		
		var suggs=readStructure(cnd,word.toLowerCase(), tag);
		
		//$log.info("suggs received");
		//$log.info(suggs);
		
		var ok=[];
		var notok=[];
		
		suggs.forEach(function(s,si){
			
			s.shift();
			
			var vsl=zretez(s,"gr","/",true);
			
			var cele=zretez(s,"gr","",false);
			
			
			//$log.info("matching: "+vsl);
			
			
			//if(trg.test(vsl+"-")==true)
			
			
			if((cele==word || vsl=="0") && trg.test(vsl+"/")==true)
			{
			//$log.info("pushing:" + vsl);
				ok.push(vsl);
			}
			else
			{
				notok.push(vsl);
			}
			
		});
		
		var status="st"+ok.length;
		}
		
		return {ok:$.unique(ok),status:status, notok:$.unique(notok)};
		
	}
	
function zretez(pole,prop,sep, nuly)
{
var rsl=[];
	pole.forEach(function(p,i){
	
	if(p.gr!="0" || nuly==true)
	{
	rsl.push(p.gr);	
	}
		
	});
	
	rsl=rsl.join(sep);
	return rsl;
	
}
	
//findCandidates(phgrs,"ye-hwile");
	
function findCandidates(list,word)
{
	
	var rsl=[];
	
	list.forEach(function(l,i){
		
		var rg=new RegExp(l.gr,"i");
		
		
		if(rg.test(word)==true)
		{
		
		//$log.info("GR CAT:" + l.c);
		var cnd=matchList(l.c,l.gr,word,[{gr:"0",pos:[word.length,word.length+1],c:"?"}]);	
		rsl=rsl.concat(cnd);
			
		}
		
		
	});
	
	
	return rsl;
	
	
}

function matchList(cat,gr,str,rsl)
{


	var nm=matcher(gr,str,cat);
	
	//console.log("matcher result: "+nm);
	
	while(nm!=[])
	{
	//console.log("item "+gr+" found at position "+ni);
		rsl.push(nm);
		var rpl=gr.replace(/./,"_");
		str=str.replace(gr,rpl);
		nm=matcher(gr,str,cat);
	}
	
	//$log.info("CND LIST");
	//$log.info(rsl);
	
		return rsl;
	
	function matcher(gr,str,cat)
	{
	var ni=str.indexOf(gr);	
	
	if(ni!=-1)
	{
	var mtch={gr:gr,pos:[ni,ni+gr.length],c:cat};
	}
	else
	{
	var mtch=0;
	}
	return mtch;
		
	}
	
}


function readStructure(cnds, word, tg)
{
//$log.info("read str");
var str=tg.s;
if(tg.posb!=null)
{
var nchs=tg.posb.split("");
	nchs.forEach(function(nch,ni){
		str=str.replace(ni,nch);
		
	});	
}
//$log.info("expected structure:" + str);


var rsl=[[{gr:"",pos:[0,0]}]];

//var narr=reader(word, cnds, inparr, str.charAt(ind));

for(i=0;i<str.length;i++)
{
narr=reader(word,cnds,rsl, str.charAt(i));
rsl=narr.old.concat(narr.added);

	
}
	
	
	return rsl;
	
	function reader(word, cnds, inparr,exp)
	{
//	$log.info("exp="+exp);
		var outarr=[];
		var old=[];
		
		inparr.forEach(function(ar,ia){
		
		
		var chng=0;
		var nula=0;
		
			cnds.forEach(function(cn,ic){
				

				if(exp=="C" || exp=="V" || exp=="G")
				{
				//$log.info("cat:"+cn.c);
				
					if(ar.slice(-1)[0].pos[1]==cn.pos[0] && (exp==cn.c || cn.c=="?" || exp=="G"))
					{
						outarr.push(ar.concat([cn]));
						//console.log("adding new");
						chng=1;
						
					}
				}
				else
				{
				var pt=new RegExp(cn.gr, "i");
					if(pt.test(optional[exp])==true)
					{
						outarr.push(ar.concat([cn]));
						//console.log("adding new");
						chng=1;
					}
					else
					{
					if((ar.slice(-1)[0].pos[1]==cn.pos[0] || cn.gr=="0") && nula==0)
					{
						outarr.push(ar.concat({gr:0,pos:ar.slice(-1)[0].pos}));
						//console.log("adding new");
						nula=1;
						}
					}
					
				}
				
				
			
				
			});
			
			if(chng==0)
			{
				old.push(ar);
				
			}
		
		
			
			
			
		});
		
		//console.log("returning "+ outarr);
		return {added:outarr, old:old};
	}
}
	
	
	
	
return {
	analyse:analyse
};
	
	});
	
	

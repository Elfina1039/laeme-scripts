angular
	.module("spellingy")
	.factory("phgrsFactory",function($http,$log){

var phonographs=[
{rps:[], gr:'#', ph:['0'], c:"?"},
{rps:[], gr:'hu', ph:['0'], c:"C"},
{rps:[], gr:'cs', ph:['0'], c:"V"},
{rps:[], gr:'aƿ', ph:['0'], c:"V"},
{rps:[], gr:'oƿ', ph:['0'], c:"V"},
{rps:[], gr:'x', ph:['0'], c:"C"},
{rps:[], gr:'J', ph:['0'], c:"?"},
{rps:[], gr:'eæ', ph:['0'], c:"V"},
{rps:[], gr:'ey', ph:['0'], c:"V"},
{rps:[], gr:'ᵹƿ', ph:['0'], c:"C"},
{rps:[], gr:'hþ', ph:['0'], c:"C"},
{rps:[], gr:'hð', ph:['0'], c:"C"},
{rps:[], gr:'ae', ph:['0'], c:"V"},
{rps:[], gr:'0', ph:['0'], c:"?"},
{rps:[], gr:'[]', ph:['_'], c:"?"},
{rps:[], gr:'á', ph:['á'], c:"V"},
{rps:[], gr:'é', ph:['é'], c:"V"},
{rps:[], gr:'í', ph:['í'], c:"V"},
{rps:[], gr:'ó', ph:['ó'], c:"V"},
{rps:[], gr:'ú', ph:['ú'], c:"V"},
{rps:[], gr:'ý', ph:['ú'], c:"V"},
{rps:[], gr:'ǣ', ph:['?'], c:"V"},
{rps:[], gr:'ðð', ph:['?'], c:"C"},
{rps:[], gr:'vv', ph:['?'], c:"C"},
{rps:[], gr:'eea', ph:['?'], c:"V"},

{rps:[], gr:'-', ph:['-'], c:"-"},
{rps:[], gr:'ᵹh', ph:['x'], c:"C"},

{rps:[], gr:'ȝw', ph:['ʍ'], c:"C"},

{rps:[], gr:'ȝȝ', ph:['j'], c:"V"},

{rps:[], gr:'ᵹ', ph:['g'], c:"C"},

{rps:[], gr:'hw', ph:['ʍ'], c:"C"},

{rps:[], gr:'hƿ', ph:['ʍ'], c:"C"},

{rps:[], gr:'ƿh', ph:['ʍ'], c:"C"},

{rps:[], gr:'éo', ph:['éo'], c:"V"},

{rps:[], gr:'oo', ph:['ó'], c:"V"},

{rps:[], gr:'ie', ph:['ie'], c:"V"},

{rps:[], gr:'íe', ph:['íe'], c:"V"},

{rps:[], gr:'ia', ph:['ia'], c:"V"},

{rps:[], gr:'ye', ph:['ie'], c:"V"},,

{rps:[], gr:'t', ph:['t'], c:"C"},

{rps:[], gr:'yh',ph:['j'], c:"C"},

{rps:[], gr:'ƿ',ph:['w'], c:"C"},

{rps:[], gr:'rr',ph:['r'], c:"C"},

{rps:[], gr:'r',ph:['r'], c:"C"},

{rps:[], gr:'ll',ph:['l','l'], c:"C"},

{rps:[], gr:'l',ph:['l','l'], c:"C"},

{rps:[], gr:'nn',ph:['n','n'], c:"C"},

{rps:[], gr:'n',ph:['n','n'], c:"C"},

{rps:[], gr:'mm',ph:['m','m'], c:"C"},

{rps:[], gr:'m',ph:['m','m'], c:"C"},

{rps:[], gr:'qw',ph:['ʍ'], c:"C"},

{rps:[], gr:'qu',ph:['ʍ'], c:"C"},

{rps:[], gr:'quh',ph:['ʍ'], c:"C"},

{rps:[], gr:'wh',ph:['ʍ','w'], c:"C"},

{rps:[], gr:'wƿ',ph:['ʍ','w'], c:"C"},

{rps:[], gr:'gh',ph:['x'], c:"C"},

{rps:[], gr:'ȝh',ph:['x'], c:"C"},

{rps:[], gr:'h',ph:['x','h'], c:"C"},

{rps:[], gr:'ssch',ph:['ʃ'], c:"C"},

{rps:[], gr:'ssh',ph:['ʃ'], c:"C"},

{rps:[], gr:'sc',ph:['ʃ'], c:"C"},

{rps:[], gr:'sch',ph:['ʃ'], c:"C"},

{rps:[], gr:'sh',ph:['ʃ'], c:"C"},

{rps:[], gr:'z',ph:['z'], c:"C"},

{rps:[], gr:'ȝ',ph:['z','x','j'], c:"C"},

{rps:[], gr:'s',ph:['z','ʃ'], c:"C"},

{rps:[], gr:'ss',ph:['s','ʃ'], c:"C"},

{rps:[], gr:'thþ',ph:['θ'], c:"C"},

{rps:[], gr:'þþ',ph:['θ'], c:"C"},

{rps:[], gr:'th',ph:['θ','ð'], c:"C"},

{rps:[], gr:'ð',ph:['θ','ð'], c:"C"},

{rps:[], gr:'þ',ph:['θ','ð'], c:"C"},

{rps:[], gr:'fu',ph:['v'], c:"C"},

{rps:[], gr:'ph',ph:['f'], c:"C"},

{rps:[], gr:'ff',ph:['f','f'], c:"C"},

{rps:[], gr:'f',ph:['f','v'], c:"C"},

{rps:[], gr:'gu',ph:['g'], c:"C"},

{rps:[], gr:'ʒ',ph:['g'], c:"C"},

{rps:[], gr:'dg',ph:['d͡ʒ'], c:"C"},

{rps:[], gr:'j',ph:['d͡ʒ'], c:"?"},

{rps:[], gr:'ng',ph:['d͡ʒ','n','n'], c:"C"},

{rps:[], gr:'g',ph:['d͡ʒ','g','x','j'], c:"C"},

{rps:[], gr:'gg',ph:['d͡ʒ','g'], c:"C"},

{rps:[], gr:'dd',ph:['d'], c:"C"},

{rps:[], gr:'bb',ph:['b'], c:"C"},

{rps:[], gr:'b',ph:['b'], c:"C"},

{rps:[], gr:'cu',ph:['k'], c:"C"},

{rps:[], gr:'ck',ph:['k'], c:"C"},

{rps:[], gr:'kk',ph:['k'], c:"C"},

{rps:[], gr:'q',ph:['k'], c:"C"},

{rps:[], gr:'k',ph:['k'], c:"C"},

{rps:[], gr:'cch',ph:['c'], c:"C"},

{rps:[], gr:'ch',ph:['c','x'], c:"C"},

{rps:[], gr:'c',ph:['c','k'], c:"C"},

{rps:[], gr:'tt',ph:['t'], c:"C"},

{rps:[], gr:'pp',ph:['p'], c:"C"},

{rps:[], gr:'p',ph:['p'], c:"C"},

{rps:[], gr:'oy',ph:['oj','uj'], c:"V"},

{rps:[], gr:'oi',ph:['oj','uj'], c:"V"},

{rps:[], gr:'eaw',ph:['ew'], c:"V"},

{rps:[], gr:'eouw',ph:['ew'], c:"V"},

{rps:[], gr:'yw',ph:['iw','c'], c:"V"},

{rps:[], gr:'iu',ph:['iw','c'], c:"V"},

{rps:[], gr:'w',ph:['iw','c','ʍ','w'], c:"C"},

{rps:[], gr:'ew',ph:['iw','ew','c'], c:"V"},

{rps:[], gr:'eow',ph:['iw','ew'], c:"V"},

{rps:[], gr:'iw',ph:['iw','iw','c'], c:"V"},

{rps:[], gr:'aw',ph:['aw','ow'], c:"V"},

{rps:[], gr:'au',ph:['aw','ow'], c:"V"},

{rps:[], gr:'æȜ',ph:['aj'], c:"V"},

{rps:[], gr:'aȜ',ph:['aj'], c:"V"},

{rps:[], gr:'eȜ',ph:['aj'], c:"V"},

{rps:[], gr:'æi',ph:['aj'], c:"V"},

{rps:[], gr:'y-e',ph:['y:'], c:"V"},

{rps:[], gr:'uy',ph:['y:'], c:"V"},

{rps:[], gr:'ui',ph:['y:','iw','uj','c'], c:"V"},

{rps:[], gr:'u-e',ph:['ɵ:','iw','c'], c:"V"},

{rps:[], gr:'ov',ph:['u:'], c:"V"},

{rps:[], gr:'ow',ph:['u:','ow'], c:"V"},

{rps:[], gr:'uw',ph:['u:','iw','ew'], c:"V"},

{rps:[], gr:'o-e',ph:['o','ɵ:'], c:"V"},

{rps:[], gr:'ou',ph:['o','u:','ow'], c:"V"},

{rps:[], gr:'oo',ph:['o'], c:"V"},

{rps:[], gr:'oa',ph:['ɔ:'], c:"V"},

{rps:[], gr:'ay',ph:['a:','aj'], c:"V"},

{rps:[], gr:'ai',ph:['a:','aj'], c:"V"},

{rps:[], gr:'aa',ph:['a:'], c:"V"},

{rps:[], gr:'e-e',ph:['ɛ:'], c:"V"},

{rps:[], gr:'ee',ph:['e:','ɛ:'], c:"V"},

{rps:[], gr:'eu',ph:['e:','ɵ:','iw','ew','c'], c:"V"},

{rps:[], gr:'eo',ph:['e:','ɵ:'], c:"V"},

{rps:[], gr:'i-e',ph:['i:'], c:"V"},

{rps:[], gr:'ei',ph:['i:','e:','aj'], c:"V"},

{rps:[], gr:'ey',ph:['i:','aj'], c:"V"},

{rps:[], gr:'ij',ph:['i:'], c:"V"},

{rps:[], gr:'ii',ph:['i:'], c:"V"},

{rps:[], gr:'v',ph:['u','v','w'], c:"?"},

{rps:[], gr:'ea',ph:['a','ɛ:'], c:"V"},

{rps:[], gr:'æ',ph:['a','ɛ:'], c:"V"},

{rps:[], gr:'a',ph:['a','a:','ɔ:'], c:"V"},

{rps:[], gr:'e',ph:['e','a','e:','ɛ:','ə'], c:"V"},

{rps:[], gr:'o',ph:['ɵ','o','u','e:','ɔ:','o','ɵ:'], c:"V"},

{rps:[], gr:'oe',ph:['ɵ','e:','o','ɵ:'], c:"V"},

{rps:[], gr:'ue',ph:['ɵ','e:','ɵ:'], c:"V"},

{rps:[], gr:'u',ph:['i','ɵ','u','y','e:','u:','ɵ:','y:','iw','c','v','w'], c:"?"},

{rps:[], gr:'y',ph:['i','i:','y:','j'], c:"?"},

{rps:[], gr:'i',ph:['i','i:','d͡ʒ'], c:"?"},

{rps:[], gr:'d',ph:['d'], c:"C"}
];
	


function getPhgrs()
	{
		return phonographs;
	}
	
	
function najdiGraph(ktery)
{

	for(mg=0;mg<phonographs.length;mg++)
	{
	
		if(phonographs[mg].gr==ktery)
		{
		
			return phonographs[mg];
		}
	}
}	
	
	//graphonemes
		var graphonemes= [
{

	RPS:[], rps:[],
 ph:"i",
	gr:["i","y","u"], c:"V"
},

{
	RPS:[], rps:[],
 ph:"ɵ",
	gr:["ue","oe","o","u"], c:"V"
},

{
	RPS:[], rps:[],
 ph:"e",
	gr:["e"], c:"V"
},

{
	RPS:[], rps:[],
 ph:"a",
	gr:["a","æ","e","ea"], c:"V"
},

{
	RPS:[], rps:[],
 ph:"o",
	gr:["o"], c:"V"
},

{
	RPS:[], rps:[],
 ph:"u",
	gr:["u","v","o"], c:"V"
},

{
	RPS:[], rps:[],
 ph:"y",
	gr:["u"], c:"V"
},

//
{
	RPS:[], rps:[],
 ph:"i:",
	gr:["i","ii","ij","y","ey","ei","i-e"], c:"V"
},

{
	RPS:[], rps:[],
 ph:"e:",
	gr:["e","eo","oe","ue","o","eu","u","ee","ei"], c:"V"
},

{
	RPS:[], rps:[],
 ph:"ɛ:",
	gr:["ea","æ","e","ee","e-e"], c:"V"
},

{
	RPS:[], rps:[],
 ph:"a:",
	gr:["a","aa","ai","ay"], c:"V"
},

{
	RPS:[], rps:[],
 ph:"ɔ:",
	gr:["a","oa","o"], c:"V"
},

{
	RPS:[], rps:[],
 ph:"o",
	gr:["o","oo","ou","oe","o-e"], c:"V"
},

//
{
	RPS:[], rps:[],
 ph:"u:",
	gr:["u","uw","ow","ou","ov"], c:"V"
},

{
	RPS:[], rps:[],
 ph:"ɵ:",
	gr:["eo","oe","o","ue","u","eu","o-e","u-e"], c:"V"
},

{
	RPS:[], rps:[],
 ph:"y:",
	gr:["y","u","ui","uy","y-e"], c:"V"
},

{
	RPS:[], rps:[],
 ph:"ə",
	gr:["e"], c:"V"
},

{
	RPS:[], rps:[],
 ph:"aj",
	gr:["æi","ei","ey","eȜ","aȜ","æȜ","ai","ay"], c:"V"
},

{
	RPS:[], rps:[],
 ph:"aw",
	gr:["au","aw"], c:"V"
},

//
{
	RPS:[], rps:[],
 ph:"ow",
	gr:["au","aw","ow","ou"], c:"V"
},

{
	RPS:[], rps:[],
 ph:"iw",
	gr:["iw","eow","uw","eu","ew","u","w","iw","iu","yw","ui","u-e"], c:"V"
},

{
	RPS:[], rps:[],
 ph:"ew",
	gr:["eouw","eow","uw","eaw","ew","eu"], c:"V"
},

{
	RPS:[], rps:[],
 ph:"oj",
	gr:["oi","oy"], c:"V"
},

{
	RPS:[], rps:[],
 ph:"uj",
	gr:["oi","oy","ui"], c:"V"
},

{
	RPS:[], rps:[],
 ph:"p",
	gr:["p","pp"], c:"C"
},
//
{
	RPS:[], rps:[],
 ph:"t",
	gr:["tt"], c:"C"
},

{
	RPS:[], rps:[],
 ph:"c",
	gr:["c","ch","cch","eu","ew","u","w","iw","iu","yw","ui","u-e"], c:"C"
},

{
	RPS:[], rps:[],
 ph:"k",
	gr:["c","k","q","kk","ck","cu"], c:"C"
},

{
	RPS:[], rps:[],
 ph:"b",
	gr:["b","bb"], c:"C"
},

{
	RPS:[], rps:[],
 ph:"d",
	gr:["dd"], c:"C"
},

{
	RPS:[], rps:[],
 ph:"d͡ʒ",
	gr:["gg","g","ng","i","j","dg"], c:"C"
},

//
{
	RPS:[], rps:[],
 ph:"g",
	gr:["g","ʒ","gu","gg","ᵹ"], c:"C"
},

{
	RPS:[], rps:[],
 ph:"f",
	gr:["f","ff","ph","ff"], c:"C"
},

{
	RPS:[], rps:[],
 ph:"v",
	gr:["f","u","fu","v"], c:"C"
},

{
	RPS:[], rps:[],
 ph:"θ",
	gr:["þ","ð","th","þþ","thþ"], c:"C"
},

{
	RPS:[], rps:[],
 ph:"ð",
	gr:["þ","ð","th"], c:"C"
},

{
	RPS:[], rps:[],
 ph:"s",
	gr:["ss"], c:"C"
},


//
{
	RPS:[], rps:[],
 ph:"z",
	gr:["s","Ȝ","z"], c:"C"
},

{
	RPS:[], rps:[],
 ph:"ʃ",
	gr:["s","sh","sch","ss","sc","ssh","ssch"], c:"C"
},

{
	RPS:[], rps:[],
 ph:"x",
	gr:["h","Ȝ","g","Ȝh","gh","ch"], c:"C"
},

{
	RPS:[], rps:[],
 ph:"ʍ",
	gr:["wh","w","quh","qu","qw"], c:"C"
},

{
	RPS:[], rps:[],
 ph:"m",
	gr:["m","mm"], c:"C"
},

{
	RPS:[], rps:[],
 ph:"n",
	gr:["n","nn","ng"], c:"C"
},

{
	RPS:[], rps:[],
 ph:"l",
	gr:["l","ll"], c:"C"
},

//
{
	RPS:[],rps:[],
 ph:"r",
	gr:["r","rr"], c:"C"
},

{
	RPS:[],rps:[],
 ph:"w",
	gr:["u","w","ƿ","v"], c:"C"
},

{
	RPS:[],rps:[],
 ph:"j",
	gr:["Ȝ","g","y","yh"], c:"C"
},

{
	RPS:[],rps:[],
 ph:"h",
	gr:["h"], c:"C"
},

{
	RPS:[],rps:[],
 ph:"m",
	gr:["m","mm"], c:"C"
},

{
	RPS:[],rps:[],
 ph:"n",
	gr:["n","nn","ng"], c:"C"
},

{
	RPS:[],rps:[],
 ph:"l",
	gr:["l","ll"], c:"C"
},

{
RPS:[],rps:[],
 ph:"t",
	gr:["t"], c:"C"
},
	{RPS:[],rps:[],
 ph:"ó",
	gr:["oo"], c:"V"
},
	{RPS:[],rps:[],
 ph:"ie",
	gr:["ie"], c:"V"
},
	{RPS:[],rps:[],
 ph:"ʍ",
	gr:["hw","hƿ","wh","wƿ"], c:"V"
}];


function najdiPhoneme(ktery)
{

	for(mg=0;mg<graphonemes.length;mg++)
	{
	
		if(graphonemes[mg].ph==ktery)
		{
		
			return graphonemes[mg];
		}
	}
}	


var loadRPS=function(txt)
{
	$http.get("php/spl_load.php?t="+txt)
		.then(function(response){
		
		var stare=response.data;
		for(s=0;s<stare.length;s++)
		{
			var phn=najdiPhoneme(stare[s].ph);
			//$log.info(phn.ph+"="+phn.gr);
			phn.RPS.push(stare[s].gr);
			
			var grp=najdiGraph(stare[s].gr);
			//$log.info(phn.ph+"="+phn.gr);
			grp.rps.push(stare[s].ph);
			
		}
			
		
		
		});
	
}

//loadRPS(txt);


function getGrphs()
	{
		return graphonemes;
	}

	

	
function findCandidates(list, word)
{
	
	var rsl=[];
	
	list.forEach(function(l,i){
		
		var rg=new RegExp(l.gr,"i");
		
		if(rg.test(word)==true)
		{
		
		var cnd=matchList(l.gr,word,[]);	
		rsl=rsl.concat(cnd);
			
		}
		
		
	});
	
	console.log("complete list");
	console.log(rsl);
	
	readStructure(rsl,word);
	
}

function matchList(gr,str,rsl)
{
	var nm=matcher(gr,str);
	
	//console.log("matcher result: "+nm);
	
	while(nm!=[])
	{
	//console.log("item "+gr+" found at position "+ni);
		rsl.push(nm);
		var rpl=gr.replace(/./,"-");
		str=str.replace(gr,rpl);
		nm=matcher(gr,str);
	}
	
		return rsl;
	
	function matcher(gr,str)
	{
	var ni=str.indexOf(gr);	
	
	if(ni!=-1)
	{
	var mtch={gr:gr,pos:[ni,ni+gr.length]};
	}
	else
	{
	var mtch=0;
	}
	return mtch;
		
	}
	
}


function readStructure(cnds, word)
{

var inparr=[[{gr:"",pos:[0,0]}]];

var narr=reader(word, cnds, inparr);

while(narr.added.length>0)
{
rsl=narr.old.concat(narr.added);
narr=reader(word,cnds,rsl);
	
}
	
	console.log("reading finished");
	console.log(rsl);
	
	function reader(word, cnds, inparr)
	{
		var outarr=[];
		var old=[];
		
		inparr.forEach(function(ar,ia){
		
		
		var chng=0;
		
			cnds.forEach(function(cn,ic){
				
				if(ar.slice(-1)[0].pos[1]==cn.pos[0])
				{
					outarr.push(ar.concat([cn]));
					//console.log("adding new");
					chng=1;
					
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
	getPhgrs:getPhgrs, getGrphs:getGrphs, najdiGraph:najdiGraph, najdiPhoneme:najdiPhoneme
};
	
	});
	
	
	
	angular
	.module("spellingy")
	.factory("actFactory",function($log){
		
	//vyhledat vyskyty znaku v textu	
	function zvyraznit(co,kr,jak,occs)
{
//var txt=document.getElementById("hledat"+zdroj).value;

if(co=="undefined"||co==null)
{
zdroj=new RegExp($("#hledat").val());
krit=document.getElementById("field").value;
jak=barva;	
}
else
{
	zdroj=new RegExp(".*"+co+".*");
	krit=kr;
	
}



for(i in texty)
{

for(r=0;r<texty[i].length;r++)
{

var rtz="";
nhr=0;

for(s=0;s<texty[i][r]["sl"].length;s++)
	{
	
	if(texty[i][r]["sl"][s][krit].match(zdroj)==texty[i][r]["sl"][s][krit])
	{
	
occs.push(texty[i][r]["sl"][s]);
	
	$("#t"+i+"r"+r+"s"+s).addClass(jak);
		
	}

	}
	

}

	
}

}
	
	// vyhledat alternativni varianty lexelu
	
function dalsiMoznosti(lx)
{

	var vystup=[];
	for(i in texty)
	{
	for(r=0;r<texty[i].length;r++)
	{

		for(s=0;s<texty[i][r]["sl"].length;s++)
		{
		
			if(texty[i][r]["sl"][s].l==lx)
			{
			$log.info(texty[i][r]["sl"][s].f);
			vystup.push(texty[i][r]["sl"][s].f);
			}

		}
	

	}
	}
	return vystup;
}
	


return {
zvyraznit:zvyraznit, dalsiMoznosti:dalsiMoznosti
};	
		
	});
	

  
	
angular
	.module("spellingy")
	.factory("phgrsFactory",function(){

var phonographs=[
{gr:'yh',ph:['j']},

{gr:'Ƿ',ph:['w']},

{gr:'rr',ph:['r']},

{gr:'r',ph:['r']},

{gr:'ll',ph:['l','l']},

{gr:'l',ph:['l','l']},

{gr:'nn',ph:['n','n']},

{gr:'n',ph:['n','n']},

{gr:'mm',ph:['m','m']},

{gr:'m',ph:['m','m']},

{gr:'qw',ph:['ʍ']},

{gr:'qu',ph:['ʍ']},

{gr:'quh',ph:['ʍ']},

{gr:'wh',ph:['ʍ']},

{gr:'gh',ph:['x']},

{gr:'Ȝh',ph:['x']},

{gr:'h',ph:['x','h']},

{gr:'ssch',ph:['ʃ']},

{gr:'ssh',ph:['ʃ']},

{gr:'sc',ph:['ʃ']},

{gr:'sch',ph:['ʃ']},

{gr:'sh',ph:['ʃ']},

{gr:'z',ph:['z']},

{gr:'Ȝ',ph:['z','x','j']},

{gr:'s',ph:['z','ʃ']},

{gr:'ss',ph:['s','ʃ']},

{gr:'thþ',ph:['θ']},

{gr:'þþ',ph:['θ']},

{gr:'th',ph:['θ','ð']},

{gr:'ð',ph:['θ','ð']},

{gr:'þ',ph:['θ','ð']},

{gr:'fu',ph:['v']},

{gr:'ph',ph:['f']},

{gr:'ff',ph:['f','f']},

{gr:'f',ph:['f','v']},

{gr:'gu',ph:['g']},

{gr:'ʒ',ph:['g']},

{gr:'dg',ph:['d͡ʒ']},

{gr:'j',ph:['d͡ʒ']},

{gr:'ng',ph:['d͡ʒ','n','n']},

{gr:'g',ph:['d͡ʒ','g','x','j']},

{gr:'gg',ph:['d͡ʒ','g']},

{gr:'dd',ph:['d']},

{gr:'bb',ph:['b']},

{gr:'b',ph:['b']},

{gr:'cu',ph:['k']},

{gr:'ck',ph:['k']},

{gr:'kk',ph:['k']},

{gr:'q',ph:['k']},

{gr:'k',ph:['k']},

{gr:'cch',ph:['c']},

{gr:'ch',ph:['c','x']},

{gr:'c',ph:['c','k']},

{gr:'tt',ph:['t']},

{gr:'pp',ph:['p']},

{gr:'p',ph:['p']},

{gr:'oy',ph:['oj','uj']},

{gr:'oi',ph:['oj','uj']},

{gr:'eaw',ph:['ew']},

{gr:'eouw',ph:['ew']},

{gr:'yw',ph:['iw','c']},

{gr:'iu',ph:['iw','c']},

{gr:'w',ph:['iw','c','ʍ','w']},

{gr:'ew',ph:['iw','ew','c']},

{gr:'eow',ph:['iw','ew']},

{gr:'iw',ph:['iw','iw','c']},

{gr:'aw',ph:['aw','ow']},

{gr:'au',ph:['aw','ow']},

{gr:'æȜ',ph:['aj']},

{gr:'aȜ',ph:['aj']},

{gr:'eȜ',ph:['aj']},

{gr:'æi',ph:['aj']},

{gr:'y-e',ph:['y:']},

{gr:'uy',ph:['y:']},

{gr:'ui',ph:['y:','iw','uj','c']},

{gr:'u-e',ph:['ɵ:','iw','c']},

{gr:'ov',ph:['u:']},

{gr:'ow',ph:['u:','ow']},

{gr:'uw',ph:['u:','iw','ew']},

{gr:'o-e',ph:['o','ɵ:']},

{gr:'ou',ph:['o','u:','ow']},

{gr:'oo',ph:['o']},

{gr:'oa',ph:['ɔ:']},

{gr:'ay',ph:['a:','aj']},

{gr:'ai',ph:['a:','aj']},

{gr:'aa',ph:['a:']},

{gr:'e-e',ph:['ɛ:']},

{gr:'ee',ph:['e:','ɛ:']},

{gr:'eu',ph:['e:','ɵ:','iw','ew','c']},

{gr:'eo',ph:['e:','ɵ:']},

{gr:'i-e',ph:['i:']},

{gr:'ei',ph:['i:','e:','aj']},

{gr:'ey',ph:['i:','aj']},

{gr:'ij',ph:['i:']},

{gr:'ii',ph:['i:']},

{gr:'v',ph:['u','v','w']},

{gr:'ea',ph:['a','ɛ:']},

{gr:'æ',ph:['a','ɛ:']},

{gr:'a',ph:['a','a:','ɔ:']},

{gr:'e',ph:['e','a','e:','ɛ:','ə']},

{gr:'o',ph:['ɵ','o','u','e:','ɔ:','o','ɵ:']},

{gr:'oe',ph:['ɵ','e:','o','ɵ:']},

{gr:'ue',ph:['ɵ','e:','ɵ:']},

{gr:'u',ph:['i','ɵ','u','y','e:','u:','ɵ:','y:','iw','c','v','w']},

{gr:'y',ph:['i','i:','y:','j']},

{gr:'i',ph:['i','i:','d͡ʒ']}
];
	


function getPhgrs()
	{
		return phonographs;
	}
	
	//graphonemes
		var graphonemes= [
{
	ph:"i",
	gr:["i","y","u"]
},

{
	ph:"ɵ",
	gr:["ue","oe","o","u"]
},

{
	ph:"e",
	gr:["e"]
},

{
	ph:"a",
	gr:["a","æ","e","ea"]
},

{
	ph:"o",
	gr:["o"]
},

{
	ph:"u",
	gr:["u","v","o"]
},

{
	ph:"y",
	gr:["u"]
},

//
{
	ph:"i:",
	gr:["i","ii","ij","y","ey","ei","i-e"]
},

{
	ph:"e:",
	gr:["e","eo","oe","ue","o","eu","u","ee","ei"]
},

{
	ph:"ɛ:",
	gr:["ea","æ","e","ee","e-e"]
},

{
	ph:"a:",
	gr:["a","aa","ai","ay"]
},

{
	ph:"ɔ:",
	gr:["a","oa","o"]
},

{
	ph:"o",
	gr:["o","oo","ou","oe","o-e"]
},

//
{
	ph:"u:",
	gr:["u","uw","ow","ou","ov"]
},

{
	ph:"ɵ:",
	gr:["eo","oe","o","ue","u","eu","o-e","u-e"]
},

{
	ph:"y:",
	gr:["y","u","ui","uy","y-e"]
},

{
	ph:"ə",
	gr:["e"]
},

{
	ph:"aj",
	gr:["æi","ei","ey","eȜ","aȜ","æȜ","ai","ay"]
},

{
	ph:"aw",
	gr:["au","aw"]
},

//
{
	ph:"ow",
	gr:["au","aw","ow","ou"]
},

{
	ph:"iw",
	gr:["iw","eow","uw","eu","ew","u","w","iw","iu","yw","ui","u-e"]
},

{
	ph:"ew",
	gr:["eouw","eow","uw","eaw","ew","eu"]
},

{
	ph:"oj",
	gr:["oi","oy"]
},

{
	ph:"uj",
	gr:["oi","oy","ui"]
},

{
	ph:"p",
	gr:["p","pp"]
},
//
{
	ph:"t",
	gr:["tt"]
},

{
	ph:"c",
	gr:["c","ch","cch","eu","ew","u","w","iw","iu","yw","ui","u-e"]
},

{
	ph:"k",
	gr:["c","k","q","kk","ck","cu"]
},

{
	ph:"b",
	gr:["b","bb"]
},

{
	ph:"d",
	gr:["dd"]
},

{
	ph:"d͡ʒ",
	gr:["gg","g","ng","i","j","dg"]
},

//
{
	ph:"g",
	gr:["g","ʒ","gu","gg"]
},

{
	ph:"f",
	gr:["f","ff","ph","ff"]
},

{
	ph:"v",
	gr:["f","u","fu","v"]
},

{
	ph:"θ",
	gr:["þ","ð","th","þþ","thþ"]
},

{
	ph:"ð",
	gr:["þ","ð","th"]
},

{
	ph:"s",
	gr:["ss"]
},


//
{
	ph:"z",
	gr:["s","Ȝ","z"]
},

{
	ph:"ʃ",
	gr:["s","sh","sch","ss","sc","ssh","ssch"]
},

{
	ph:"x",
	gr:["h","Ȝ","g","Ȝh","gh","ch"]
},

{
	ph:"ʍ",
	gr:["wh","w","quh","qu","qw"]
},

{
	ph:"m",
	gr:["m","mm"]
},

{
	ph:"n",
	gr:["n","nn","ng"]
},

{
	ph:"l",
	gr:["l","ll"]
},

//
{
	ph:"r",
	gr:["r","rr"]
},

{
	ph:"w",
	gr:["u","w","Ƿ","v"]
},

{
	ph:"j",
	gr:["Ȝ","g","y","yh"]
},

{
	ph:"h",
	gr:["h"]
},

{
	ph:"m",
	gr:["m","mm"]
},

{
	ph:"n",
	gr:["n","nn","ng"]
},

{
	ph:"l",
	gr:["l","ll"]
}];

function getGrphs()
	{
		return graphonemes;
	}

	
	
return {
	getPhgrs:getPhgrs, getGrphs:getGrphs
};
	
	});
	
	
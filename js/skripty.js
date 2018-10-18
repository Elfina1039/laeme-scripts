// JavaScript Document

 var napoveda=0;
 var canvas;
 var context;
 
$(document).ready(function(){
$("div[class=napoveda]").dblclick(function()
{

$(this).animate({left:'-470%'}, "slow").animate({height:'100%'}, "slow").animate({width:'400%'}, "slow");
$("input[class=zavrit]").css("display","block");

$(this).css("overflow","scroll");
napoveda=1;
});

$("div[class=napoveda]").mouseenter(function()
{
if(napoveda==0)
{
popisek(event.pageX, event.pageY, "2x klikni");
}

});

$("div[class=napoveda]").mouseleave(function()
{
skryj();
});

$("input[class=zavrit]").click(function()
{
$("div[class=napoveda]").css("overflow","hidden");
$("div[class=napoveda]").animate({height:'1.5em'}, "slow").animate({width:'70%'}, "slow").animate({left:'0em'}, "slow");
$("input[class=zavrit]").css("display","none");

napoveda = 0;
});


canvas = document.getElementById("levlidlo");
context = canvas.getContext("2d");


levlidlit(celkem, zbyva);

});

function popisek(x,y,popisek)
{
$("body").append("<div id='vpopis'  style='position:absolute; left:"+x+"px; top:"+y+"px;background-color:rgba(44,130,205,0.8); font-weight:bold; border-radius:0.2em; padding:0.2em;'>"+popisek+"</div>");
}

function skryj()
{
$("#vpopis").remove();
}

function levlidlit(celkem, zbyva)
{

var proc = (celkem/100);
var jeste = (celkem-zbyva)/proc;
var delka = Math.round(canvas.width*(jeste/100));


with(context)
{

var pruh = createLinearGradient(0,0,canvas.width,0);
pruh.addColorStop(0,"rgb(238,210,41)");
pruh.addColorStop(1,"rgb(44,130,205)");


fillStyle="rgb(0,0,0)";
fillRect(0,0,canvas.width,canvas.height);

fillStyle=pruh;
fillRect(0,0,delka,canvas.height);




}
}


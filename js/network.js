console.log("NETWORK.JS loading");
var nodes=[];
var links=[];

var colors=new Object();
colors.definitions="green";
colors.synonyms="yellow";
colors.hyperonym="white";
colors.hyponym="orange";
colors.derivation="silver";

var network;


function loadData(feed, filter)
{
nodes=[];
links=[];
 list=[];
 dlist=[];
   
	console.log("FEED:");
    console.log(feed);
	
//nodes.push({"label":"TEXT","id":"TEXT",color:"red"});
	
	feed.forEach(function(slot){
		
        if($.inArray(slot.cd,filter)!=-1)
           {
           		if(slot.lits.length>1)
		{
			barva="orange";
		}
		else
		{
			barva="blue";
		}
		
		
		nodes.push({"label":slot.cd,"id":"P/"+slot.cd,color:barva});
		//links.push({"from":slot.cd, "to":"TEXT", arrows:"to"});
		
		slot.lits.forEach(function(lit){
		
		
			if($.inArray(lit,list)==-1)
			{
			nodes.push({"label":lit,"id":lit,color:"yellow"});	
			list.push(lit);
			
			}
			
			links.push({"from":"P/"+slot.cd, "to":lit, arrows:"to"});
			
		});
           }

		
		
	});
	
      var options = { 
 
  layout: {
    
	 hierarchical: {
                direction: "UD",
                sortMethod: "directed",
				levelSeparation:600,
				
            }
  },
  nodes:{
	font:"20px Arial black",
	 scaling:{
	min:1000,
	max:2000
  }
  },


	physics: {
            enabled: false
        },
  height: '700px',
  width: '1000px',
  interaction:{hover:true,navigationButtons: true,
          keyboard: true, selectable:true, selectConnectedEdges:true}
  };
  


drawNetwork(nodes,links,options);	

	
}


function networkAlts(feed)
{
    console.log("network");
    var oNodes={};
   nodes=[];
links=[];
 list=[];
 dlist=[];
    
     nodes.push({"label":"EA in 6","id":"CORE",color:"red"});
    
    for(i=4;i<=10;i++)
        {
            nodes.push({"label":i,"id":"t/"+i,color:"red"});
            links.push({"from":"CORE", "to":"t/"+i, arrows:"to"});
        }
	
//nodes.push({"label":"TEXT","id":"TEXT",color:"red"});
	
	feed.forEach(function(slot){
		
		
		//	if(oNodes[slot.text+"/"+slot.rps]==undefined || oNodes[slot.text+"/"+slot.rps]==null )
		//	{
		//	oNodes[slot.text+"/"+slot.rps]={"label":slot.text+"/"+slot.rps,"id":slot.text+"/"+slot.rps,color:"yellow", ls:slot.slot};	
         //   links.push({"from":"t/"+slot.text, "to":slot.text+"/"+slot.rps, arrows:"to"});
		//	}
        
        slot.lst.forEach(function(itm){
            if(oNodes[itm[0]]==undefined || oNodes[itm[0]]==null )
			{
			oNodes[itm[0]]={"label":itm[0],"id":itm[0],color:"yellow"};	
          
			}
        
   
         links.push({"from":"t/"+slot.text, "to":itm[0], arrows:"to"});
        });
        
        
		
           

});
    
    for(o in oNodes)
        {
            nodes.push(oNodes[o]);
        }
      var options = { 
 
  layout: {
    
	 hierarchical: {
                direction: "UD",
                sortMethod: "directed",
				levelSeparation:400,
				
            }
  },
  nodes:{
	font:"20px Arial black",
	 scaling:{
	min:1000,
	max:2000
  }
  },


	physics: {
            enabled: false
        },
  height: '700px',
  width: '1000px',
  interaction:{hover:true,navigationButtons: true,
          keyboard: true, selectable:true, selectConnectedEdges:true}
  };
  
   // console.log(links);
    drawNetwork(nodes, links,options);
    
}

	

	   


function drawNetwork(nodes,links,options)
{
	 var nds = new vis.DataSet(nodes);

  // create an array with edges
  var edgs = new vis.DataSet(links);

  // create a network
  var container = document.getElementById('displayDiv');
  var data = {
    nodes: nds,
    edges: edgs
  };

  network = new vis.Network(container, data, options);
  
	network.on("click", function (params) {
        console.log('clickNode Event:', params.nodes[0]);
    });
  
}

console.log("NETWORK.JS loaded");

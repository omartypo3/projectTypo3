//	HYPE.documents["Wagner_Flexio_300x250_expandable"]

(function HYPE_DocumentLoader() {
	var resourcesFolderName = "Wagner_Flexio_300x250_expandable.hyperesources";
	var documentName = "Wagner_Flexio_300x250_expandable";
	var documentLoaderFilename = "wagnerflexio300x250expandable_hype_generated_script.js";
	var mainContainerID = "wagnerflexio300x250expandable_hype_container";

	// find the URL for this script's absolute path and set as the resourceFolderName
	try {
		var scripts = document.getElementsByTagName('script');
		for(var i = 0; i < scripts.length; i++) {
			var scriptSrc = scripts[i].src;
			if(scriptSrc != null && scriptSrc.indexOf(documentLoaderFilename) != -1) {
				resourcesFolderName = scriptSrc.substr(0, scriptSrc.lastIndexOf("/"));
				break;
			}
		}
	} catch(err) {	}

	// Legacy support
	if (typeof window.HYPE_DocumentsToLoad == "undefined") {
		window.HYPE_DocumentsToLoad = new Array();
	}
 
	// load HYPE.js if it hasn't been loaded yet
	if(typeof HYPE_160 == "undefined") {
		if(typeof window.HYPE_160_DocumentsToLoad == "undefined") {
			window.HYPE_160_DocumentsToLoad = new Array();
			window.HYPE_160_DocumentsToLoad.push(HYPE_DocumentLoader);

			var headElement = document.getElementsByTagName('head')[0];
			var scriptElement = document.createElement('script');
			scriptElement.type= 'text/javascript';
			scriptElement.src = resourcesFolderName + '/' + 'HYPE.js?hype_version=160';
			headElement.appendChild(scriptElement);
		} else {
			window.HYPE_160_DocumentsToLoad.push(HYPE_DocumentLoader);
		}
		return;
	}
	
	// handle attempting to load multiple times
	if(HYPE.documents[documentName] != null) {
		var index = 1;
		var originalDocumentName = documentName;
		do {
			documentName = "" + originalDocumentName + "-" + (index++);
		} while(HYPE.documents[documentName] != null);
		
		var allDivs = document.getElementsByTagName("div");
		var foundEligibleContainer = false;
		for(var i = 0; i < allDivs.length; i++) {
			if(allDivs[i].id == mainContainerID && allDivs[i].getAttribute("HYPE_documentName") == null) {
				var index = 1;
				var originalMainContainerID = mainContainerID;
				do {
					mainContainerID = "" + originalMainContainerID + "-" + (index++);
				} while(document.getElementById(mainContainerID) != null);
				
				allDivs[i].id = mainContainerID;
				foundEligibleContainer = true;
				break;
			}
		}
		
		if(foundEligibleContainer == false) {
			return;
		}
	}
	
	var hypeDoc = new HYPE_160();
	
	var attributeTransformerMapping = {b:"i",c:"i",bC:"i",d:"i",aS:"i",M:"i",e:"f",aT:"i",N:"i",f:"d",O:"i",g:"c",aU:"i",P:"i",Q:"i",aV:"i",R:"c",bG:"f",aW:"f",aI:"i",S:"i",bH:"d",l:"d",aX:"i",T:"i",m:"c",bI:"f",aJ:"i",n:"c",aK:"i",bJ:"f",X:"i",aL:"i",A:"c",aZ:"i",Y:"bM",B:"c",bK:"f",bL:"f",C:"c",D:"c",t:"i",E:"i",G:"c",bA:"c",a:"i",bB:"i"};
	
	var resources = {"10":{n:"video_thumb.jpg",p:1},"2":{n:"fonts.css"},"3":{n:"indoor_300.jpg",p:1},"11":{n:"logo_paint_smart_smaller.png",p:1},"4":{n:"outdoor_300.jpg",p:1},"5":{n:"1%20Kopie.png",p:1},"12":{n:"logo_paint_smart_small.png",p:1},"6":{n:"2%20Kopie.png",p:1},"13":{n:"sprayer_370.mp4"},"7":{n:"3%20Kopie.png",p:1},"0":{n:"Stratum1-Black.ttf.js"},"8":{n:"4%20Kopie-1.png",p:1},"14":{n:"sprayer_370.oggtheora.ogv"},"1":{n:"Stratum1-Medium.ttf.js"},"9":{n:"4_big.png",p:1}};
	
	var scenes = [{x:0,p:"600px",c:"#FFFFFF",onSceneTimelineCompleteActions:[{type:1,transition:1,sceneSymbol:1}],v:{"10":{k:"div",x:"visible",c:300,d:250,z:"5",e:"1.000000",a:200,j:"absolute",b:0},"2":{aU:8,G:"#F80217",c:260,aV:8,r:"inline",d:25,e:"0.000000",t:36,Y:"30px",Z:"break-word",w:"<div style=\"font-family: stratum_black;\">SO ADVANCED</div>",bF:"10",j:"absolute",x:"visible",k:"div",y:"preserve",z:"1",aS:8,aT:8,a:4,F:"center",b:89},"9":{k:"div",x:"hidden",c:300,d:250,z:"10",r:"inline",a:200,j:"absolute",e:"1.000000",b:0},"26":{o:"content-box",h:"7",p:"no-repeat",a:0,x:"visible",q:"100% 100%",b:0,j:"absolute",r:"inline",c:300,k:"div",z:"4",d:250,bF:"28",e:"0.000000"},"11":{c:300,d:40,I:"None",e:"0.000000",J:"None",t:16,K:"None",g:"#000000",L:"None",M:0,w:"",bF:"9",A:"#A0A0A0",x:"visible",j:"absolute",k:"div",N:0,O:0,B:"#A0A0A0",z:"3",P:0,D:"#A0A0A0",C:"#A0A0A0",a:0,b:210},"32":{c:1,d:145,I:"None",e:"1.000000",J:"None",K:"None",g:"#FFFFFF",L:"None",M:0,bF:"28",N:0,A:"#A0A0A0",x:"visible",j:"absolute",B:"#A0A0A0",k:"div",O:0,P:0,z:"1",C:"#A0A0A0",D:"#A0A0A0",a:0,b:0},"4":{aU:8,G:"#F80217",c:248,aV:8,r:"inline",d:197,e:"0.000000",t:28,Y:"30px",Z:"break-word",w:"<div style=\"font-family: stratum_black;\">IT DOES THINGS<br>A PAINT BRUSH<br>CAN ONLY<br>DREAM OF.</div>",bF:"10",j:"absolute",x:"visible",k:"div",y:"preserve",z:"3",aS:8,aT:8,a:10,b:8},"64":{c:298,d:248,I:"Solid",J:"Solid",K:"Solid",L:"Solid",aP:"pointer",M:1,N:1,A:"#A0A0A0",x:"visible",j:"absolute",B:"#A0A0A0",k:"div",aA:[{type:4,javascriptOid:"31"}],O:1,z:"11",P:1,D:"#A0A0A0",C:"#A0A0A0",a:200,b:0},"27":{o:"content-box",h:"8",p:"no-repeat",a:0,x:"visible",q:"100% 100%",b:0,j:"absolute",r:"inline",c:300,k:"div",z:"5",d:250,bF:"28",e:"0.000000"},"5":{o:"content-box",h:"4",p:"repeat",x:"visible",a:0,b:-40,j:"absolute",r:"inline",c:300,k:"div",z:"5",d:40,bF:"9",e:"1.000000"},"33":{c:300,d:39,I:"None",e:"0.060000",J:"None",K:"None",g:"#DDEEFF",L:"None",M:0,N:0,A:"#A0A0A0",x:"visible",j:"absolute",k:"div",O:0,B:"#A0A0A0",l:"0deg",z:"3",P:0,D:"#A0A0A0",m:"#000000",C:"#A0A0A0",n:"#FFFFFF",a:200,b:211},"6":{o:"content-box",h:"3",p:"repeat",x:"visible",a:-40,b:0,j:"absolute",r:"inline",c:40,k:"div",z:"2",d:250,bF:"9"},"28":{k:"div",x:"visible",c:300,d:250,z:"4",r:"inline",a:0,j:"absolute",bF:"10",b:0},"13":{aV:8,w:"<span style=\"font-family: stratum_black\">INDOOR</span>",a:7,x:"visible",Z:"break-word",y:"preserve",j:"absolute",r:"inline",z:"4",k:"div",bF:"9",aT:8,b:207,t:24,e:"0.000000",aS:8,aU:8,G:"#FFFFFF"},"24":{o:"content-box",h:"5",p:"no-repeat",a:-288,x:"visible",q:"100% 100%",b:0,j:"absolute",r:"inline",c:300,k:"div",z:"2",d:250,bF:"28",e:"1.000000"},"14":{aV:8,w:"<span style=\"font-family: stratum_black\">OUTDOOR</span>",a:7,x:"visible",Z:"break-word",y:"preserve",j:"absolute",r:"inline",z:"8",k:"div",bF:"9",aT:8,b:207,t:24,e:"0.000000",aS:8,aU:8,G:"#FFFFFF"},"20":{G:"#F80217",c:298,d:248,I:"Solid",r:"inline",J:"Solid",K:"Solid",g:"#FFFFFF",L:"Solid",aP:"pointer",M:1,w:"",N:1,A:"#A0A0A0",x:"visible",j:"absolute",k:"div",aA:[{type:4,javascriptOid:"31"}],O:1,B:"#A0A0A0",z:"1",P:1,D:"#A0A0A0",C:"#A0A0A0",a:200,b:0},"25":{o:"content-box",h:"6",p:"no-repeat",a:0,x:"visible",q:"100% 100%",b:0,j:"absolute",r:"inline",c:300,k:"div",z:"3",d:250,bF:"28",e:"0.000000"}},n:"Default",T:{kTimelineDefaultIdentifier:{d:10.09,i:"kTimelineDefaultIdentifier",n:"Main Timeline",a:[{f:"2",t:0,d:0.15,i:"e",e:"1.000000",s:"0.000000",o:"2"},{f:"2",t:0.15,d:1.24,i:"e",e:"1.000000",s:"1.000000",o:"2"},{f:"2",t:2,d:0.15,i:"a",e:0,s:-288,o:"24"},{f:"2",t:2,d:0.15,i:"c",e:231,s:1,o:"32"},{f:"2",t:2.09,d:0.16,i:"e",e:"0.000000",s:"1.000000",o:"2"},{f:"2",t:2.25,d:0.01,i:"e",e:"0.000000",s:"1.000000",o:"32"},{f:"2",t:2.29,d:0.01,i:"e",e:"0.000000",s:"1.000000",o:"24"},{f:"2",t:2.29,d:0.01,i:"e",e:"1.000000",s:"0.000000",o:"25"},{f:"2",t:3,d:0.01,i:"e",e:"1.000000",s:"1.000000",o:"25"},{f:"2",t:3.01,d:0.01,i:"e",e:"1.000000",s:"0.000000",o:"26"},{f:"2",t:3.01,d:0.01,i:"e",e:"0.000000",s:"1.000000",o:"25"},{f:"2",t:3.02,d:0.01,i:"e",e:"1.000000",s:"1.000000",o:"26"},{f:"2",t:3.03,d:0.01,i:"e",e:"1.000000",s:"0.000000",o:"27"},{f:"2",t:3.03,d:0.01,i:"e",e:"0.000000",s:"1.000000",o:"26"},{f:"2",t:3.13,d:0.15,i:"b",e:62,s:0,o:"27"},{f:"2",t:3.13,d:0.15,i:"d",e:188,s:250,o:"27"},{f:"2",t:3.13,d:0.15,i:"c",e:225,s:300,o:"27"},{f:"2",t:3.13,d:0.15,i:"a",e:106,s:0,o:"27"},{f:"2",t:3.13,d:0.15,i:"e",e:"1.000000",s:"0.000000",o:"4"},{f:"2",t:5.24,d:0.15,i:"a",e:0,s:-40,o:"6"},{f:"2",t:5.24,d:0.15,i:"c",e:300,s:40,o:"6"},{f:"2",t:6.09,d:0.15,i:"e",e:"0.250000",s:"0.000000",o:"11"},{f:"2",t:6.09,d:0.15,i:"e",e:"1.000000",s:"0.000000",o:"13"},{f:"2",t:7.24,d:0.15,i:"b",e:0,s:-40,o:"5"},{f:"2",t:7.24,d:0.15,i:"d",e:250,s:40,o:"5"},{f:"2",t:8.09,d:0.15,i:"e",e:"1.000000",s:"0.000000",o:"14"},{f:"2",t:8.11,d:0.01,i:"e",e:"0.000000",s:"1.000000",o:"10"},{f:"2",t:9.24,d:0.15,i:"e",e:"0.000000",s:"1.000000",o:"9"}],f:30}},o:"1"},{x:1,p:"600px",c:"#FFFFFF",v:{"42":{aU:8,G:"#676767",aV:0,r:"inline",e:"1.000000",t:14,Y:"16px",Z:"break-word",w:"<ul id=\"revol-list\" style=\"padding-left: 10px; font-family: stratum_medium;\"><li style=\"margin-bottom: 4px\">Revolutionary iSpray\u00ae\ntechnology</li><li>Most powerful turbine<br>in its class</li></ul>",bF:"41",A:"#000000",x:"visible",j:"absolute",k:"div",y:"preserve",B:"#000000",C:"#000000",z:"1",aS:0,D:"#000000",aT:8,a:0,b:0},"47":{o:"content-box",h:"10",x:"visible",a:0,q:"100% 100%",b:0,j:"absolute",r:"inline",c:66,k:"div",z:"2",d:38,bF:"45"},"43":{o:"content-box",h:"9",x:"visible",a:183,q:"100% 100%",b:15,j:"absolute",r:"inline",c:89,k:"div",z:"3",d:157,bF:"40",e:"0.000000"},"48":{G:"#F80217",c:298,d:248,I:"Solid",r:"inline",J:"Solid",K:"Solid",g:"#FFFFFF",L:"Solid",aP:"pointer",M:1,w:"",N:1,A:"#A0A0A0",x:"visible",j:"absolute",k:"div",aA:[{type:4,javascriptOid:"31"}],O:1,B:"#A0A0A0",z:"1",P:1,D:"#A0A0A0",C:"#A0A0A0",a:200,b:0},"50":{c:300,d:39,I:"None",e:"0.060000",J:"None",K:"None",g:"#DDEEFF",L:"None",M:0,N:0,A:"#A0A0A0",x:"visible",j:"absolute",k:"div",O:0,B:"#A0A0A0",l:"0deg",z:"2",P:0,D:"#A0A0A0",m:"#000000",C:"#A0A0A0",n:"#FFFFFF",a:200,b:211},"44":{aU:2,G:"#676767",c:140,aV:6,I:"Solid",r:"inline",d:56,e:"0.000000",t:24,L:"Solid",Z:"break-word",M:3,w:"<div style=\"font-family: stratum_black; line-height: 19px; font-size: 17px\">THE NEW FLEXiO<sup style=\"vertical-align:top; font-size: 0.4em; line-height: 2em\">TM</sup> INDOOR/OUTDOOR SPRAYER.</div>",bF:"40",A:"#F0C348",j:"absolute",x:"visible",k:"div",y:"preserve",P:3,z:"12",aS:6,D:"#F0C348",aT:2,a:18,b:22},"49":{o:"content-box",h:"11",p:"no-repeat",x:"visible",a:385,q:"100% 100%",b:183,j:"absolute",r:"inline",c:89,k:"div",z:"3",d:56,e:"0.000000"},"40":{k:"div",x:"visible",c:300,d:250,z:"4",r:"inline",a:200,j:"absolute",b:0},"45":{k:"div",aA:[{type:1,transition:1,sceneOid:"34"}],c:160,x:"visible",d:38,z:"18",e:"0.000000",a:225,j:"absolute",aP:"pointer",b:193},"62":{c:298,d:248,I:"Solid",J:"Solid",K:"Solid",L:"Solid",aP:"pointer",M:1,N:1,A:"#A0A0A0",x:"visible",j:"absolute",B:"#A0A0A0",k:"div",aA:[{type:4,javascriptOid:"31"}],O:1,z:"5",P:1,D:"#A0A0A0",C:"#A0A0A0",a:200,b:0},"41":{k:"div",x:"visible",c:153,d:92,z:"2",e:"0.000000",a:10,j:"absolute",bF:"40",b:97},"46":{aU:8,G:"#F80217",c:76,aV:8,r:"inline",d:17,e:"1.000000",t:14,Z:"break-word",w:"<span style=\"font-family: stratum_black;\">view video</span>",bF:"45",j:"absolute",x:"visible",k:"div",y:"preserve",z:"1",aS:8,aT:8,a:69,b:1}},n:"Final Banner",T:{kTimelineDefaultIdentifier:{d:2,i:"kTimelineDefaultIdentifier",n:"Main Timeline",a:[{f:"2",t:0,d:0.15,i:"e",e:"1.000000",s:"0.000000",o:"44"},{f:"2",t:0.15,d:0.15,i:"e",e:"1.000000",s:"0.000000",o:"43"},{f:"2",t:1,d:0.15,i:"e",e:"1.000000",s:"0.000000",o:"41"},{f:"2",t:1.15,d:0.15,i:"e",e:"1.000000",s:"0.000000",o:"45"},{f:"2",t:1.15,d:0.15,i:"e",e:"1.000000",s:"0.000000",o:"49"}],f:30}},o:"39"},{x:2,p:"600px",c:"#FFFFFF",v:{"65":{c:558,d:298,I:"Solid",J:"Solid",K:"Solid",L:"Solid",aP:"pointer",M:1,N:1,A:"#A0A0A0",x:"visible",j:"absolute",B:"#A0A0A0",k:"div",aA:[{type:4,javascriptOid:"31"}],O:1,z:"8",P:1,D:"#A0A0A0",C:"#A0A0A0",a:0,b:0},"52":{aV:8,w:"<span style=\"font-family: stratum_black;\">X Close</span>",a:498,x:"visible",Z:"break-word",y:"preserve",aE:[],r:"inline",aA:[{type:1,transition:1,sceneOid:"39"},{timelineIdentifier:"kTimelineDefaultIdentifier",type:9,goToTime:2},{type:4,javascriptOid:"53"}],k:"div",z:"10",aT:8,j:"absolute",t:12,aP:"pointer",b:4,aU:8,G:"#9A9A9A",aS:8},"55":{aU:8,G:"#676767",aV:0,r:"inline",e:"1.000000",t:13,Y:"16px",Z:"break-word",w:"<ul id=\"revol-list\" style=\"padding-left: 10px; font-family: stratum_medium;\"><li style=\"margin-bottom: 4px\">Revolutionary iSpray\u00ae\ntechnology</li><li>Most powerful turbine<br>in its class</li></ul>",bF:"54",A:"#000000",x:"visible",j:"absolute",k:"div",y:"preserve",B:"#000000",C:"#000000",z:"2",aS:0,D:"#000000",aT:8,a:0,b:0},"58":{o:"content-box",h:"12",x:"visible",a:442,q:"100% 100%",b:226,j:"absolute",r:"inline",c:102,k:"div",z:"5",d:64},"35":{c:558,d:298,I:"Solid",J:"Solid",K:"Solid",g:"#FFFFFF",L:"Solid",aP:"pointer",M:1,v:"bold",i:"expanded_box",w:"",bF:"54",A:"#A0A0A0",j:"absolute",aA:[{type:4,javascriptOid:"31"}],k:"div",N:1,O:1,x:"visible",z:"1",B:"#A0A0A0",D:"#A0A0A0",P:1,C:"#A0A0A0",a:-397,b:-104},"56":{aU:0,G:"#676767",c:137,aV:5,I:"Solid",r:"inline",d:56,e:"1.000000",t:16,L:"Solid",Z:"break-word",M:3,w:"<div style=\"font-family: stratum_black;line-height:1em;\">THE NEW FLEXiO<sup style=\"vertical-align:top; font-size: 0.4em; line-height: 2em\">TM</sup> INDOOR/OUTDOOR SPRAYER.</div>",A:"#F0C348",x:"visible",j:"absolute",k:"div",y:"preserve",P:3,z:"4",aS:1,D:"#F0C348",aT:2,a:405,b:39},"59":{aR:"0",x:"visible",i:"video",bE:[{type:"video/mp4",filename:"13"},{type:"video/ogg",filename:"14"}],a:15,j:"absolute",b:39,c:370,k:"video",z:"9",d:208,aO:"1",aQ:"0",aH:"1"},"54":{k:"div",x:"visible",c:153,d:92,z:"2",e:"1.000000",a:397,j:"absolute",b:104},"57":{aU:8,G:"#F80217",c:128,aE:[{type:0}],aV:8,r:"inline",d:17,e:"1.000000",t:16,Z:"break-word",aP:"pointer",w:"<span style=\"font-family: stratum_black;\">learn more &gt;</span>",j:"absolute",x:"visible",aA:[],k:"div",y:"preserve",aB:[{type:0}],z:"7",aS:8,aC:[{type:0}],aT:8,a:407,aD:[{type:0}],b:186}},n:"Expanded",onSceneLoadActions:[{type:4,javascriptOid:"51"}],T:{kTimelineDefaultIdentifier:{d:15.03,i:"kTimelineDefaultIdentifier",n:"Main Timeline",a:[{t:0,p:1,i:"Video Track",d:15.03,o:"59",f:"2"}],f:30}},o:"34"}];
	
	var javascripts = [{name:"clickthrough",source:"function(hypeDocument, element, event) {\t\n\tEB.clickthrough();\n}",identifier:"31"},{name:"expand",source:"function(hypeDocument, element, event) {\t\n//\tvar id = hypeDocument.documentName().replace(/_/g, '').toLowerCase() + '_hype_container';\n//\tvar container = document.getElementById(id);\n\t\n//\tcontainer.style.width = \"560px\";\n//\tcontainer.style.height = \"300px\";\n\t\n//\tvar expanded_box = document.getElementById('expanded_box').parentNode.parentNode;\n//\texpanded_box.style.width = \"560px\";\n//\texpanded_box.style.height = \"300px\";\n\n\tEB.expand();\n}",identifier:"51"},{name:"collapse",source:"function(hypeDocument, element, event) {\t\n\tEB.collapse();\n}",identifier:"53"}];
	
	var functions = {};
	var javascriptMapping = {};
	for(var i = 0; i < javascripts.length; i++) {
		try {
			javascriptMapping[javascripts[i].identifier] = javascripts[i].name;
			eval("functions." + javascripts[i].name + " = " + javascripts[i].source);
		} catch (e) {
			hypeDoc.log(e);
			functions[javascripts[i].name] = (function () {});
		}
	}
	
	hypeDoc.setAttributeTransformerMapping(attributeTransformerMapping);
	hypeDoc.setResources(resources);
	hypeDoc.setScenes(scenes);
	hypeDoc.setJavascriptMapping(javascriptMapping);
	hypeDoc.functions = functions;
	hypeDoc.setCurrentSceneIndex(0);
	hypeDoc.setMainContentContainerID(mainContainerID);
	hypeDoc.setResourcesFolderName(resourcesFolderName);
	hypeDoc.setShowHypeBuiltWatermark(0);
	hypeDoc.setShowLoadingPage(false);
	hypeDoc.setDrawSceneBackgrounds(false);
	hypeDoc.setGraphicsAcceleration(true);
	hypeDoc.setDocumentName(documentName);

	HYPE.documents[documentName] = hypeDoc.API;
	document.getElementById(mainContainerID).setAttribute("HYPE_documentName", documentName);

	hypeDoc.documentLoad(this.body);
}());


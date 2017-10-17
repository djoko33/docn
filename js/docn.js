function getElements(id) {
  if (typeof id == "object") {
    return [id];
  } else {
    return document.querySelectorAll(id);
  }
};

function sortHTML(id, sel, sortvalue) {
  var a, b, i, ii, y, bytt, v1, v2, cc, j;
  a = getElements(id);
  for (i = 0; i < a.length; i++) {
    for (j = 0; j < 2; j++) {
      cc = 0;
      y = 1;
      while (y == 1) {
        y = 0;
        b = a[i].querySelectorAll(sel);
        for (ii = 0; ii < (b.length - 1); ii++) {
          bytt = 0;
          if (sortvalue) {
            v1 = b[ii].querySelector(sortvalue).innerHTML.toLowerCase();
            v2 = b[ii + 1].querySelector(sortvalue).innerHTML.toLowerCase();
          } else {
            v1 = b[ii].innerHTML.toLowerCase();
            v2 = b[ii + 1].innerHTML.toLowerCase();
          }
          if ((j == 0 && (v1 > v2)) || (j == 1 && (v1 < v2))) {
            bytt = 1;
            break;
          }
        }
        if (bytt == 1) {
          b[ii].parentNode.insertBefore(b[ii + 1], b[ii]);
          y = 1;
          cc++;
        }
      }
      if (cc > 0) {break;}
    }
  }
};


function addRow(table, el){
	var row=table.insertRow();
	for (i = 0; i < el.length; i++) { 
		var x=row.insertCell(i);
		var xValue = document.createTextNode(el[i]);
		x.appendChild(xValue);
	}
}

function addTh(table, el, cl){
	var row=table.insertRow();
	row.setAttribute('class', cl);
	for (i = 0; i < el.length; i++) { 
		var x=document.createElement('th');
		x.setAttribute('onclick', "sortHTML('#lstActions','.action', 'td:nth-child("+i+")')");
		var xValue = document.createTextNode(el[i]);
		x.appendChild(xValue);
		row.appendChild(x);
	}
}
function createLink(url, text){
	var link=document.createElement("a");
	link.setAttribute('href', url);
	var xValue = document.createTextNode(text);
	link.appendChild(xValue);
	return link;
}

function createButton(pa, target, label){
	var but=document.createElement("button");
	but.setAttribute('type', "button");
	but.setAttribute('class', "btn btn-default");
	but.setAttribute('data-toggle', "modal");
	but.setAttribute('data-target', target);
	but.setAttribute('data-whatever', pa);
	var xValue = document.createTextNode(label);
	but.appendChild(xValue);
	return but;
}

function addRowLink(table, cl, el, url){
	var row=table.insertRow();
	row.setAttribute('class', cl);
	var link=createLink(url, el[0]);
	var x=row.insertCell(0);
	x.appendChild(link);
	for (i = 1; i < el.length; i++) {
		var x=row.insertCell(i);
		var xValue = document.createTextNode(el[i]);
		x.appendChild(xValue);
	}
}

function addRowLinkStatutPa(table, cl, el, url){
	var row=table.insertRow();
	row.setAttribute('class', cl);
	var link=createLink(url+el[0], el[0]);
	var x=row.insertCell(0);
	x.appendChild(link);
	stat=new Array('', 'NOUVEAU', 'SOUMIS', 'NOTIFIE', 'APPROUVE')
	for (i = 1; i < el.length; i++) {
		var x=row.insertCell(i);
		var link=createLink(url+el[0]+'&statut='+stat[i], el[i]);
		x.appendChild(link);
	}
}

function addRowLinkStatutActions(table, cl, el, url){
	var row=table.insertRow();
	row.setAttribute('class', cl);
	var link=createLink(url+el[0], el[0]);
	var x=row.insertCell(0);
	x.appendChild(link);
	stat=new Array('', 'NOUVEAU', 'NOTFPRI', 'NOTFSEC', 'ACCPRI', 'ACCSEC', 'ATTCLOT', 'CLOTURE', 'ANNULE')
	for (i = 1; i < el.length; i++) {
		var x=row.insertCell(i);
		var link=createLink(url+el[0]+'&statut='+stat[i], el[i]);
		x.appendChild(link);
	}
}

function addRowLinkButton(table, cl, el, url, pa, mActions, mNotes){
	var row=table.insertRow();
	row.setAttribute('class', cl);
	var link=createLink(url, el[0]);
	link.setAttribute('target', "_blank");
	var x=row.insertCell(0);
	x.appendChild(link);
	for (i = 1; i < el.length; i++) { 
		var x=row.insertCell(i);
		var xValue = document.createTextNode(el[i]);
		x.appendChild(xValue);
	}
	var x=row.insertCell(el.length);
	x.appendChild(createButton(pa, mNotes, 'Notes'));
	var x=row.insertCell(el.length+1);
	x.appendChild(createButton(pa, mActions, 'Actions'));
}

function addRowLinkButtonActions(table, cl, el, url, pa, mNotes){
	var row=table.insertRow();
	row.setAttribute('class', cl);
	var link=createLink(url, el[0]);
	link.setAttribute('target', "_blank");
	var x=row.insertCell(0);
	x.appendChild(link);
	for (i = 1; i < el.length; i++) { 
		var x=row.insertCell(i);
		var xValue = document.createTextNode(el[i]);
		x.appendChild(xValue);
	}
	var x=row.insertCell(el.length);
	x.appendChild(createButton(pa, mNotes, 'Notes'));
}
function tabRetard(nb, nomTab){
	$.getJSON('../contr/getPaParGa.php?ga='+ga+'&ech='+nb+'&statut='+statut, function(data) {
		var table=document.getElementById(nomTab);
	    $.each(data, function(index, element) {
	    	el= new Array(element.num, element.disc, element.libelle, element.statut, element.echeance);
	    	var url = 'https://prod-sdin.edf.fr/eam/domain/startflow.do?IFA_FAVORITE=true&IFA_FLOW_NAME=PassPortPanel&panelid=TIMA010&keydata=';
	    	var ch = '00000000'+el[0];
	    	addRowLinkButton(table, 'pa', el, url+ch.slice(-8), el[0], '#modLstActions', '#modLstNotes');
	    });
	});
}



function eam_ouvrir(num_ecran, objet) {  
	var adresse = 'https://prod-sdin.edf.fr/eam/domain/startflow.do?IFA_FAVORITE=true&IFA_FLOW_NAME=PassPortPanel&panelid=' + num_ecran + '&keydata=';
if (objet != '') {
	var reg=new RegExp("[-/]", "g"); //caractère séparateur autorisé - ou /
	var objet_tab = document.getElementById(objet).value.split(reg);
	var objet0 = objet_tab[0].fill(8, "0"); //on complète par des 0 à gauche
	adresse = adresse + objet0
	if (objet_tab.length > 1) {
		var objet1 = objet_tab[1].fill(2, "0");
		adresse = adresse + objet1;
	}
}
window.open(adresse);
}

function graph(jsondata, idGraph, urlConstats){
		Chart.defaults.global.defaultFontSize=8;
		var promise = $.getJSON(jsondata);
		promise.done(function(data) {
			var pos=[];
			var neg=[];
			var lab=[];
			  $.each(data, function(entryIndex, entry) {
				pos.push(parseInt(entry.nbPos));
				neg.push(parseInt(entry.nbNeg));
				lab.push(entry.x);});
	    var barChartData = {
	        labels: lab,
	        datasets: 
	        [{
	            label: 'Positif',
	            backgroundColor: "rgba(80,158,47,1)",
	            data: pos
	        }, {
	            label: 'Negatif',
	            backgroundColor: "rgba(254,88,21,1)",
	            data: neg
	        }]
	    }
       	
	    var ctx = document.getElementById(idGraph).getContext("2d");
	    window[idGraph] = new Chart(ctx, {
	            type: 'bar',
	            data: barChartData,
	            options: 
	            {
	            	onClick: graphClickEvent,
	            	maintainAspectRatio: false,
	            	title:{
	                    display:false,
	                    text:urlConstats
	                },
	    			legend: {
            			display: false
	    			},
	                tooltips: {
	                    mode: 'label'
	                },
	                animation: {
		                duration: 0},
	                responsive: true,
	                scales: 
	                {
	                    xAxes: [{
	                        stacked: true,
	                    }],
	                    yAxes: [{
	                        stacked: true
	                    }]
	                }
	            }
	        });
    
	    
	    });
	}
	
function graphClickEvent(event){
	var activePoints = this.getElementsAtEvent(event);
    if(activePoints.length > 0)
    {
      var x = activePoints[0];
      var y = activePoints[1];
      var len=activePoints.length;
      var labelx = this.data.labels[x._index];
      var valuex = this.data.datasets[x._datasetIndex].data[x._index];
      var naturex = this.data.datasets[x._datasetIndex].label;
      var labely = this.data.labels[y._index];
      var valuey = this.data.datasets[y._datasetIndex].data[y._index];
      var naturey = this.data.datasets[y._datasetIndex].label;
      var url = this.options.title.text;
      var nature = convertNature(naturey);
      var code=convertCode(labelx);
      window.location.replace(url+'&code='+code);
    }}
function barGraphClickEvent(event){
	var activePoints = this.getElementsAtEvent(event);
    if(activePoints.length > 0)
    {
      var x = activePoints[0];
      var y = activePoints[1];
      var len=activePoints.length;
      var labelx = this.data.labels[x._index];
      var valuex = this.data.datasets[x._datasetIndex].data[x._index];
      var naturex = this.data.datasets[x._datasetIndex].label;
      var labely = this.data.labels[y._index];
      var valuey = this.data.datasets[y._datasetIndex].data[y._index];
      var naturey = this.data.datasets[y._datasetIndex].label;
      var url = this.options.title.text;
      var nature = convertNature(naturey);
      window.location.replace(url+labelx);
    }}
function convertNature(nature)
	{
		if (nature=='Positif'){return 1;} else {return 0;}
	}

function convertCode(code)
	{
		var codification={};
		//TODO: utiliser jnList dans develop
		codification= {"Releve":"EM19","Appro.":"PH05","OEEI":"EM04","DMP":"MA14","N3C":"SN14","Parametres chimiques":"CH01","AdR":"EM02","Utilisation stockage produits chimiques":"CH02","AAR":"SN01","\u00c9chantillonnage et Analyses chimiques":"CH03","Modif.":"CI02","Conform.":"CI03","Prescrip.":"CI04","Comm.":"CO01","Doc":"DO01","Bdd":"DO02","Gestion Doc":"DO03","NQME":"EM01","Manut":"EM03","FME":"EM05","Prepa":"EM06","Planning":"EM07","CT":"EM08","Surv.":"EM09","Coordo.":"EM10","Risq. Prod.":"EM11","Log":"EM12","EP":"EM13","Colisage":"EM14","Surv. Inst.":"EM15","Rklif":"EM16","PdR":"EM17","Log Tertiaire":"EM18","Surv. SdC.":"EM20","Rejets substances chimiques":"EN03","D\u00e9chets":"EN04","Pres. Manag.":"FO01","Abs.":"FO04","Comp.":"FO05","Incendie":"IN01","Def. Mat":"MA01","Info":"MA08","Instrum":"MA11","Outil":"MA13","RH":"OM01","Budg.":"OM02","HPM":"OM04","QVST":"OM05","Fn Instances.":"OM06","Pil.":"OM08","Presta":"OM10","REX":"OM11","Pointage":"OM12","Decision":"OM13","Ecarts":"OM14","R\u00e9glementation":"OM15","Qualit\u00e9 Rens.":"PH01","App. Proc.":"PH02","PFI":"PH03","Cult. Sur.":"PH04","PS":"PS01","Tir Radio":"RP01","RP":"RP05","Mat\u00e9riel RP":"RP03","Trans. Radio":"RP04","Comp. S\u00e9cu.":"SE01","Situ. S\u00e9cu.":"SE02","Manut. K":"SN04","CA":"SN07","PUI":"SN09","NC STE":"SN03","React.":"SN16","Cons.":"SE04","Rejets substances radioactives":"EN01"};
		return (codification[code]);
	}
    
	function getQuerystring(key, default_)
	 {
	   if (default_==null) default_=""; 
	   key = key.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
	   var regex = new RegExp("[\\?&]"+key+"=([^&#]*)");
	   var qs = regex.exec(window.location.href);
	   if(qs == null)
	     return default_;
	   else
	     return qs[1];
	 }
	
	function barGraph(jsondata, idGraph, urlConstats){
		var promise = $.getJSON(jsondata);
		Chart.defaults.global.defaultFontSize= 8;
		promise.done(function(data) {
			var pos=[];
			var neg=[];
			var lab=[];
			  $.each(data, function(entryIndex, entry) {
				pos.push(parseInt(entry.nbPos));
				neg.push(parseInt(entry.nbNeg));
				lab.push(entry.x);});
	    var barChartData = {
	        labels: lab,
	        datasets: 
	        [{
	            label: 'Positif',
	            backgroundColor: "rgba(80,158,47,1)",
	            data: pos
	        }, {
	            label: 'Negatif',
	            backgroundColor: "rgba(254,88,21,1)",
	            data: neg
	        }]
	    }
       	
	    var ctx = document.getElementById(idGraph).getContext("2d");
	    Chart.defaults.global.defaultFontSize= 8;
	    window.myBar = new Chart(ctx, {
	            type: 'bar',
	            data: barChartData,
	            options: 
	            {
	            	onClick: barGraphClickEvent,
	            	title:{
	                    display:false,
	                    text:urlConstats
	                },
	    			legend: {
            			display: false
	    			},
	                tooltips: {
	                    mode: 'label'
	                },
	                animation: {
		                duration: 0},
	                responsive: true,
	                scales: 
	                {
	                    xAxes: [{
	                        stacked: true,
	                    }],
	                    yAxes: [{
	                        stacked: true
	                    }]
	                }
	            }
	        });
	    });
	}

	function barGraphTot(jsondata, idGraph){
		var promise = $.getJSON(jsondata);
		Chart.defaults.global.defaultFontSize= 8;
		promise.done(function(data) {
			var tot=[];
			  $.each(data, function(entryIndex, entry) {
				tot.push(parseInt(entry.nbPos));
				neg.push(parseInt(entry.nbNeg));
				lab.push(entry.x);});
	    var barChartData = {
	        labels: lab,
	        datasets: 
	        [{
	            label: 'Positif',
	            backgroundColor: "rgba(80,158,47,1)",
	            data: pos
	        }, {
	            label: 'Negatif',
	            backgroundColor: "rgba(254,88,21,1)",
	            data: neg
	        }]
	    }
       	
	    var ctx = document.getElementById(idGraph).getContext("2d");
	    Chart.defaults.global.defaultFontSize= 8;
	    window.myBar = new Chart(ctx, {
	            type: 'bar',
	            data: barChartData,
	            options: 
	            {
	            	onClick: graphClickEvent,
	            	title:{
	                    display:false,
	                    text:""
	                },
	    			legend: {
            			display: false
	    			},
	                tooltips: {
	                    mode: 'label'
	                },
	                animation: {
		                duration: 0},
	                responsive: true,
	                scales: 
	                {
	                    xAxes: [{
	                        stacked: true,
	                    }],
	                    yAxes: [{
	                        stacked: true
	                    }]
	                }
	            }
	        });
	    });
	}
	function barGraphXYMix(jsondata, idGraph, leg, cible){
		var promise = $.getJSON(jsondata);
		Chart.defaults.global.defaultFontSize= 8;
		promise.done(function(data) {
			var tot=[];
			var lab=[];
			var c=[]
			  $.each(data, function(entryIndex, entry) {
				tot.push(parseInt(entry.y));				
				lab.push(entry.x);
				c.push(parseInt(cible));});
				
	    var barChartData = {
	        labels: lab,
	        datasets: 
	        [{
	        	type: 'bar',
	        	label: leg,
	            backgroundColor: "rgba(0,91,187,1)",
	            data: tot
	        },
	        {
	        	type: 'line',
	        	label: leg,
	            backgroundColor: "rgba(80,158,47,1)",
	            pointRadius: 0,
	            borderColor: "rgba(80,158,47,1)",
	            borderDash: [4,2],
	            fill: false,
	            data: c
	        },]
	    }
       	
	    var ctx = document.getElementById(idGraph).getContext("2d");
	    Chart.defaults.global.defaultFontSize= 8;
	    window.myBar = new Chart(ctx, {
	            type: 'bar',
	            data: barChartData,
	            options: 
	            {
	            	onClick: graphClickEvent,
	            	title:{
	                    display:false,
	                    text:""
	                },
	    			legend: {
            			display: false
	    			},
	                tooltips: {
	                    mode: 'label'
	                },
	                animation: {
		                duration: 0},
	                responsive: true,
	                scales: 
	                {
	                    xAxes: [{
	                        stacked: true,
	                    }],
	                    yAxes: [{
	                        stacked: false,
	                        ticks: {
	                        	beginAtZero : true
	                        }
	                    }]
	                }
	            }
	        });
	    });
	}
	function lineGraph(jsondata, idGraph, code){
		var promise = $.getJSON(jsondata);
		Chart.defaults.global.defaultFontSize= 10;
		promise.done(function(data) {
			var pos=[];
			var neg=[];
			var lab=[];
			  $.each(data, function(entryIndex, entry) {
				pos.push(parseInt(entry.nbPos));
				neg.push(parseInt(entry.nbNeg));
				lab.push(entry.mois);});
	    var ChartData = {
	        labels: lab,
	        datasets: 
	        [{
	            label: code+' (+)',
	            backgroundColor: "rgba(80,158,47,1)",
	            borderColor: "rgba(80,158,47,1)",
	            lineTension: 0,
	            fill: false,
	            data: pos
	        },
	        {
	            label: code+' (-)',
	            backgroundColor: "rgba(254,88,21,1)",
	            borderColor: "rgba(254,88,21,1)",
	            lineTension: 0,
	            fill: false,
	            data: neg
	        }]
	    }
       	
	    var ctx = document.getElementById(idGraph).getContext("2d");
	    window.myLine = new Chart(ctx, {
	            type: 'line',
	            data: ChartData,
	            
	            options: 
	            {
	            	default: {
	            		defaultFontSize: 10
	            	},
	            	title:{
	                    display:false,
	                    text:""
	                },
	    			legend: {
            			display: false
	    			},
	                tooltips: {
	                    mode: 'label'
	                },
	                animation: {
		                duration: 0},
	                responsive: true,
	                scales: 
	                {
	                    xAxes: [{

	                    }],
	                    yAxes: [{
	                        stacked: false
	                    }]
	                }
	            }
	        });
	    });
	}
	
	function lineGraphSite(jsondata, idGraph){
		var promise = $.getJSON(jsondata);
		promise.done(function(data) {
			var tot=[];
			var lab=[];
			  $.each(data, function(entryIndex, entry) {
				tot.push(parseInt(entry.nb));
				lab.push(entry.mois);});
	    var ChartData = {
	        labels: lab,
	        datasets: 
	        [{
	            label: 'tot',
	            backgroundColor: "rgba(0,91,187,1)",
	            borderColor: "rgba(0,91,187,1)",
	            lineTension: 0,
	            fill: false,
	            data: tot
	        }]
	    }
       	
	    var ctx = document.getElementById(idGraph).getContext("2d");
	    window.myLine = new Chart(ctx, {
	            type: 'line',
	            data: ChartData,
	            options: 
	            {
	                title:{
	                    display:false,
	                    text:""
	                },
	    			legend: {
            			display: false
	    			},
	                tooltips: {
	                    mode: 'label'
	                },
	                animation: {
		                duration: 0},
	                responsive: true,
	                scales: 
	                {
	                    xAxes: [{

	                    }],
	                    yAxes: [{
	                        stacked: false,
	                        ticks: {
	                        	beginAtZero : false
	                        }

	                    }]
	                }
	            }
	        });
	    });
	}	
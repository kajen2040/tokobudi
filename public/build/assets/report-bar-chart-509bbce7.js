(function(){if($(".report-bar-chart").length){let r=new Array(40).fill(0).map((a,e)=>e%3==0||e%5==0?Math.ceil(Math.random()*-20+20):Math.ceil(Math.random()*-7+7)),t=r.map(a=>a>=8&&a<=14?$("html").hasClass("dark")?"#2E51BBA6":getColor("primary",.65):a>=15?$("html").hasClass("dark")?"#2E51BB":getColor("primary"):$("html").hasClass("dark")?"#2E51BB59":getColor("primary",.35));const s=$(".report-bar-chart")[0].getContext("2d"),l=new Chart(s,{type:"bar",data:{labels:r,datasets:[{label:"Html Template",barThickness:6,data:r,backgroundColor:t}]},options:{maintainAspectRatio:!1,plugins:{legend:{display:!1}},scales:{x:{ticks:{display:!1},grid:{display:!1}},y:{ticks:{display:!1},grid:{display:!1},border:{display:!1}}}}});setInterval(()=>{let a=r[0];r.shift(),r.push(a);let e=t[0];t.shift(),t.push(e),l.update()},1e3),helper.watchClassNameChanges($("html")[0],a=>{l.update()})}})();

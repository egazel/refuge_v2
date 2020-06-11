//pie
var ctxP = document.getElementById("doughnutChart").getContext('2d');
var myDoughnutChart = new Chart(ctxP, {
type: 'doughnut',
data: {
labels: ["Famille d'accueil", "Membres"],
datasets: [{
data: [80, 20],
backgroundColor: ["#46BFBD", "#FDB45C"],
hoverBackgroundColor: ["#5AD3D1", "#FFC870"]
}]
},
options: {
responsive: true
}
});


//line
//line
var ctxL = document.getElementById("lineChart").getContext('2d');
var myLineChart = new Chart(ctxL, {
type: 'line',
data: {
labels: ["January", "February", "March", "April", "May", "June", "July"],
datasets: [{
label: "My First dataset",
data: [65, 59, 80, 81, 56, 55, 20],
backgroundColor: [
'rgba(105, 0, 132, .2)',
],
borderColor: [
'rgba(200, 99, 132, .7)',
],
borderWidth: 2
},

]
},
options: {
responsive: true
}
});
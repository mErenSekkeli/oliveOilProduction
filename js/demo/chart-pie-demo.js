// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

function generateColor() {
  var randomColor = Math.floor(Math.random()*16777215).toString(16);
  return randomColor;
}

var colors = [];

for(var i = 0; i < graph_labels.length; i++) {
  colors.push("#" + generateColor());
}

// Pie Chart Example
var ctx = document.getElementById("myPieChart");
var myPieChart = new Chart(ctx, {
  type: 'doughnut',
  data: {
    labels: graph_labels,
    datasets: [{
      data: graph_data,
      backgroundColor: colors,
      //hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf'],
      hoverBorderColor: "rgba(234, 236, 244, 1)",
    }],
  },
  options: {
    maintainAspectRatio: false,
    tooltips: {
      backgroundColor: "rgb(255,255,255)",
      bodyFontColor: "#858796",
      borderColor: '#dddfeb',
      borderWidth: 1,
      xPadding: 15,
      yPadding: 15,
      displayColors: false,
      caretPadding: 10,
      callbacks: {
        
        label: (item) =>  {
          return `${graph_labels[item.index]}: ₺${graph_data[item.index]}`
      }
      },
    },
    legend: {
      display: false
    },
    cutoutPercentage: 80,
  },
});

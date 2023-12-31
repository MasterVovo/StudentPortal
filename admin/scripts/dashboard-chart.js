const gender = document.getElementById('gender').getContext('2d');
const age = document.getElementById('age').getContext('2d');
const visitors = document.getElementById('chart-visitors').getContext('2d');

function createGenderChart(genderData) {
    const genderChart = new Chart(gender, {
        type: 'doughnut',
        data: {
            labels: ['Male', 'Female'],
            datasets: [
                {
                    data: genderData
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
        
    });
}

function createAgeChart(ageData) {
    const ageChart = new Chart(age, {
        type: 'bar',
        data: {
            labels: ageData[0],
            datasets: [
                {
                    label: 'Male',
                    data: ageData[1]
                },
                {
                    label: 'Female',
                    data: ageData[2]
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
}

// Fetches the gender data and call the method to create a gender chart
$.ajax({
    url: 'includes/fetch-chart-data.inc.php',
    type: 'POST',
    data: {functionName: 'getGenderData'},
    success: function(data) {
        console.log(data);
        const genderData = JSON.parse(data);
        createGenderChart(genderData);
    },
    error: function(data) {
        console.log('Gender data couldn\'t be retrieved');
    }
});

// Fetches the age data and call the method to create an age chart
$.ajax({
    url: 'includes/fetch-chart-data.inc.php',
    type: 'POST',
    data: {functionName: 'getAgeData'},
    success: function(data) {
        console.log("age data is " + data);
        const ageData = JSON.parse(data);
        createAgeChart(ageData);
    }
})

const vistorsChart = new Chart(visitors, {
    type: 'line',
    data: {
        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
        datasets: [{
            label: 'Visits',
            backgroundColor: 'rgb(0, 128, 0, 0.5',
            borderColor: 'green',
            data: [10, 10, 5, 25, 20, 30, 45],
            borderWidth: 2,
            tension: 0.4,
            pointRadius: 0,
            fill: true
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            x: {
                display: false
            },
            y: {
                beginAtZero: true,
                display: false
            }
        },
        plugins: {
            legend: {
                display: false
            },
            tooltips: {
                display: false
            }
        }
    }
});

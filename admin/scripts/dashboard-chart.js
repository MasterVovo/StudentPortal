const gender = document.getElementById('gender').getContext('2d');
const age = document.getElementById('age').getContext('2d');

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
    },
    error: function(error) {
        console.log('error');
    }
});

// Get the number of teachers
$.ajax({
    url: 'includes/fetch-chart-data.inc.php',
    type: 'POST',
    data: {
        functionName: 'getRowNum',
        tableName: 'thrinfo'
    },
    success: function(data) {
        $('#thrCount').text(data);
    },
    error: function(error) {
        console.log(error);
    }
});

// Get the number of students
$.ajax({
    url: 'includes/fetch-chart-data.inc.php',
    type: 'POST',
    data: {
        functionName: 'getRowNum',
        tableName: 'stdinfo'
    },
    success: function(data) {
        $('#stdCount').text(data);
    },
    error: function(error) {
        console.log(error);
    }
});

// Calculate the ratio of teacher to students
let thrCount = parseInt($('#thrCount').text(), 10);
let stdCount = parseInt($('#stdCount').text(), 10);
$('#ratio').text('1 | ' + stdCount / thrCount);

// Get the student retention
$.ajax({
    url: 'includes/fetch-chart-data.inc.php',
    type: 'POST',
    data: {
        functionName: 'getStudentRetention'
    },
    success: function(data) {
        console.log(data);
        const retentionData = JSON.parse(data);
        $('.retention-desc').text(retentionData[1] + "% Increase From Last Year");
        $('.drop-count').text(retentionData[0]);
        $('.progress-bar.retention').css('width', retentionData[1] + "%");
    },
    error: function(error) {
        console.log(error);
    }
})
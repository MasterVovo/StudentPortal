const gender = document.getElementById('gender').getContext('2d');
const age = document.getElementById('age').getContext('2d');

// Chart.overrides.doughnut.plugins.legend.display = true;
const genderChart = new Chart(gender, {
    type: 'doughnut',
    data: {
        labels: ['Male', 'Female'],
        datasets: [
            {
                data: [60, 40]
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false
        // plugins: {
        //     title: {
        //         display: true,
        //         text: 'Gender Distribution'
        //     }
        // }
    }
    
});

const ageChart = new Chart(age, {
    type: 'bar',
    data: {
        labels: [18, 19, 20, 21, 22, 23, 24, 25],
        datasets: [
            {
                label: 'Male',
                data: [100, 120, 300, 90, 80, 150, 200, 130]
            },
            {
                label: 'Female',
                data: [90, 150, 100, 80, 70, 200, 250, 300]
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false
    }
    // ,
    // options: {
    //     plugins: {
    //         title: {
    //             display: true,
    //             text: 'Age Distribution'
    //         }
    //     }
    // }
});






// const chart = new Chart(beginnerchart, {
//     type: 'bar',
//     data: {
//         labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
//         datasets: [
//             {
//                 label: 'My First dataset',
//                 backgroundColor: ['rgb(255, 99, 132)', 'rgba(255, 0, 0, 0.1)', 'blue', '#009900'],
//                 borderColor: ['red', 'green', 'blue', 'yellow'],
//                 data: [0, 10, 5, 2, 20, 30, 45],
//                 borderWidth: 1
//             }
//         ]
//     },
//     options: {
//         plugins: {
//             legend: {
//                 display: false
//             }
//         }
        
//     }
// });
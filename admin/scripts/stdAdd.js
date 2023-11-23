$(document).ready(function () {
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });
    
    // This will run if the upload button is clicked
    $("#uploadBtn").click(function (e) {
      e.preventDefault();

      grid.loadData();
    });

    $('#uploadToDB').click(function(e) {
        e.preventDefault();

        let allData = grid.data;
        let jsonData = JSON.stringify(allData);

        $.ajax({
        url: "includes/add_std.inc.php",
        type: "POST",
        data: { jsonData: jsonData, },
        dataType: "json",
        success: function (response) {
            console.log("Data inserted successfully:", response);
        },
        error: function (error) {
            Toast.fire({
                icon: 'error',
                title: "An error occured."
            });
            console.error("Error inserting data:", error);
        }
        });
    });
});

let grid = $('#grid-table').jsGrid({
    width: "100%",
    height: "auto",

    // filtering: true,
    // inserting: true,
    editing: true,
    sorting: true,
    paging: true,
    autoload: false,
    pageSize: 10,
    pageButtonCount: 5,
    // deleteConfirm: "Do you really want to delete data?",

    controller: {
        loadData: function(filter) {
            var formData = new FormData();
            formData.append("excelFile", $("#excelFile")[0].files[0]);
    
            return $.ajax({
                url: "includes/stdreg.inc.php",
                type: "POST",
                data: formData,
                dataType: "json",
                processData: false, // tell jQuery not to process the data
                contentType: false, // tell jQuery not to set contentType
                success: function (data) {
                    return data;
                },
            });
        }
        // insertItem: function(item) {
        //     return $.ajax({
        //         type: "POST",
        //         url: "fetch_data.php",
        //         data: item
        //     });
        // }
    },

    fields: [
        {
            name: "stdID",
            title: "Student ID",
            type: "text",
            validate: "required"
        },
        {
            name: "stdFName",
            title: "First Name",
            type: "text",
            validate: "required"
        },
        {
            name: "stdMName",
            title: "Middle Name",
            type: "text",
            validate: "required"
        },
        {
            name: "stdLName",
            title: "Last Name",
            type: "text",
            validate: "required"
        },
        {
            name: "stdCourse",
            title: "Course",
            type: "text",
            validate: "required"
        },
        {
            name: "stdEmail",
            title: "Email",
            type: "text",
            validate: "required"
        }
    ]
}).data("JSGrid");

// The minimum width of the table for responsiveness
$('.jsgrid-table').css('min-width', '732px');
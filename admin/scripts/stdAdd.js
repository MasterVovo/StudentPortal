$(document).ready(function () {
    // Configuration for alerts
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
        }
    });

    // Disables and enables button whenever the input file changed
    $("#excelFile").change(function() {
        if (this.files.length > 0) {
            $("#uploadBtn").removeAttr("disabled");
        } else {
            $("#uploadBtn").attr("disabled", "disabled");
        }
    });
    
    // This will run if the upload button is clicked
    $("#uploadBtn").click(function (e) {
      e.preventDefault();

      grid.loadData();
      $("#uploadBtn").attr("disabled", "disabled");
      $("#excelFile").attr("disabled", "disabled");
    });

    // Runs when the upload to database is clicked
    $('#uploadToDB').click(function(e) {
        e.preventDefault();

        // Shows a confirmation dialog
        swal.fire({
            title: "Are you sure?",
            text: "This will upload the students data to the database!",
            icon: "warning",
            showConfirmButton: true,
            showCancelButton: true
        }).then((result) => {
            if (result.isConfirmed) {
                let allData = grid.data;
                let jsonData = JSON.stringify(allData);
        
                $.ajax({
                url: "includes/add_std.inc.php",
                type: "POST",
                data: { jsonData: jsonData, },
                dataType: "json",
                success: function (response) {
                    // Fires a success alert
                    Toast.fire({
                        icon: 'success',
                        title: 'Student Data Uploaded.'
                    });

                    // Clear the file input or the uploadForm
                    document.getElementById('uploadForm').reset();
        
                    // Disables uploading to database button
                    $('#uploadToDB').attr("disabled", "disabled");
                    $('#uploadBtn').attr("disabled", "disabled");

                    // Enables file input
                    $("#excelFile").removeAttr("disabled");
        
                    // Clears the table
                    const items = grid.option("data");
                    for (let i = 0; i < items.length; i++) {
                        grid.deleteItem(items[i]);
                    }
        
                    console.log("Data inserted successfully:", response);
                },
                error: function (error) {
                    // Fires an error alert
                    Toast.fire({
                        icon: 'error',
                        title: "An error occured."
                    });
        
                    console.error("Error inserting data:", error);
                }
                });
            }
        });
    });
});

let grid = $('#grid-table').jsGrid({
    width: "100%",
    height: "auto",

    noDataContent: "No data available",
    filtering: false,
    inserting: false,
    editing: true,
    sorting: true,
    paging: true,
    autoload: false,
    pageSize: 10,
    pageButtonCount: 5,
    confirmDeleting: false,

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
                    $("#uploadToDB").removeAttr("disabled");
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
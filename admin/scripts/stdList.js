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

let grid = $('#grid-table').jsGrid({
    width: "100%",
    height: "auto",

    filtering: false,
    inserting: false,
    editing: false,
    sorting: true,
    paging: true,
    autoload: true,
    pageSize: 15,
    pageButtonCount: 5,
    confirmDeleting: false,

    controller: {
        loadData: function(filter) {
            return $.ajax({
                type: "POST",
                url: "includes/fetch-stdList.inc.php",
                data: filter,
                dataType: "json"
            });
        },
        deleteItem: function(item) {
            swal.fire({
                title: "Archive this data?",
                text: "It will be permanently deleted after 2 years!",
                icon: "warning",
                showConfirmButton: true,
                showCancelButton: true
            }).then((result) => {
                if (result.isConfirmed) {
                    return $.ajax({
                        type: "POST",
                        url: "includes/delete-stdList.inc.php",
                        data: {
                            functionName: 'archiveStd',
                            stdData: item
                        },
                        success: function(response) {
                            console.log(response);
                        },
                        error: function(error) {
                            console.log(error);
                        }
                    })
                }
            });
        }
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
            type: "text"
        },
        {
            name: "stdLName",
            title: "Last Name",
            type: "text",
            validate: "required"
        },
        {
            name: "stdBirth",
            title: "Birthday",
            type: "text",
            validate: "required"
        },
        {
            name: "stdGender",
            title: "Gender",
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
            name: "stdImage",
            title: "Image",
            type: "text"
        },
        {
            name: "stdEmail",
            title: "Email",
            type: "text",
            validate: "required"
        },
        {
            type: "control",
            editButton: false
        }
    ]
}).data("JSGrid");

// The minimum width of the table for responsiveness
$('.jsgrid-table').css('min-width', '1800px');
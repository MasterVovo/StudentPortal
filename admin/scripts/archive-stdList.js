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

let grid = $('#grid-table').jsGrid({
    width: "100%",
    height: "auto",

    filtering: false,
    inserting: false,
    editing: false,
    sorting: true,
    paging: true,
    autoload: true,
    pageSize: 10,
    pageButtonCount: 5,

    controller: {
        loadData: function(filter) {
            return $.ajax({
                type: "POST",
                url: "includes/fetch-archive-stdList.inc.php",
                data: filter,
                dataType: "json"
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
            name: "expiration",
            title: "Expiration",
            type: "text"
        },
        {
            type: 'control',
            editButton: false,
            deleteButton: false,
            itemTemplate: function (value, item) {
                var $result = jsGrid.fields.control.prototype.itemTemplate.apply(this, arguments);
                var $customButton = $('<button>').attr({class: 'customButton material-icons-sharp restore text-success'}).text('restore');
                $customButton.on('click', function() {
                    swal.fire({
                        title: "Restore this data?",
                        text: "This data will be recovered from archived",
                        icon: "warning",
                        showConfirmButton: true,
                        showCancelButton: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            return $.ajax({
                                type: "POST",
                                url: "includes/delete-stdList.inc.php",
                                data: {
                                    functionName: 'restoreStd',
                                    stdData: item
                                },
                                success: function(response) {
                                    console.log(response);
                                    $("#grid-table").jsGrid("loadData");
                                },
                                error: function(error) {
                                    console.log(error);
                                }
                            });
                        }
                    });
                });
                return $result.add($customButton);
            }
        }
    ]
}).data("JSGrid");

// The minimum width of the table for responsiveness
$('.jsgrid-table').css('min-width', '1800px');

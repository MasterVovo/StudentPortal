let grid = $('#grid-table').jsGrid({
    width: "100%",
    height: "auto",

    filtering: true,
    // inserting: true,
    editing: false,
    sorting: true,
    paging: true,
    autoload: true,
    pageSize: 15,
    pageButtonCount: 5,
    // deleteConfirm: "Do you really want to delete data?",

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
            return $.ajax({
                type: "POST",
                url: "includes/delete-stdList.inc.php",
                data: item
            })
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
            type: "control"
        }
    ]
}).data("JSGrid");

// The minimum width of the table for responsiveness
$('.jsgrid-table').css('min-width', '1800px');
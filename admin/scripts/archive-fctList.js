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
                url: "includes/fetch-archive-fctList.inc.php",
                data: filter,
                dataType: "json"
            });
        }
    },

    fields: [
        {
            name: "thrId",
            title: "Teacher ID",
            type: "text",
            validate: "required"
        },
        {
            name: "thrFName",
            title: "First Name",
            type: "text",
            validate: "required"
        },
        {
            name: "thrMName",
            title: "Middle Name",
            type: "text"
        },
        {
            name: "thrLName",
            title: "Last Name",
            type: "text",
            validate: "required"
        },
        {
            name: "thrEmail",
            title: "Email",
            type: "text",
            validate: "required"
        },
        {
            name: "thrDept",
            title: "Department",
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
                    console.log('Custom button clicked for item: ', item);
                    $.ajax({
                        type: "POST",
                        url: "includes/delete-stdList.inc.php",
                        data: {
                            functionName: 'restoreFct',
                            fctData: item
                        },
                        success: function(response) {
                            console.log(response);
                            $("#grid-table").jsGrid("loadData");
                        },
                        error: function(error) {
                            console.log(response);
                        }
                    })
                });
                return $result.add($customButton);
            }
        }
    ]
}).data("JSGrid");

// The minimum width of the table for responsiveness
$('.jsgrid-table').css('min-width', '1800px');

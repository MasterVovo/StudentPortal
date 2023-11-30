function createGridChart(sections) {
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
        inserting: true,
        editing: true,
        sorting: true,
        paging: true,
        autoload: true,
        pageSize: 15,
        pageButtonCount: 5,
        onItemUpdated: function() {
            $("#grid-table").jsGrid("loadData");
        },
        // deleteConfirm: "Do you really want to delete data?",
    
        controller: {
            loadData: function() {
                return $.ajax({
                    type: "POST",
                    url: "includes/fetch-fctList.inc.php",
                    data: { functionName: 'fetchThrData' },
                    dataType: "json"
                });
            },
            updateItem: function(item) {
                return $.ajax({
                    type: "POST",
                    url: "includes/update-data.inc.php",
                    data: {
                        functionName: 'updateFctSection',
                        fctData: item
                    },
                    success: function(response) {
                        switch (response) {
                            case 'adviser already exist':
                                Toast.fire({
                                    icon: 'warning',
                                    title: 'Adviser already exist.'
                                });
                                break;
                            case 'something went wrong':
                                Toast.fire({
                                    icon: 'warning',
                                    title: 'Something went wrong.'
                                });
                                break;
                            case 'success':
                                Toast.fire({
                                    icon: 'success',
                                    title: 'Section successfully updated.'
                                });
                                break;
                            case 'section not found':
                                Toast.fire({
                                    icon: 'info',
                                    title: 'section not found.'
                                });
                                break;
                        }
                    },
                    error: function(error) {
                        console.error('Error updating section ' + error);
                    }
                });
            }
            // ,
            // deleteItem: function(item) {
            //     return $.ajax({
            //         type: "POST",
            //         url: "includes/delete-stdList.inc.php",
            //         data: item
            //     })
            // }
        },
    
        fields: [
            {
                name: "thrId",
                title: "Teacher ID",
                type: "text",
                validate: "required",
                editTemplate: function(value) {
                    return $("<span>").text(value);
                }
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
                name: "thrDept",
                title: "Department",
                type: "text",
                validate: "required"
            },
            {
                name: "sectionName",
                title: "Section",
                type: "select",
                items: sections,
                valueField: "value",
                textField: "text"
            },
            {
                type: "control"
            }
        ]
    }).data("JSGrid");
    
    // The minimum width of the table for responsiveness
    $('.jsgrid-table').css('min-width', '1800px');    
}

$.ajax({
    url: 'includes/fetch-fctList.inc.php',
    type: 'POST',
    data: {functionName: 'fetchSections'},
    success: function(data) {
        console.log(data);
        const sections = JSON.parse(data);
        createGridChart(sections);
    },
    error: function(data) {
        console.log('Sections couldn\'t be retrieved');
    }
});
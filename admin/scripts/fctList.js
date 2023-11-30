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
                                return swal.fire({
                                    title: "An adviser already exist on that section!",
                                    text: "Do you want to replace the adviser?",
                                    icon: "warning",
                                    showConfirmButton: true,
                                    showCancelButton: true
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        return $.ajax({
                                            url: "includes/update-data.inc.php",
                                            type: "POST",
                                            data: { 
                                                functionName: 'updateSectionOverride',
                                                fctData: item
                                            },
                                            success: function (response) {
                                                switch (response) {
                                                    case 'Something went wrong in replacing adviser':
                                                        Toast.fire({
                                                            icon: 'warning',
                                                            title: response
                                                        });
                                                        break;
                                                    case 'Something\'s wrong in updating teacher information':
                                                        Toast.fire({
                                                            icon: 'warning',
                                                            title: response
                                                        });
                                                        break;
                                                    case 'Teachers info is successfully updated':
                                                        Toast.fire({
                                                            icon: 'success',
                                                            title: response
                                                        });
                                                        break;
                                                }
                                            },
                                            error: function(error) {
                                                console.error('Error updating data ' + error);
                                            }
                                        });
                                    }
                                });
                                break;
                            case 'Something\'s wrong in updating teacher information':
                                Toast.fire({
                                    icon: 'error',
                                    title: response
                                });
                                break;
                            case 'Error in updating section':
                                Toast.fire({
                                    icon: 'error',
                                    title: response
                                });
                                break;
                            case 'Teachers info is successfully updated':
                                Toast.fire({
                                    icon: 'success',
                                    title: response
                                });
                                break;
                            case 'section not found':
                                Toast.fire({
                                    icon: 'info',
                                    title: response
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
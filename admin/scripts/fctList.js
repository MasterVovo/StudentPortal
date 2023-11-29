function createGridChart(sections) {
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
        // deleteConfirm: "Do you really want to delete data?",
    
        controller: {
            loadData: function() {
                return $.ajax({
                    type: "POST",
                    url: "includes/fetch-fctList.inc.php",
                    data: { functionName: 'fetchThrData' },
                    dataType: "json"
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
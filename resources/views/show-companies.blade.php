<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Company List</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <style>
    /* Add your desired CSS styles here */
    #company-list-container {
        display: flex;
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
    }

    #sidebar {
        width: 200px;
        background-color: #f2f2f2;
        padding: 10px;
    }

    #sidebar ul {
        list-style-type: none;
        padding: 0;
    }

    #sidebar li {
        margin-bottom: 10px;
    }

    #company-list {
        border-collapse: collapse;
        width: 100%;
    }

    #company-list th,
    #company-list td {
        padding: 8px;
        text-align: left;
    }

    #company-list th {
        background-color: #f2f2f2;
        font-weight: bold;
    }

    .edit-button,
    .delete-button,
    .update-button {
        margin-right: 5px;
    }

    .pagination-links {
        margin-top: 10px;
        text-align: center;
    }

    .page-link {
        padding: 5px;
        margin-right: 5px;
        text-decoration: none;
        color: #007bff;
    }

    .page-link.active {
        font-weight: bold;
    }

    .add-button {
        text-align: right;
    }
</style>
</head>
<body>
    <div id="company-list-container">
        <div id="sidebar">
            <ul>
                <li><a href="{{ route('company.index') }}">Company</a></li>
                <li><a href="{{ route('employee.index') }}">Employee</a></li>
            </ul>
        </div>
        <div id="main-content">
            <h1>Company List</h1>
            <div>
                <a href="{{ route('company.create') }}" class="add-button">Add Company</a>
            </div>
            <table id="company-list">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Website</th>
                        <th>Company_logo</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
            <div id="pagination-links" class="pagination-links"></div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script>
    $(document).ready(function() {
    // Send AJAX request to fetch company data
    $.ajax({
        url: '/api/index1',
        type: 'GET',
        success: function(response) {
            console.log(response);
            if (response.data.data.length > 0) {
                var companies = response.data.data;
                console.log(companies);
                var companyTable = $('#company-list').DataTable();

                // Clear existing rows from the table
                companyTable.clear();

                // Iterate through each company and add it to the DataTable
                companies.forEach(function(company) {
                    companyTable.row.add([
                        company.id,
                        company.name,
                        company.email,
                        company.website,
                        company.logo,
                        '<a href="#" class="edit-button" data-action-id="' + company.id + '">Edit</a> <a href="#" class="delete-button" data-action-id="' + company.id + '">Delete</a> <a href="#" class="show-button" data-action-id="' + company.id + '">Details</a>'
                    ]);
                });

                // Draw the updated DataTable
                companyTable.draw();
            }
        },
        error: function(xhr, status, error) {
            console.log('AJAX request failed. Error: ' + error);
        }
    });

    // Event listener for edit button click
    $(document).on('click', '.edit-button', function(e) {
        e.preventDefault();
        var actionId = $(this).data('action-id');
        console.log('Edit button clicked for action ID: ' + actionId);

        // Send AJAX request with the action ID
        $.ajax({
            url: '/api/company/' + actionId + '/edit',
            type: 'GET',
            data: {
                actionId: actionId
            },
            success: function(response) {
                // Create a modal element and set its content
                var modalContent = $('<div>').addClass('modal-content');
                var modalHeader = $('<div>').addClass('modal-header').html('<h5 class="modal-title">Company Details</h5><button type="button" class="close" data-dismiss="modal">&times;</button>');
                var modalBody = $('<div>').addClass('modal-body').html(response);
                modalContent.append(modalHeader, modalBody);

                // Create the modal dialog
                var modalDialog = $('<div>').addClass('modal-dialog').attr('role', 'document').append(modalContent);

                // Create the modal container and append the dialog
                var modalContainer = $('<div>').addClass('modal fade').attr('id', 'companyModal').attr('tabindex', '-1').attr('role', 'dialog').append(modalDialog);

                // Append the modal container to the body
                $('body').append(modalContainer);

                // Show the modal
                $('#companyModal').modal('show');
            },
            error: function(xhr, status, error) {
                console.log('AJAX request failed. Error: ' + error);
            }
        });
    });
     // Event listener for edit button click
     $(document).on('click', '.show-button', function(e) {
        e.preventDefault();
        var actionId = $(this).data('action-id');
        console.log('Edit button clicked for action ID: ' + actionId);

        // Send AJAX request with the action ID
        $.ajax({
            url: '/api/company/' + actionId,
            type: 'GET',
            data: {
                actionId: actionId
            },
            success: function(response) {
                // Create a modal element and set its content
                var modalContent = $('<div>').addClass('modal-content');
                var modalHeader = $('<div>').addClass('modal-header').html('<h5 class="modal-title">Company Details</h5><button type="button" class="close" data-dismiss="modal">&times;</button>');
                var modalBody = $('<div>').addClass('modal-body').html(response);
                modalContent.append(modalHeader, modalBody);

                // Create the modal dialog
                var modalDialog = $('<div>').addClass('modal-dialog').attr('role', 'document').append(modalContent);

                // Create the modal container and append the dialog
                var modalContainer = $('<div>').addClass('modal fade').attr('id', 'companyModal').attr('tabindex', '-1').attr('role', 'dialog').append(modalDialog);

                // Append the modal container to the body
                $('body').append(modalContainer);

                // Show the modal
                $('#companyModal').modal('show');
            },
            error: function(xhr, status, error) {
                console.log('AJAX request failed. Error: ' + error);
            }
        });
    });

    $(document).on('click', '.delete-button', function(e) {
    e.preventDefault();
    var actionId = $(this).data('action-id');
    
    // Show confirmation prompt
    if (confirm('Are you sure you want to delete this company?')) {
        console.log('Edit button clicked for action ID: ' + actionId);

        // Send AJAX request with the action ID
        $.ajax({
            url: '/api/company/' + actionId,
            type: 'DELETE',
            data: {
                actionId: actionId
            },
            success: function(response) {
                console.log('Deleted successfully');
            },
            error: function(xhr, status, error) {
                console.log('AJAX request failed. Error: ' + error);
            }
            });
        }
    });

        function renderPaginationLinks(totalPages, currentPage) {
            var paginationLinksContainer = $('#pagination-links');
            paginationLinksContainer.empty();

            var startPage = Math.max(1, currentPage - 2);
            var endPage = Math.min(totalPages, startPage + 4);

            if (currentPage > 1) {
                paginationLinksContainer.append('<a href="#" class="page-link" data-page="' + (currentPage - 1) + '">Previous</a>');
            }
            for (var i = startPage; i <= endPage; i++) {
                var pageLink = $('<a href="#" class="page-link" data-page="' + i + '">' + i + '</a>');
                if (i === currentPage) {
                pageLink.addClass('active');
                }
                paginationLinksContainer.append(pageLink);
            }

            if (currentPage < totalPages) {
                paginationLinksContainer.append('<a href="#" class="page-link" data-page="' + (currentPage + 1) + '">Next</a>');
            }
            }

    // Event listener for page link click
    $(document).on('click', '.page-link', function(e) {
        e.preventDefault();
        var page = $(this).data('page');
        console.log('Page link clicked: ' + page);

        // Send AJAX request to fetch companies for the selected page
        $.ajax({
            url: '/api/company?page=' + page,
            type: 'GET',
            success: function(response) {
                console.log(response);
                if (response.data.length > 0) {
                    var companies = response.data;
                    console.log(companies);
                    var companyTable = $('#company-list').DataTable();

                    // Clear existing rows from the table
                    companyTable.clear();

                    // Iterate through each company and add it to the DataTable
                    companies.forEach(function(company) {
                        companyTable.row.add([
                            company.name,
                            company.email,
                            company.website,
                            company.logo,
                            '<a href="#" class="edit-button" data-action-id="' + company.id + '">Edit</a> <a href="#" class="delete-button" data-action-id="' + company.id + '">Delete</a> <a href="#" class="update-button" data-action-id="' + company.id + '">Update</a>'
                        ]);
                    });

                    // Draw the updated DataTable
                    companyTable.draw();
                }
            },
            error: function(xhr, status, error) {
                console.log('AJAX request failed. Error: ' + error);
            }
        });
    });
});
</script>
</body>
</html>


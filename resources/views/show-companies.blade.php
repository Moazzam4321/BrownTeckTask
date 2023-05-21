<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Company List</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <style>
    /* Add your desired CSS styles here */
    .pagination-links {
        padding: 5px;
        position: absolute;
        margin-left: 200px;
        text-decoration: none;
        color: #007bff;
        border: 1px solid black;
        border-radius: 8px;
        white-space: nowrap; /* Ensure the links stay in a single line */
    }

    #company-list-container {
        display: flex;
        margin: 0px;
        padding: 0px;
    }

    #sidebar {
  width: 200px;
  background-color: #f2f2f2;
  padding: 0px;
  position: fixed;
  height: 100%;
  overflow-y: auto;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}

    #logout-form {
        background-color: #ffffff;
        padding: 10px;
        border: 1px solid #cccccc;
        border-radius: 5px;
    }

    #all_actions {
  background-color: #ffffff;
  padding: 00px;
  border: 1px solid #cccccc;
  border-radius: 5px;
  margin: 0px;
}

#main-content {
  margin-left: 200px;
  width: calc(100% - 200px);
  padding: 20px;
  overflow-y: auto;
}

    #company-list {
        border-collapse: collapse;
        width: 100%;
    }

    #company-list tr {
        border-bottom: 1px solid #ccc;
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

    .add-button {
        text-align: right;
    }
</style>

</head>
<body>
    <div id="sidebar">
        <div id='all_actions'>All Actions</div>
        <ul>
            <li><a href="{{ route('company.index') }}">Company</a></li>
            <li><a href="{{ route('employee.index') }}">Employee</a></li>
        </ul>
        <div id="logout-form">
            <!-- Authentication -->
            <form method="POST" action="{{ route('login') }}" x-data>
                @csrf
                <x-dropdown-link href="{{ route('login') }}" @click.prevent="$root.submit();">
                    {{ __('Log Out') }}
                </x-dropdown-link>
            </form>
        </div>
    </div>
    <div id="main-content">
        <div id="title">
            <h3>Company List</h3>
        </div>
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
    </div>
    <div id="pagination-links" class="pagination-links"></div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script>
   $(document).ready(function() {
    // Send AJAX request to fetch company data
    $.ajax({
        url: '/api/index1/company',
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

                renderPaginationLinks(response.data.last_page, response.data.current_page, response.data.prev_page_url, response.data.next_page_url);
            }
        },
        error: function(xhr, status, error) {
            console.log('AJAX request failed. Error: ' + error);
        }
    });
    function renderPaginationLinks(totalPages, currentPage, prevPageUrl, nextPageUrl) {
    var paginationLinksContainer = $('#pagination-links');
    paginationLinksContainer.empty();

    if (prevPageUrl !== null) {
        var prevPageLink = $('<a href="#" class="page-link previous-link">&laquo; Previous</a>');
        prevPageLink.data('page', currentPage - 1); // Store the page number as data
        paginationLinksContainer.append(prevPageLink);
    }

    var currentPageLink = $('<span class="current-page">' + currentPage + '</span>');
    paginationLinksContainer.append(currentPageLink);

    if (nextPageUrl !== null) {
        // Check if there is data available for the next page
        $.ajax({
            url: nextPageUrl,
            type: 'GET',
            success: function(response) {
                var companies = response.data.data;
                if (Array.isArray(companies) && companies.length > 0) {
                    var nextPageLink = $('<a href="#" class="page-link next-link">Next &raquo;</a>');
                    nextPageLink.data('page', currentPage + 1); // Store the page number as data
                    paginationLinksContainer.append(nextPageLink);
                }
            },
            error: function(xhr, status, error) {
                console.log('AJAX request failed. Error: ' + error);
            }
        });
    }
}

$(document).on('click', '.page-link', function(e) {
    e.preventDefault();
    var currentPageLink = $('.current-page');
    var currentPage = parseInt(currentPageLink.text());
    var nextPage;
    
    if ($(this).hasClass('previous-link')) {
        nextPage = currentPage - 1;
    } else {
        nextPage = currentPage + 1;
    }

    // Send AJAX request to fetch companies for the next/previous page
    $.ajax({
        url: '/api/index1/company/?page=' + nextPage,
        type: 'GET',
        success: function(response) {
            var companies = response.data.data;
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
                    '<a href="#" class="edit-button" data-action-id="' + company.id + '">Edit</a> <a href="#" class="delete-button" data-action-id="' + company.id + '">Delete</a> <a href="#" class="update-button" data-action-id="' + company.id + '">Update</a>'
                ]);
            });

            // Draw the updated DataTable
            companyTable.draw();

            // Update the current page link
            currentPageLink.text(nextPage);
            renderPaginationLinks(response.data.last_page, response.data.current_page, response.data.prev_page_url, response.data.next_page_url);
        },
        error: function(xhr, status, error) {
            console.log('AJAX request failed. Error: ' + error);
        }
    });
});

// Event listener for edit button click
$(document).on('click', '.edit-button', function(e) {
    e.preventDefault();

    var actionId = $(this).data('action-id');
    console.log('Edit button clicked for action ID: ' + actionId);

    // Remove any existing modals
    $('.modal').remove();

    // Send AJAX request with the action ID
    $.ajax({
        url: '/api/company/' + actionId + '/edit',
        type: 'GET',
        data: {
            actionId: actionId
        },
        success: function(response) {
            // Create the modal element and set its content
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
            modalContainer.modal('show');
        },
        error: function(xhr, status, error) {
            console.log('AJAX request failed. Error: ' + error);
        }
    });
});
// Event listener for detail button click
$(document).on('click', '.show-button', function(e) {
    e.preventDefault();
    var actionId = $(this).data('action-id');
    console.log('Detail button clicked for action ID: ' + actionId);

    // Remove any existing modals
    $('.modal').remove();

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
                if (response.error === false) {
              window.location.href = '/api/company/'; // Replace '/success-page' with the desired URL
            }
            },
            error: function(xhr, status, error) {
                console.log('AJAX request failed. Error: ' + error);
            }
            });
        }
    });
});
</script>
</body>
</html>


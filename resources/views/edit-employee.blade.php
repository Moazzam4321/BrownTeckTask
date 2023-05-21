<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Company Details</title>
    <style>
        /* Add your desired CSS styles here */
        #company-details-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .company-info {
            margin-bottom: 10px;
        }
        .register-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #f2f2f2;
            border: none;
            color: #000;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>
<body>
  <div id="company-details-container">
    <h1>Company Details</h1>
    <input type="hidden" id="employee-id" value="{{ $employee['id'] }}">
    <div class="company-info">
      <strong>First_Name:</strong> <input type="text" id="employee-first-name" value="{{ $employee['first_name'] }}">
    </div>
    <div class="company-info">
      <strong>Last_Name:</strong> <input type="text" id="employee-last-name" value="{{ $employee['last_name'] }}">
    </div>
    <div class="company-info">
      <strong>Email:</strong> <input type="email" id="employee-email" value="{{ $employee['email'] }}">
    </div>
    <div class="company-info">
    <strong>Phone:</strong>
          <input id="employee-phone" type="text"  value="{{ old('phone') }}"  autocomplete="phone" autofocus pattern="[0-9]{10}" title="Please enter a 10-digit phone number">
    </div>
    <a href="#" id="edit-button" class="register-button">Edit</a>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(document).ready(function() {
      var initialCompanyData = {
        first_name: $('#employee-first-name').val(),
        last_name: $('#employee-last-name').val(),
        email: $('#employee-email').val(),
        phone: $('#employee-phone').val()
      };

      $('#edit-button').on('click', function(e) {
        e.preventDefault();
        updateCompany();
      });

      function updateCompany() {
        var employeeId = $('#employee-id').val();
        var updatedCompanyData = {
          first_name: $('#employee-first-name').val(),
          last_name: $('#employee-last-name').val(),
          email: $('#employee-email').val(),
          phone: $('#employee-phone').val()
        };

        // Compare field values with initial values
        var updatedFields = {};
        for (var key in updatedCompanyData) {
          if (updatedCompanyData.hasOwnProperty(key) && updatedCompanyData[key] !== initialCompanyData[key]) {
            updatedFields[key] = updatedCompanyData[key];
          }
        }

        // Perform AJAX request to update the company if there are updated fields
        if (Object.keys(updatedFields).length > 0) {
          $.ajax({
            url: '/api/employee/' + employeeId,
            type: 'PUT',
            data: {
              updatedFields: updatedFields,
              employeeId: employeeId
            },
            success: function(response) {
              // Handle the success response
              console.log('Employee updated successfully.');
              console.log(response.error);
              if (response.error === false) {
                window.location.href = '/api/employee/'; // Replace '/success-page' with the desired URL
              }
            },
            error: function(xhr, status, error) {
              // Handle the error response
              console.log('An error occurred while updating the company.');
              console.log('Status: ' + status);
              console.log('Error: ' + error);
            }
          });
        }
      }
    });
  </script>
</body>
</html>

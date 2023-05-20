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
  <input type="hidden" id="company-id" value="{{ $company['id'] }}">
  <div class="company-info">
    <strong>Name:</strong> <input type="text" id="company-name" value="{{ $company['name'] }}">
  </div>
  <div class="company-info">
    <strong>Email:</strong> <input type="email" id="company-email" value="{{ $company['email'] }}">
  </div>
  <div class="company-info">
    <strong>Logo:</strong>
    <img id="logo-preview" src="{{ $company['logo'] }}" alt="Company Logo" width="100">
    <input type="file" id="company-logo" accept="image/*">
  </div>
  <div class="company-info">
    <strong>Website:</strong> <input type="text" id="company-website" value="{{ $company['website'] }}">
  </div>
  <a href="#" id="edit-button" class="register-button">Edit</a>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function() {
    var initialCompanyData = {
      name: $('#company-name').val(),
      email: $('#company-email').val(),
      website: $('#company-website').val()
    };

   

    $('#edit-button').on('click', function(e) {
      e.preventDefault();
      updateCompany();
    });

    function updateCompany() {
      var companyId = $('#company-id').val();
      var updatedCompanyData = {
        name: $('#company-name').val(),
        email: $('#company-email').val(),
        website: $('#company-website').val()
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
          url: '/api/company/' + companyId,
          type: 'PUT',
          data: {
            updatedFields,
            companyId : companyId
          },
          success: function(response) {
            // Handle the success response
            console.log('Company updated successfully.');
            console.log(response.error);
            if (response.error === false) {
              window.location.href = '/api/company/'; // Replace '/success-page' with the desired URL
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
</html>

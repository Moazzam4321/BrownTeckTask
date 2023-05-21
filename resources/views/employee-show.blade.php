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
    <strong>First_Name:</strong> <input type="text" id="employee-first-name" value="{{ $employee['first_name'] }}" readonly>
  </div>
  <div class="company-info">
    <strong>Last_Name:</strong> <input type="text" id="employee-last-name" value="{{ $employee['last_name'] }}" readonly>
  </div>
  <div class="company-info">
    <strong>Email:</strong> <input type="email" id="employee-email" value="{{ $employee['email'] }}" readonly>
  </div>
  <div class="company-info">
    <strong>Phone:</strong> <input type="test" id="employee-phone" value="{{ $employee['phone'] }}" readonly>
  </div>
</div>
</body>
</html>
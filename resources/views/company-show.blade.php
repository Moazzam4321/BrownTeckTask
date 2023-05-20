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
    <h1>Company Detail</h1>
    <div class="company-info">
    <input type="hidden" id="company-id" value="{{ $company['id'] }}">
    </div>
    <div class="company-info">
        <strong>Name:</strong> <input type="text" id="company-name" value="{{ $company['name'] }}" readonly>
    </div>
    <div class="company-info">
        <strong>Email:</strong> <input type="email" id="company-email" value="{{ $company['email'] }}" readonly>
    </div>
    <div class="company-info">
    <strong>Logo:</strong>
    <img id="logo-preview" src="{{ $company['logo'] }}" alt="Company Logo" width="100">
    </div>
    <div class="company-info">
        <strong>Website:</strong> <input type="text" id="company-website" value="{{ $company['website'] }}" readonly>
</body>
</html>
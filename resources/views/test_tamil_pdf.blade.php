<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Tamil PDF Test</title>
  <style>
  body {
    font-family: sans-serif;
    padding: 30px;
  }
  h1 {
    color: #bd099d;
    text-align: center;
    margin-bottom: 30px;
    font-size: 24px;
  }
  .message {
    font-size: 20px;
    padding: 20px;
    background-color: #f9f9f9;
    border: 1px solid #ddd;
    margin: 20px 0;
    text-align: center;
  }
  .footer {
    margin-top: 40px;
    text-align: center;
    font-size: 12px;
    color: #666;
  }
  </style>
</head>
<body>
  <h1>தமிழ் PDF சோதனை</h1>
  <div class="message">{{ $message }}</div>
  <div class="footer">
    <p>Generated: {{ date('d-m-Y H:i:s') }}</p>
  </div>
</body>
</html>


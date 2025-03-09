<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form</title>
    <!-- Include reCAPTCHA API -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>
    <form action="sendEmail.php" method="post">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br><br>
        
        <label for="designation">Designation:</label>
        <input type="text" id="designation" name="designation" required><br><br>
        
        <label for="company">Company Name:</label>
        <input type="text" id="company" name="company" required><br><br>
        
        <label for="cell">Cell Phone:</label>
        <input type="text" id="cell" name="cell" required><br><br>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>
        
        <label for="address">Address:</label>
        <input type="text" id="address" name="address" required><br><br>
        
        <label for="message">Message:</label><br>
        <textarea id="message" name="message" required></textarea><br><br>

        <!-- reCAPTCHA widget -->
        <div class="g-recaptcha" data-sitekey="6LcvergqAAAAAJjTC4rfBvfVZz4I6hDpfS8nMNnj"></div><br><br>

        <button type="submit">Send</button>
    </form>
</body>
</html>

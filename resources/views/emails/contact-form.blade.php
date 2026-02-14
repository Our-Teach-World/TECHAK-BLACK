<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #000000; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #000000; color: #ffffff; padding: 20px; }
        .content { padding: 30px; background: #f5f5f5; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>New Contact Form Submission</h1>
        </div>
        
        <div class="content">
            <p>A new message has been received through the contact form.</p>
            
            <h3>Contact Details:</h3>
            <p>
                <strong>Name:</strong> {{ $contact->name }}<br>
                <strong>Email:</strong> {{ $contact->email }}<br>
                <strong>Date:</strong> {{ $contact->created_at->format('d M Y, h:i A') }}
            </p>
            
            <h3>Message:</h3>
            <p style="background: #ffffff; padding: 15px; border-left: 3px solid #000000;">
                {{ $contact->message }}
            </p>
            
            <p>Please respond to this inquiry as soon as possible.</p>
        </div>
    </div>
</body>
</html>

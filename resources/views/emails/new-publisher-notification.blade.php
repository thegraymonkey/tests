<!DOCTYPE html>
<html lang="en">
<head>
    <title>Approval Request</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            color: #333;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        .header {
            text-align: center;
            background-color: #007bff;
            color: #ffffff;
            padding: 15px;
            border-radius: 8px 8px 0 0;
        }
        .header h1 {
            margin: 0;
            font-size: 1.5em;
        }
        .content {
            padding: 20px;
        }
        .content h2 {
            font-size: 1.3em;
            color: #007bff;
            margin-bottom: 10px;
        }
        .content ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .content ul li {
            margin-bottom: 10px;
        }
        .content ul li strong {
            color: #555;
        }
        .action-buttons {
            text-align: center;
            margin-top: 20px;
        }
        .action-buttons a {
            display: inline-block;
            padding: 10px 20px;
            margin: 0 5px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 1em;
            color: #ffffff;
        }
        .approve {
            background-color: #28a745;
        }
        .approve:hover {
            background-color: #218838;
        }
        .spam {
            background-color: #dc3545;
        }
        .spam:hover {
            background-color: #c82333;
        }
        .footer {
            text-align: center;
            font-size: 0.9em;
            color: #777;
            margin-top: 20px;
            padding: 10px;
            border-top: 1px solid #ddd;
        }
    </style>
</head>
<body>
<div class="email-container">
    <div class="header">
        <h1>Approval Request</h1>
    </div>
    <div class="content">
        <!-- Publisher Section -->
        <h2>New Publisher Approval Needed</h2>
        <p>A new publisher has been created and needs approval:</p>
        <ul>
            <li><strong>Email:</strong> {{ $publisher->email }}</li>
            <li><strong>Created At:</strong> {{ $publisher->created_at }}</li>
        </ul>
        <div class="action-buttons">
            <a href="{{ route('publisher.approve', ['id' => $publisher->id]) }}" class="approve">Approve</a>
            <a href="{{ route('publisher.spam', ['id' => $publisher->id]) }}" class="spam">Mark as Spam</a>
        </div>

        <!-- Job Post Section -->
        <h2>New Job Post Approval Needed</h2>
        <p>A new job has been created and needs approval:</p>
        <ul>
            <li><strong>Title:</strong> {{ $post->title }}</li>
            <li><strong>Description:</strong> {{ $post->description }}</li>
        </ul>
    </div>
    <div class="footer">
        <p>This email was sent automatically. If you have any questions, please contact us.</p>
    </div>
</div>
</body>
</html>


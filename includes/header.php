<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?> - TourismPro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <style>
        .dashboard-container {
            display: flex;
            min-height: 100vh;
        }
        .sidebar {
            width: 250px;
            background: #343a40;
            color: white;
            padding-top: 20px;
        }
        .main-content {
            flex: 1;
            background: #f8f9fa;
        }
        .nav-link {
            color: rgba(255,255,255,.8);
            padding: 15px 20px;
        }
        .nav-link:hover {
            color: white;
            background: rgba(255,255,255,.1);
        }
    </style>
</head>
<body>

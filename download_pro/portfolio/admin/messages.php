<?php
require_once '../config.php';

if (!isLoggedIn()) {
    redirect('../admin_login.php');
}

$user = getUserData();
$error = '';
$success = '';

// Handle delete
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $delete_id = (int)$_POST['delete_id'];
    $query = "DELETE FROM contact_messages WHERE id = $delete_id";
    if ($conn->query($query) === TRUE) {
        $success = 'Message deleted successfully!';
    } else {
        $error = 'Error: ' . $conn->error;
    }
}

// Get all messages
$query = "SELECT * FROM contact_messages ORDER BY created_at DESC";
$result = $conn->query($query);
$messages = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Messages | Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body {
            background: #f8f9fa;
            font-family: 'Poppins', sans-serif;
        }
        
        .sidebar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
            position: fixed;
            left: 0;
            top: 0;
            width: 250px;
            color: white;
        }
        
        .sidebar h3 {
            margin-bottom: 30px;
            font-weight: 700;
        }
        
        .sidebar ul {
            list-style: none;
        }
        
        .sidebar ul li {
            margin-bottom: 15px;
        }
        
        .sidebar ul li a {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 15px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        
        .sidebar ul li a:hover {
            background: rgba(255, 255, 255, 0.2);
        }
        
        .sidebar ul li a.active {
            background: rgba(255, 255, 255, 0.3);
        }
        
        .main-content {
            margin-left: 250px;
            padding: 30px;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        .header h1 {
            margin: 0;
            font-size: 1.8rem;
            color: #2d3436;
        }
        
        .content-section {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        table thead {
            background: #f8f9fa;
        }
        
        table th {
            padding: 15px;
            text-align: left;
            color: #2d3436;
            font-weight: 600;
            border-bottom: 2px solid #ddd;
        }
        
        table td {
            padding: 15px;
            border-bottom: 1px solid #ddd;
        }
        
        .action-btn {
            padding: 8px 12px;
            margin-right: 5px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.85rem;
            transition: all 0.3s ease;
        }
        
        .btn-view {
            background: #4facfe;
            color: white;
        }
        
        .btn-delete {
            background: #ff6b6b;
            color: white;
        }
        
        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        
        .alert {
            border-radius: 8px;
            margin-bottom: 20px;
        }
        
        .modal-content {
            border-radius: 10px;
        }
        
        .modal-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
        }
        
        .modal-header .btn-close {
            filter: brightness(0) invert(1);
        }
        
        .message-detail {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 15px;
        }
        
        .message-detail strong {
            color: #667eea;
        }
        
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }
            
            .main-content {
                margin-left: 0;
            }
            
            table {
                font-size: 0.9rem;
            }
            
            table th, table td {
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h3><i class="bi bi-speedometer2"></i> Admin Panel</h3>
        <ul>
            <li><a href="dashboard.php"><i class="bi bi-house"></i> Dashboard</a></li>
            <li><a href="profile.php"><i class="bi bi-person"></i> Profile</a></li>
            <li><a href="services.php"><i class="bi bi-briefcase"></i> Services</a></li>
            <li><a href="skills.php"><i class="bi bi-star"></i> Skills</a></li>
            <li><a href="projects.php"><i class="bi bi-folder"></i> Projects</a></li>
            <li><a href="testimonials.php"><i class="bi bi-chat-quote"></i> Testimonials</a></li>
            <li><a href="messages.php" class="active"><i class="bi bi-envelope"></i> Messages</a></li>
            <li><a href="logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
        </ul>
    </div>
    
    <!-- Main Content -->
    <div class="main-content">
        <div class="header">
            <h1>Contact Messages</h1>
        </div>
        
        <?php if (!empty($success)): ?>
            <div class="alert alert-success" role="alert">
                <i class="bi bi-check-circle"></i> <?php echo $success; ?>
            </div>
        <?php endif; ?>
        
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger" role="alert">
                <i class="bi bi-exclamation-circle"></i> <?php echo $error; ?>
            </div>
        <?php endif; ?>
        
        <div class="content-section">
            <?php if (count($messages) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Subject</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($messages as $message): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($message['name']); ?></td>
                                <td><?php echo htmlspecialchars($message['email']); ?></td>
                                <td><?php echo htmlspecialchars($message['subject'] ?? 'No Subject'); ?></td>
                                <td><?php echo date('M d, Y H:i', strtotime($message['created_at'])); ?></td>
                                <td>
                                    <button class="action-btn btn-view" data-bs-toggle="modal" data-bs-target="#messageModal<?php echo $message['id']; ?>">
                                        <i class="bi bi-eye"></i> View
                                    </button>
                                    <form method="POST" style="display: inline;">
                                        <input type="hidden" name="delete_id" value="<?php echo $message['id']; ?>">
                                        <button type="submit" class="action-btn btn-delete" onclick="return confirm('Are you sure?')">
                                            <i class="bi bi-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            
                            <!-- Modal -->
                            <div class="modal fade" id="messageModal<?php echo $message['id']; ?>" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Message from <?php echo htmlspecialchars($message['name']); ?></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="message-detail">
                                                <strong>Name:</strong><br>
                                                <?php echo htmlspecialchars($message['name']); ?>
                                            </div>
                                            <div class="message-detail">
                                                <strong>Email:</strong><br>
                                                <a href="mailto:<?php echo htmlspecialchars($message['email']); ?>"><?php echo htmlspecialchars($message['email']); ?></a>
                                            </div>
                                            <div class="message-detail">
                                                <strong>Subject:</strong><br>
                                                <?php echo htmlspecialchars($message['subject'] ?? 'No Subject'); ?>
                                            </div>
                                            <div class="message-detail">
                                                <strong>Date:</strong><br>
                                                <?php echo date('M d, Y H:i:s', strtotime($message['created_at'])); ?>
                                            </div>
                                            <div class="message-detail">
                                                <strong>Message:</strong><br>
                                                <p><?php echo nl2br(htmlspecialchars($message['message'])); ?></p>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <a href="mailto:<?php echo htmlspecialchars($message['email']); ?>" class="btn btn-primary">
                                                <i class="bi bi-reply"></i> Reply
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="bi bi-inbox" style="font-size: 3rem; color: #ccc;"></i>
                    <p style="color: #aaa; margin-top: 15px;">No messages yet.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$link = mysqli_connect("localhost", "root", "", "cateringphp");
$status = null;
$order_id = "";

if (isset($_POST['search'])) {
    $order_id = mysqli_real_escape_string($link, $_POST['order_id']);
    $sql = "SELECT sh_status FROM sh_order WHERE id='$order_id'";
    $res = mysqli_query($link, $sql);

    if (mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_assoc($res);
        $status = $row['sh_status'];
    } else {
        $status = "not_found";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Status Tracker</title>
<link href="css/bootstrap.min.css" rel="stylesheet">
<style>
body {
            background: #f0f0f0;
            font-family: Arial, sans-serif;
        }
        .container {
            background: #fff;
            margin-top: 50px;
            padding: 30px;
            border: 1px solid #e6e6e6;
            box-shadow: 0 1px 5px rgba(0,0,0,0.1);
            border-radius: 5px;
        }
        h3 {
            color: #816943;
            font-weight: bold;
            margin-bottom: 30px;
        }
        .status-box {
            display: inline-block;
            padding: 20px;
            width: 200px;
            text-align: center;
            border: 2px solid #ccc;
            border-radius: 8px;
            background-color: #fff;
            color: #333;
            font-weight: bold;
        }
        .active-status {
            background-color: #816943;
            color: white;
            border-color: #816943;
        }
        .arrow {
            display: inline-block;
            margin: 0 15px;
            font-size: 24px;
            color: #816943;
        }
        .btn-custom {
            background: #816943;
            color: white;
            border-radius: 0px;
        }
        .btn-custom:hover {
            background: #6d5938;
            color: white;
        }
        /* Navbar style from index.php */
        .top-nav {
            background: #816943;
            padding: 10px 0;
            color: white;
        }
        .top-nav-left ul {
            margin: 0;
            padding: 0;
            list-style: none;
            text-align: center;
        }
        .top-nav-left ul li {
            display: inline-block;
            margin: 0 20px;
        }
        .top-nav-left ul li a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }
        .top-nav-left ul li.active a,
        .top-nav-left ul li a:hover {
            color: #ffebcd;
            border-bottom: 2px solid #ffebcd;
            padding-bottom: 3px;
        }
</style>
</head>

<body>
  <div class="top-nav">
        <div class="top-nav-left">
            <ul>
                <li><a href="index.php" style="text-decoration:none;">Home</a></li>
                <li><a href="order.php" style="text-decoration:none;">Order</a></li>
                <li><a href="contact.php" style="text-decoration:none;">Contact</a></li>
                <li><a href="index.php" style="text-decoration:none;">Login</a></li>
                <li class="active"><a href="status_tracker.php" style="text-decoration:none;">Status Tracker</a></li>
                <div class="clear"> </div>
            </ul>
        </div>
        <div class="clear"> </div>
    </div>
<div class="container text-center">
    <h3>Status Check</h3>
    <form method="post" class="form-inline justify-content-center">
        <div class="form-group">
            <label for="order_id" class="mr-2">Order ID:</label>
            <input type="text" name="order_id" class="form-control" value="<?php echo htmlspecialchars($order_id); ?>" required>
        </div>
        <button type="submit" name="search" class="btn btn-custom ml-2">Search</button>
    </form>

    <hr>

    <?php if ($status === "not_found") { ?>
        <div class="alert alert-danger mt-3">❌ Order not found. Please check your Order ID.</div>
    <?php } elseif ($status) { ?>
        <div class="mt-4">
            <div class="status-box <?php echo ($status == 'Confirmed') ? 'active-status' : ''; ?>">Order confirmed</div>
            <span class="arrow">➜</span>
            <div class="status-box <?php echo ($status == 'Prepared/Delivering') ? 'active-status' : ''; ?>">Prepared / Delivering</div>
            <span class="arrow">➜</span>
            <div class="status-box <?php echo ($status == 'Delivered') ? 'active-status' : ''; ?>">Delivered</div>
        </div>
        <p class="mt-4 text-muted">Current Status: <strong><?php echo htmlspecialchars($status); ?></strong></p>
    <?php } ?>
</div>

<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>

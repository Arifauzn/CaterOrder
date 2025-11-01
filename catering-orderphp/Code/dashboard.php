<?php
session_start();
if(!isset($_SESSION["sh_user"]))
{
    header("Location: index.php");
}
// Handle status updates
$link = mysqli_connect("localhost", "root", "", "cateringphp");

if (isset($_POST['update_status'])) {
    $id = $_POST['order_id'];
    $status = $_POST['status'] ?? '';

    $update = "UPDATE sh_order SET sh_status='$status' WHERE id='$id'";
    if (mysqli_query($link, $update)) {
        echo '<div class="alert alert-success alert-dismissible fade in" style="margin:10px;">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                ✅ Status for Order ID '.$id.' updated successfully!
              </div>';
    } else {
        echo '<div class="alert alert-danger alert-dismissible fade in" style="margin:10px;">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                ❌ Failed to update status. Please try again.
              </div>';
    }
}
if (isset($_POST['update_payment'])) {
    $id = $_POST['order_id'];
    $payment = $_POST['payment_status'] ?? '';

    $update = "UPDATE sh_order SET payment_status='$payment' WHERE id='$id'";
    if (mysqli_query($link, $update)) {
        echo '<div class="alert alert-success alert-dismissible fade in" style="margin:10px;">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                💳 Payment status for Order ID '.$id.' updated successfully!
              </div>';
    } else {
        echo '<div class="alert alert-danger alert-dismissible fade in" style="margin:10px;">
                ❌ Failed to update payment status.
              </div>';
    }
}
?>
<!DOCTYPE>
<html en="lang">
<head>
<title>Dashboard</title>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="css/bootstrap.min.css" rel="stylesheet">
<script src="js/respond.js"></script>
<link href="css/style.css" rel="stylesheet" type="text/css"  media="all" /> 

<style>
    body{
            background: #f0f0f0;
        }
    sidebar-menu{
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
            -webkit-box-shadow: 0 1px 5px rgba(0, 0, 0, 0.1);
            box-shadow: 0 1px 5px rgba(0, 0, 0, 0.1);
        }
        
    .box {
            background: #fff;
            margin: 0 0 30px;
            border: solid 1px #e6e6e6;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
            padding: 20px;
            -webkit-box-shadow: 0 1px 5px rgba(0, 0, 0, 0.1);
            box-shadow: 0 1px 5px rgba(0, 0, 0, 0.1);
        }
    thead{
        background: #816943;
        border-radius: 0px;
        color: white;
    }
    .nav-pills>li.active>a:hover{
        background: #816943;
    }
    .nav-pills>li.active>a{
        background: #816943;
        border-radius: 0px;
        }
    .navbar-text {
        margin-top: 15px;
        margin-bottom: 15px;
        font-size: 20px;
        }
    a{
        color: #816943;
    }
    a:hover{
        color: #816943;
    }
    .btn-default
    {
        background: #f44336;
        color: #fff;
        
    }
    .btn-default:hover
    {
        background: #f44336;
        color: #fff;
    }
    .logo {
        font-size:29px;
        color:white;
        font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
    }
</style>
</head>
<body>
    <div class="header"> 
	     <div class="wrap">
			<div class="top-header">
				<div class="logo">
                Catering Ordering System
				</div>
				<div class="clear"> </div>
			</div>
		</div>
	</div>
    <nav class="navbar navbar-default navbar-fixed">
        <div class="navbar-header">
            <div class="navbar-text pull-right"><span class="glyphicon glyphicon-user"></span> <?php echo $_SESSION["sh_user"]; ?></div>
            
        </div>
    </nav>
    
        
        <div class="col-md-12">
            <div class="col-md-2">
                <div class="panel panel-default sidebar-menu">

                    <div class="panel-heading"><span class="glyphicon glyphicon-th-large"></span> DASHBOARD</div>

                        <div class="panel-body">

                            <ul class="nav nav-pills nav-stacked">
                                <li class="active">
                                    <?php 
                                    $link = mysqli_connect("localhost", "root", "", "cateringphp");
                                    $sql = "SELECT * FROM sh_contact";
                                    $res = mysqli_query($link,$sql);
                                    $sql1 = "SELECT * FROM sh_order";
                                    $res1 = mysqli_query($link,$sql1);
                                ?>
                                <li  class="active">
                                    <a href="dashboard.php"><i class="glyphicon glyphicon-list"></i> Orders <span class="badge pull-right"><?php echo mysqli_num_rows($res1); ?></span></a>
                                </li>
                                <li>
                                    <a href="dashboard_message.php"><i class="glyphicon glyphicon-envelope"></i> Messages <span class="badge pull-right"><?php echo mysqli_num_rows($res); ?></span></a>
                                </li>
                                <?php
                                ?>
                                <li>
                                    <a href="logout.php"><i class="glyphicon glyphicon-log-out"></i> Logout</a>
                                </li>
                            </ul>
                        </div>

                </div>
            </div>
            <div class="col-md-10">
                <div class="box">
                    <p class="pull-right"><?php echo date("Y-m-d H:i:s"); ?></p>

                    <p class="lead">Received Orders</p><hr>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Date</th>
                                        <th>Fullname</th>
                                        <th>Email</th>
                                        <th>Mobile</th>
                                        <th>Company</th>
                                        <th>Budget</th>
                                        <th>Total People</th>
                                        <th>Type</th>
                                        <th>Prefered Menu</th>
                                        <th>Service Type</th>
                                        <th>Venue Details/Menu Required</th>
                                        <th>Venue Address</th>
                                        <th>Status</th>
                                        <th>Payment</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <?php
                                $link = mysqli_connect("localhost", "root", "", "cateringphp");
                                     
                                
                                        $sql = "SELECT * FROM sh_order";
                                        $MyData = mysqli_query($link, $sql);

                                        $cnt=1;
                                        while($res=mysqli_fetch_array($MyData))
                                        {
                                            
                                            ?>
                                                
                                                <tbody>
                                                    <tr>
                                                        <th><?php echo $cnt; ?></th>
                                                        <td><?php echo date('F j, Y', $res["sh_datetime"]); ?></td>
                                                        <td><?php echo $res["sh_fullname"]; ?></td>
                                                        <td><?php echo $res["sh_email"]; ?></td>
                                                        <td><?php echo $res["sh_mobile"]; ?></td>
                                                        <td><?php echo $res["sh_companyname"]; ?></td>
                                                        <td><?php echo '$'.$res["sh_budget"]; ?></td>
                                                        <td><?php echo $res["sh_people"]; ?></td>
                                                        <td><?php echo $res["sh_function"]; ?></td>
                                                        <td><?php echo $res["sh_menu"]; ?></td>
                                                        <td><?php echo $res["sh_service"]; ?></td>
                                                        <td><?php echo $res["sh_detailsvenue"]; ?></td>
                                                        <td><?php echo $res["sh_addressvenue"]; ?></td>
                                                        <form method="post" action="dashboard.php">
                                                            <td>
                                                                <select name="status" class="form-control input-sm">
                                                                    <option value="Order confirmed" <?php if($res["sh_status"]=="Confirmed") echo "selected"; ?>>Order confirmed</option>
                                                                    <option value="Prepared/Delivering" <?php if($res["sh_status"]=="Prepared/Delivering") echo "selected"; ?>>Prepared/Delivering</option>
                                                                    <option value="Delivered" <?php if($res["sh_status"]=="Delivered") echo "selected"; ?>>Delivered</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="payment_status" class="form-control input-sm">
                                                                    <option value="Pending" <?php if($res["payment_status"]=="Pending") echo "selected"; ?>>Pending</option>
                                                                    <option value="Paid" <?php if($res["payment_status"]=="Paid") echo "selected"; ?>>Paid</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input type="hidden" name="order_id" value="<?php echo $res['id']; ?>">
                                                                <button name="update_status" type="submit" class="btn btn-success btn-sm">Update Status</button>
                                                                <button name="update_payment" type="submit" class="btn btn-primary btn-sm">Update Payment</button>
                                                                <a href="deleteorder.php?id=<?php echo $res['id'];?>" class="btn btn-danger btn-sm">Delete</a>
                                                            </td>
                                                        </form>
                                                    </tr>
                                                <?php
                                            $cnt++;  }
                                        ?>
                                
                                </tbody>
                            </table>
                        </div>
                    </div>
            </div>
        </div>
    
    
    
<script src="js/jquery.min.js"></script>
<script src="js/jquery-ui.js"></script>
<script src="js/bootstrap.min.js"></script>    
</body>
</html>


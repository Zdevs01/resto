<?php 
session_start();
include('../config/constants.php'); 

// Vérifier si l'utilisateur est connecté
if(!isset($_SESSION['user-admin'])) {
    header('location: login.php');
    exit();
}
?>

<?php 

//Stats

$sales_by_hour = "SELECT HOUR(pay_time) as hname,
					sum(amount) as total_sales
					FROM aamarpay
					GROUP BY HOUR(pay_time)";
					 

$res_sales_by_hour = mysqli_query($conn, $sales_by_hour);

$most_sold_items = "SELECT sum(Quantity) as total_qty,
							Item_Name as item_name
							FROM online_orders_new
							GROUP BY Item_Name
							";
$res_most_sold_items = mysqli_query($conn, $most_sold_items);

//Orders

$ei_order_notif = "SELECT order_status from tbl_eipay
					WHERE order_status='Pending' OR order_status='Processing'";

$res_ei_order_notif = mysqli_query($conn, $ei_order_notif);

$row_ei_order_notif = mysqli_num_rows($res_ei_order_notif);

$online_order_notif = "SELECT order_status from order_manager
					WHERE order_status='Pending'OR order_status='Processing' ";

$res_online_order_notif = mysqli_query($conn, $online_order_notif);

$row_online_order_notif = mysqli_num_rows($res_online_order_notif);

// Stock Notification
$stock_notif = "SELECT stock FROM tbl_food
				WHERE stock<50";

$res_stock_notif = mysqli_query($conn, $stock_notif);
$row_stock_notif = mysqli_num_rows($res_stock_notif);


// Revenue Generated
$revenue = "SELECT SUM(total_amount) AS total_amount FROM order_manager
			WHERE order_status='Delivered' ";
$res_revenue = mysqli_query($conn, $revenue);
$total_revenue = mysqli_fetch_array($res_revenue);

//Total Orders Delivered

$orders_delivered = "SELECT order_status FROM order_manager
					 WHERE order_status='Delivered'";
$res_orders_delivered = mysqli_query($conn, $orders_delivered);
$total_orders_delivered = mysqli_num_rows($res_orders_delivered);

//Message Notification
$message_notif = "SELECT message_status FROM message
				 WHERE message_status = 'unread'";
$res_message_notif = mysqli_query($conn, $message_notif);
$row_message_notif = mysqli_num_rows($res_message_notif);



?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Boxicons -->
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<!-- My CSS -->
	<link rel="stylesheet" href="style-admin.css">
	<link rel="icon" 
      type="image/png" 
      href="../images/logo.png">

	<!-- Chart ---> 
		
	
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
	
        var data = google.visualization.arrayToDataTable([
          ['Item Name', 'Sales'], 
          <?php
		  while($row_sales=mysqli_fetch_array($res_most_sold_items))
		  {
			  echo "['".$row_sales["item_name"]."', ".$row_sales["total_qty"]."],";
		  }
		  ?>
          ]);
		   
        var options = {
          title: 'Most Sold Items',
          pieHole: 0.4,
		  fontName: 'Poppins',
		  fontSize: 12,
		  //is3D:true,
		  titleTextStyle: { color: "Grey",
  							fontName: "Poppins",
  							fontSize: 16,
  							bold: false,
  							italic: false },
		
        };

        var chart = new google.visualization.PieChart(document.getElementById('donutchart_msi'));
        chart.draw(data, options);	
      }
	  
    </script>

	<!-- Chart End --> 

	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Time' , 'Sales'],
		   <?php
		  while($row_sales_by_hour=mysqli_fetch_array($res_sales_by_hour))
		  {
			  echo "['".$row_sales_by_hour["hname"]."', ".$row_sales_by_hour["total_sales"]."],";
		  }

		  ?>
		
          
        ]);

        var options = 
		{
			hAxis: 
			{
				title: 'Time', titleTextStyle:
				{
					color: 'Black'
				}
			},
      		colors: ['#eb2f06','green'],
			
            chart: 
			{
            title: 'Sales By Hour',
           } 
        };

        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    </script>
	
	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

	<title>GoodFood Admin</title>
</head>
<body>


	<!-- SIDEBAR -->
	<?php include('dashbord.php'); ?>

	<!-- SIDEBAR -->
	
	 <!-- Dynamic Dashborad --> 

            <?php
            //Categories

            $sql = "SELECT * FROM tbl_category";

            $res = mysqli_query($conn, $sql);

            $row_cat = mysqli_num_rows($res);
            
            //Items

            $sql2 = "SELECT * FROM tbl_food";

            $res2 = mysqli_query($conn, $sql2);

            $row_item = mysqli_num_rows($res2);

            //Orders

            $sql3 = "SELECT * FROM order_manager";

            $res3 = mysqli_query($conn, $sql3);

            $row_order = mysqli_num_rows($res3);

			//Eat In Orders


	  		$sql4 = "SELECT * FROM tbl_eipay";

            $res4 = mysqli_query($conn, $sql4);

            $row_ei_order = mysqli_num_rows($res4);

        ?>


	<!-- Dynamic DashBoard --> 


	<!-- CONTENT -->
	<section id="content">
	<!-- BARRE DE NAVIGATION -->
	<nav>
		<i class='bx bx-menu'></i>
		<a href="#" class="nav-link"></a>
		<form action="#">
			<div class="form-input">
				<input type="search" placeholder="Rechercher...">
				<button type="submit" class="search-btn"><i class='bx bx-search'></i></button>
			</div>
		</form>
		<input type="checkbox" id="switch-mode" hidden>
		<label for="switch-mode" class="switch-mode"></label>
		<div class="fetch_message">
			<div class="action_message notfi_message">
				<a href="messages.php"><i class='bx bxs-envelope'></i></a>
				<?php 
				if($row_message_notif>0)
				{
					?>
					<span class="num"><?php echo $row_message_notif; ?></span>
					<?php
				}
				else
				{
					?>
					<span class=""></span>
					<?php
				}
				?>
			</div>
		</div>
		
		<div class="notification" onclick="menuToggle();">
			<div class="action notif" onclick="menuToggle();">
				<i class='bx bxs-bell' onclick="menuToggle();"></i>
				<div class="notif_menu">
					<ul>
						<?php 
						if($row_stock_notif>0 and $row_stock_notif !=1)
						{
							?>
							<li><a href="inventory.php"><?php echo $row_stock_notif ?>&nbsp;articles sont en rupture de stock</a></li>
							<?php
						}
						else if($row_stock_notif == 1)
						{
							?>
							<li><a href="inventory.php"><?php echo $row_stock_notif ?>&nbsp;article est en rupture de stock</a></li>
							<?php
						}
						
						if($row_ei_order_notif>0)
						{
							?>
							<li><a href="manage-online-order.php"><?php echo $row_online_order_notif ?>&nbsp;Nouvelle commande en ligne</a></li>
							<?php
						}
						
						if($row_online_order_notif>0)
						{
							?>
							<li><a href="manage-ei-order.php"><?php echo $row_ei_order_notif ?>&nbsp;Nouvelle commande sur place</a></li>
							<?php
						}
						?>
					</ul>
				</div>
				<?php 
				if($row_stock_notif>0 || $row_online_order_notif>0 || $row_ei_order_notif>0)
				{
					$total_notif = $row_online_order_notif + $row_ei_order_notif + $row_stock_notif;
					?>
					<span class="num"><?php echo $total_notif; ?></span>
					<?php
				}
				else
				{
					?>
					<span class=""></span>
					<?php
				}
				?>
			</div>
		</div>
	</nav>
	<!-- BARRE DE NAVIGATION -->
<!-- CONTENU PRINCIPAL -->
<?php


// Vérification du rôle de l'utilisateur
$role = $_SESSION['user-role'] ?? ''; // Évite une erreur si la session n'est pas définie
?>

<main>
    <div class="cards-list">
        <div class="card-stock">
            <?php if ($role === 'Administrateur') { ?>
                <a href="inventory.php">
            <?php } ?>
                <div class="card_image"><img src="../images/inventory.png" /></div>
            <?php if ($role === 'Administrateur') { ?>
                </a>
            <?php } ?>
            <div class="card_title title-white">
                <p>Stock</p>
            </div>
        </div>

        <div class="card-stock2">
            <div class="card_image">
                <?php if ($role === 'Administrateur') { ?><a href="#"><?php } ?>
                    <img src="../images/revenue.png" />
                <?php if ($role === 'Administrateur') { ?></a><?php } ?>
            </div>
            <div class="card_title title-white">
                <p>€<?=$total_revenue['total_amount']?></p>
                <p>Revenu généré</p>
            </div>
        </div>

        <div class="card-stock3">
            <div class="card_image">
                <?php if ($role === 'Administrateur') { ?><a href="#"><?php } ?>
                    <img src="../images/orders_completed.png" />
                <?php if ($role === 'Administrateur') { ?></a><?php } ?>
            </div>
            <div class="card_title title-white">
                <p><?php echo $total_orders_delivered; ?></p>
                <p>Commandes terminées</p>
            </div>
        </div>

        <div class="card-stock4">
            <div class="card_image">
                <?php if ($role === 'Administrateur') { ?><a href="#"><?php } ?>
                    <img src="../images/folder2.png" />
                <?php if ($role === 'Administrateur') { ?></a><?php } ?>
            </div>
            <div class="card_title title-white">
                <p><?php echo $row_item; ?></p>
                <p>Éléments du menu</p>
            </div>
        </div>
    </div>

    <!-- Graphiques -->
    <br>
    <ul class="box-info">
        <li>
            <canvas id="donutChart" style="width: 650px; height: 320px;"></canvas>
        </li>
        <li>
            <canvas id="barChart" style="width: 650px; height: 320px;"></canvas>    
        </li>
    </ul>
    <!-- Fin Graphiques -->
</main>
	

	<!-- CONTENU PRINCIPAL -->
</section>

<!-- CONTENT -->
<script src="script-admin.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const ctxDonut = document.getElementById('donutChart').getContext('2d');
        const ctxBar = document.getElementById('barChart').getContext('2d');

        const donutChart = new Chart(ctxDonut, {
            type: 'doughnut',
            data: {
                labels: [<?php while($row_sales=mysqli_fetch_array($res_most_sold_items)) { echo "'".$row_sales["item_name"]."',"; } ?>],
                datasets: [{
                    label: 'Ventes',
                    data: [<?php mysqli_data_seek($res_most_sold_items, 0); while($row_sales=mysqli_fetch_array($res_most_sold_items)) { echo $row_sales["total_qty"].","; } ?>],
                    backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4CAF50', '#FF9800'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                animation: { animateScale: true },
                plugins: {
                    legend: { position: 'top' },
                    title: { display: true, text: 'Produits les plus vendus' }
                }
            }
        });

        const barChart = new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: [<?php while($row_sales_by_hour=mysqli_fetch_array($res_sales_by_hour)) { echo "'".$row_sales_by_hour["hname"]."',"; } ?>],
                datasets: [{
                    label: 'Ventes par heure',
                    data: [<?php mysqli_data_seek($res_sales_by_hour, 0); while($row_sales_by_hour=mysqli_fetch_array($res_sales_by_hour)) { echo $row_sales_by_hour["total_sales"].","; } ?>],
                    backgroundColor: '#FF9800'
                }]
            },
            options: {
                responsive: true,
                animation: { duration: 2000, easing: 'easeInOutBounce' },
                scales: {
                    y: { beginAtZero: true }
                },
                plugins: {
                    legend: { display: false },
                    title: { display: true, text: 'Ventes par heure' }
                }
            }
        });
    });
</script>

</body>
</html>
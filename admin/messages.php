<?php include('../config/constants.php');
	  //include('login-check.php');

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
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>GoodFood Admin</title>

	<!-- Boxicons -->
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<!-- Styles -->
	<link rel="stylesheet" href="style-admin.css">
	<link rel="icon" type="image/png" href="../images/logo.png">

	<!-- Google Charts -->
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	
    <script type="text/javascript">
      google.charts.load("current", {packages:["corechart", "bar"]});
      
      google.charts.setOnLoadCallback(drawMostSoldItemsChart);
      function drawMostSoldItemsChart() {
        var data = google.visualization.arrayToDataTable([
          ['Produit', 'Ventes'],
          <?php
          while($row = mysqli_fetch_array($res_most_sold_items)) {
              echo "['".$row["item_name"]."', ".$row["total_qty"]."],";
          }
          ?>
        ]);

        var options = {
          title: 'Produits les plus vendus',
          pieHole: 0.4,
          fontSize: 12,
          titleTextStyle: { color: "Grey", fontSize: 16 },
          colors: ['#ff9800', '#4caf50', '#f44336', '#2196f3']
        };

        var chart = new google.visualization.PieChart(document.getElementById('donutchart_msi'));
        chart.draw(data, options);
      }

      google.charts.setOnLoadCallback(drawSalesByHourChart);
      function drawSalesByHourChart() {
        var data = google.visualization.arrayToDataTable([
          ['Heure', 'Ventes'],
          <?php
          while($row = mysqli_fetch_array($res_sales_by_hour)) {
              echo "['".$row["hname"]."', ".$row["total_sales"]."],";
          }
          ?>
        ]);

        var options = {
          chart: { title: 'Ventes par heure' },
          hAxis: { title: 'Heure', titleTextStyle: { color: 'black' } },
          colors: ['#ff5722']
        };

        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));
        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    </script>
</head>
<body>

<style>

/* STYLE GÉNÉRAL */
body {
    font-family: 'Poppins', sans-serif;
    background: #f4f4f4;
    margin: 0;
    padding: 0;
}

/* STYLE DU TABLEAU */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    background: white;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

thead {
    background: #007bff;
    color: white;
    font-size: 16px;
    text-transform: uppercase;
}

th, td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

/* LIGNES ALTERNÉES */
tbody tr:nth-child(even) {
    background: #f9f9f9;
}

tbody tr:hover {
    background: #f1f1f1;
}

/* STYLE DES MESSAGES NON LUS */
.unread {
    font-weight: bold;
    color: #dc3545;
}

/* BOUTON DE SUPPRESSION */
.button-7 {
    display: inline-block;
    padding: 8px 12px;
    background: #dc3545;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    transition: 0.3s ease-in-out;
}

.button-7:hover {
    background: #c82333;
}

/* BADGE MESSAGE NON LU */
.unread_message {
    background: #ffecec;
    border-left: 5px solid #dc3545;
    padding: 10px;
}

/* GRAPHIQUES */
.chart-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    margin-top: 20px;
}

.chart-box {
    flex: 1;
    min-width: 300px;
    padding: 15px;
    background: white;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    text-align: center;
}



</style>
	<!-- SIDEBAR -->
	<?php include('dashbord.php'); ?>
	<!-- SIDEBAR -->

	<section id="content">
		<!-- NAVBAR -->
		<?php include('mess.php'); ?>
		<!-- NAVBAR -->

		<main>

			<!-- GRAPHIQUES -->
			
		
			<!-- TABLEAU DES MESSAGES -->
			<div class="table-data-message">
				<h3>Messages reçus</h3>
				<table>
					<thead>
						<tr>
							<th>Nom</th>
							<th>Sujet</th>
							<th>Date</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$sql = "SELECT * FROM message ORDER BY date DESC";
						$res = mysqli_query($conn, $sql);

						if($res == TRUE) {
							while($row = mysqli_fetch_assoc($res)) {
								$id = $row['id'];
								$name = $row['name'];
								$subject = $row['subject'];
								$date = $row['date'];
								$message_status = $row['message_status'];

								$class_unread = ($message_status == 'unread') ? "class='unread'" : "";
								echo "<tr>
										<td><a href='read-message.php?id=$id' $class_unread>$name</a></td>
										<td><a href='read-message.php?id=$id' $class_unread>$subject</a></td>
										<td><a href='read-message.php?id=$id' $class_unread>$date</a></td>
										<td><a href='delete-message.php?id=$id' class='button-7'>Supprimer</a></td>
									  </tr>";
							}
						}
						?>
					</tbody>
				</table>
			</div>

		</main>
	</section>

	<script src="script-admin.js"></script>

</body>
</html>

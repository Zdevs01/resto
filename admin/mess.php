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
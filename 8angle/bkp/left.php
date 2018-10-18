<?php
$activeClass = 'active'; 
$styleClass ="style='display:block'";
 ?>
<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
	<!-- sidebar: style can be found in sidebar.less -->
<section class="sidebar">
	<!-- sidebar menu: : style can be found in sidebar.less -->
	<ul class="sidebar-menu" data-widget="tree">
		<li class="header">NAVIGATION BAR</li>
 			
			<!--Navi-->

			<li class="treeview <?php  if($menuitem == 1) { echo $activeClass; } ?>">
				<a href="#">
				<i class="fa fa-cube text-aqua"></i> <span> Inventory System</span>
				<span class="pull-right-container">
				<i class="fa fa-angle-left pull-right"></i>
				</span>
				</a>
				<ul class="treeview-menu"  <?php  if($menuitem == 1) { echo $styleClass; }?>>
					<li><a href="<?php echo BASE_URL;?>category.php?mi=1"><i class="fa fa-object-ungroup text-aqua"></i> Product Categories</a></li>
					<li><a href="<?php echo BASE_URL;?>productsunit.php?mi=1"><i class="fa   fa-industry text-aqua"></i> Product Units</a></li>
					<li><a href="<?php echo BASE_URL;?>products.php?mi=1"><i class="fa fa-th text-aqua"></i> Products List</a></li>
					<li><a href="<?php echo BASE_URL;?>stockman.php?mi=1"><i class="fa  fa-arrows-alt text-aqua"></i> Current Stock</a></li>
					<li><a href="<?php echo BASE_URL;?>products_add.php?mi=1"><i class="fa fa-gg text-aqua"></i> Add Product</a></li>
				<li><a href="<?php echo BASE_URL;?>taxes.php?mi=1"><i class="fa fa-circle-o"></i> Taxes</a></li>
				</ul>
			</li>


              <!--Navi-->			  
             <li class="treeview <?php  if($menuitem == 4) { echo $activeClass; } ?>">
				<a href="#">
				<i class="fa fa-users text-yellow"></i> <span>Supplier</span>
				<span class="pull-right-container">
				<i class="fa fa-angle-left pull-right"></i>
				</span>
				</a>
				<ul class="treeview-menu"  <?php  if($menuitem == 4) { echo $styleClass; }?>>

				<li><a href="<?php echo BASE_URL;?>pus_invoice_non.php?mi=4"><i class="fa fa-circle-o text-yellow"></i> Un-Registered </a></li>

				<li><a href="<?php echo BASE_URL;?>vendors.php?mi=4"><i class="fa  fa-university text-yellow"></i> Vendors List</a></li>        <li><a href="<?php echo BASE_URL;?>vendors_add.php?mi=4"><i class="fa fa-vimeo-square text-yellow"></i> Add Vendor</a></li>
					
				</ul>
			</li>
              <!--Navi-->           
 			<li class="treeview <?php  if($menuitem == 3) { echo $activeClass; } ?>">
				<a href="#">
				<i class="fa fa-clone text-yellow"></i> <span>Purchase Invoice</span>
				<span class="pull-right-container">
				<i class="fa fa-angle-left pull-right"></i>
				</span>
				</a>
				<ul class="treeview-menu"  <?php  if($menuitem == 3) { echo $styleClass; }?>>
				<li><a href="<?php echo BASE_URL;?>pus_invoice.php?mi=3"><i class="fa fa-stack-exchange text-yellow"></i> List Purchase Inv</a></li>
				<li><a href="<?php echo BASE_URL;?>pus_invoice_add.php?mi=3"><i class="fa  fa-pencil-square-o text-yellow"></i> Add Purchase Inv</a></l>		
							
				</ul>
			</li>

			<!--Navi-->
             <li class="treeview <?php  if($menuitem == 2) { echo $activeClass; } ?>">
				<a href="#">
				<i class="fa fa-users text-green"></i> <span>Sale Customers </span>
				<span class="pull-right-container">
				<i class="fa fa-angle-left pull-right"></i>
				</span>
				</a>
				<ul class="treeview-menu"  <?php  if($menuitem == 2) { echo $styleClass; }?>>
					<li><a href="<?php echo BASE_URL;?>customers.php?mi=2"><i class="fa fa-user text-green"></i> Customers List</a></li>
					<li><a href="<?php echo BASE_URL;?>invoice_non.php?mi=2"><i class="fa fa-circle-o text-green"></i> Un-Registered</a></li>
					<li><a href="<?php echo BASE_URL;?>customers_add.php?mi=2"><i class="fa  fa-user-plus text-green"></i> Add Customer</a></li>				
				</ul>
			</li>
			
			<!--Navi-->
 			<li class="treeview <?php  if($menuitem ==5) { echo $activeClass; } ?>">
				<a href="#">
				<i class="fa fa-clone text-green "></i> <span>Sale Invoice</span>
				<span class="pull-right-container">
				<i class="fa fa-angle-left pull-right"></i>
				</span>
				</a>
				<ul class="treeview-menu"  <?php  if($menuitem == 5) { echo $styleClass; }?>>
					<li><a href="<?php echo BASE_URL;?>invoice_add.php?mi=5"><i class="fa  fa-pencil-square-o text-green"></i>Add Sale Invoice</a></li>
					<li><a href="<?php echo BASE_URL;?>invoice.php?mi=5"><i class="fa fa-tasks text-green"></i> List Sales Invoices</a></li>
			
					
				</ul>
			</li>

			<!--Navi-->
		<li class="treeview <?php  if($menuitem == 6) { echo $activeClass; } ?>">
				<a href="#">
				<i class="fa  fa-tags text-aqua"></i> <span>Assets</span>
				<span class="pull-right-container">
				<i class="fa fa-angle-left pull-right"></i>
				</span>
				</a>
				<ul class="treeview-menu"  <?php  if($menuitem == 6) { echo $styleClass; }?>>
					<li><a href="<?php echo BASE_URL;?>assets.php?mi=6"><i class="fa  fa-signal text-aqua"></i> List Assets</a></li>
					<li><a href="<?php echo BASE_URL;?>assetscategory.php?mi=6"><i class="fa fa-sitemap text-aqua"></i> Assets Categories</a></li>	
				</ul>
		</li>
			<!--Navi-->
					<li class="treeview <?php  if($menuitem == 7) { echo $activeClass; } ?>">
				<a href="#">
				<i class="fa  fa-binoculars text-yellow"></i> <span>Expenses</span>
				<span class="pull-right-container">
				<i class="fa fa-angle-left pull-right"></i>
				</span>
				</a>
				<ul class="treeview-menu"  <?php  if($menuitem == 7) { echo $styleClass; }?>>
					<li><a href="<?php echo BASE_URL;?>expenses_add.php?mi=7"><i class="fa   fa-futbol-o text-yellow"></i> Add Expenses</a></li>
					<li><a href="<?php echo BASE_URL;?>expenses.php?mi=7"><i class="fa  fa-hourglass-half text-yellow"></i> List Expenses</a></li>
					<li><a href="<?php echo BASE_URL;?>expensescategory.php?mi=7"><i class="fa fa-circle-o text-yellow"></i> Expense Categories</a></li>	
				</ul>
		</li>
			<!--Navi-->

			<li class="treeview <?php  if($menuitem == 8) { echo $activeClass; } ?>">
				<a href="#">
				<i class="fa  fa-money text-yellow"></i> <span>Accounts</span>
				<span class="pull-right-container">
				<i class="fa fa-angle-left pull-right"></i>
				</span>
				</a>
	<ul class="treeview-menu"  <?php  if($menuitem == 8) { echo $styleClass; }?>>
		<li><a href="<?php echo BASE_URL;?>receipts.php?mi=8"><i class="fa  fa-rupee (alias) text-green"></i>Sale Receipts</a></li>
		<li><a href="<?php echo BASE_URL;?>receipts.php?receipt=Purchase&mi=8"><i class="fa  fa-rouble (alias) text-yellow"></i> Purchase Receipts</a></li>
		<li><a href="<?php echo BASE_URL;?>payexpenses.php?mi=8"><i class="fa  fa-upload text-yellow"></i> Payable Expenses</a></li>
		<li><a href="<?php echo BASE_URL;?>balancesheet.php?mi=8"><i class="fa  fa-folder-open text-aqua"></i> Balance-Sheet</a></li>
		<li><a href="<?php echo BASE_URL;?>statement.php?mi=8"><i class="fa fa-list-alt text-green"></i> A/C Statement</a></li>
    </ul>
			</li>
		
			<li class="treeview <?php  if($menuitem == 10) { echo $activeClass; } ?>">
				<a href="#">
				<i class="fa fa-cogs"></i> <span>Program Settings</span>
				<span class="pull-right-container">
				<i class="fa fa-angle-left pull-right"></i>
				</span>
				</a>
	<ul class="treeview-menu"  <?php  if($menuitem == 10) { echo $styleClass; }?>>
		<li><a href="<?php echo BASE_URL;?>companies.php?mi=10"><i class="fa fa-circle-o"></i> Manage Companies</a></li>
        <li><a href="<?php echo BASE_URL;?>backup.php?mi=10"><i class="fa  fa-database"></i> Backup</a></li>
		<li><a href="<?php echo BASE_URL;?>taxes.php?mi=10"><i class="fa fa-circle-o"></i> Taxes</a></li>
		<li><a style="cursor: pointer;"
  onclick="window.open('http://eightangle.com/help_desk/','',' scrollbars=yes,width=1000, resizable=yes,directories=0,titlebar=0,toolbar=0,location=0,status=0,menubar=0').focus()"><i class="fa fa-circle-o"></i> Help Desk</a></li>		
    </ul>
			</li>
			<!--Navi-->
		</ul>
</section>
	<!-- /.sidebar -->
</aside>
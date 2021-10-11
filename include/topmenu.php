<?php
$url = $_SERVER['REQUEST_URI'];
?>
<style>
    @media all and (min-width: 992px) {
        .navbar .nav-item .dropdown-menu{ display: none; }
        .navbar .nav-item:hover .nav-link{   }
        .navbar .nav-item:hover .dropdown-menu{ display: block; }
        .navbar .nav-item .dropdown-menu{ margin-top:0; }
    }
</style>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary topnavbar">
 <div class="container-fluid">
  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#main_nav"  aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="main_nav">
	<ul class="navbar-nav" style="width: 80%;">
		<li class="nav-item <?php if (strpos($url, "account")) { ?>active<?php } ?>"> <a class="nav-link" href="account.php"><?php echo TXT_ACCUEIL; ?> </a> </li>
		<li class="nav-item dropdown <?php if (strpos($url, "kanban")) { ?>active<?php } ?>">
		   <a class="nav-link  dropdown-toggle" href="#" data-bs-toggle="dropdown">  <?php echo TXT_ORDER_BOOK; ?>  </a>
		    <ul class="dropdown-menu">
			  <li class="submenuitem"><a class="dropdown-item" href="#"> <?php echo TXT_ORDERS; ?></a></li>
			  <li class="submenuitem"><a class="dropdown-item" href="#"> <?php echo TXT_APPRO_PLAN; ?> </a></li>
			  <li class="submenuitem <?php if (strpos($url, "kanban")) { ?>active<?php } ?>"><a class="dropdown-item" href="kanban.php"> <?php echo TXT_KANBAN_CARD; ?> </a></li>
		    </ul>
		</li>
		<li class="nav-item dropdown">
		   <a class="nav-link  dropdown-toggle" href="#" data-bs-toggle="dropdown">  <?php echo TXT_ORDER_CONFIRMATION; ?>  </a>
		    <ul class="dropdown-menu">
			  <li class="submenuitem"><a class="dropdown-item" href="#"> <?php echo TXT_ORDERS_AND_APPRO_PLAN; ?></a></li>
			  <li class="submenuitem"><a class="dropdown-item" href="kanban.php"> <?php echo TXT_LATE_KANBAN; ?> </a></li>
		    </ul>
		</li>
		<li class="nav-item"> <a class="nav-link" href="#"><?php echo TXT_REMINDER; ?> </a> </li>
		<li class="nav-item dropdown">
		   <a class="nav-link  dropdown-toggle" href="#" data-bs-toggle="dropdown">  <?php echo TXT_PURCHASE_CONDITIONS; ?>  </a>
		    <ul class="dropdown-menu">
			  <li class="submenuitem"><a class="dropdown-item" href="#"> <?php echo TXT_ORIGIN_CERTIFICATE; ?></a></li>
			  <li class="submenuitem"><a class="dropdown-item" href="#"> <?php echo TXT_ROSH_REACH; ?> </a></li>
			  <li class="submenuitem"><a class="dropdown-item" href="#"> <?php echo TXT_BL; ?> </a></li>
		    </ul>
		</li>
		<li class="nav-item dropdown <?php if (strpos($url, "rating") || strpos($url, "otif")) { ?>active<?php } ?>">
		   <a class="nav-link  dropdown-toggle" href="#" data-bs-toggle="dropdown">  <?php echo TXT_DOCUMENTS; ?>  </a>
		    <ul class="dropdown-menu">
			  <li class="submenuitem <?php if (strpos($url, "otif")) { ?>active<?php } ?>"><a class="dropdown-item" href="otif.php"> <?php echo TXT_OTIF; ?></a></li>
			  <li class="submenuitem <?php if (strpos($url, "rating")) { ?>active<?php } ?>"><a class="dropdown-item" href="rating.php"> <?php echo TXT_VENDOR_RATING; ?> </a></li>
		    </ul>
		</li>
		<li class="nav-item"> <a class="nav-link" href="#"><?php echo TXT_SUPPLIER_PERFORMANCE; ?> </a> </li>
		<li class="nav-item dropdown <?php if (strpos($url, "conges")) { ?>active<?php } ?>">
		   <a class="nav-link  dropdown-toggle" href="#" data-bs-toggle="dropdown">  <?php echo TXT_MY_ACCOUNT; ?>  </a>
		    <ul class="dropdown-menu">
			  <li class="submenuitem <?php if (strpos($url, "conges")) { ?>active<?php } ?>"><a class="dropdown-item" href="conges.php"> <?php echo TXT_VACATION_PERIODS; ?></a></li>
			  <li class="submenuitem"><a class="dropdown-item" href="#"> <?php echo TXT_UPDATE_EMAIL; ?> </a></li>
			  <li class="submenuitem"><a class="dropdown-item" href="changemdp.php"> <?php echo TXT_CHANGE_PASSWORD; ?> </a></li>
			  <li class="submenuitem"><a class="dropdown-item" href="../signout.php"> <?php echo TXT_LOGOUT; ?> </a></li>
		    </ul>
		</li>
	</ul>

    <ul class="navbar-nav" style="width: 20%;">
		<li style="width: 100%; text-align: right;" > <?php echo TXT_UTILISATEUR; echo $_SESSION['user']; ?> </li>
    </ul>
  </div> <!-- navbar-collapse.// -->
 </div> <!-- container-fluid.// -->
</nav>
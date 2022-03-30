<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
	<meta charset="UTF-8">
	<title>Admin Dashboard</title>
	<!--	<link rel="stylesheet" href="../public/admineshop/reset.css">-->
	<link rel="stylesheet" href="../../../public/admineshop/main.css">
	<link rel="stylesheet" href="../../../public/admineshop/form.css">
	<link rel="stylesheet" href="../../../public/admineshop/table.css">
	<link rel="stylesheet" href="../../../public/admineshop/admin.css">
	<link rel="stylesheet" href="../../../public/admineshop/editOrder.css">
	<link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
	<link href="https://cdn-icons-png.flaticon.com/512/2206/2206368.png" rel="icon">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<div class="sidebar">
	<div class="logo-details">
		<i class='bx'></i>
		<span class="logo_name">Adminka</span>
	</div>
	<ul class="nav-links">
		<li>
			<a href="http://eshop/admin" <?=""// $currentMenuItem === 'Main' ? 'class="active"' : "" ?> >
				<i class='bx bx-user' ></i>
				<span class="links_name">Main</span>
			</a>
		</li>
		<li>
			<a href="http://eshop/admin/main/itemlist" <?=""// $currentMenuItem === 'Item list' ? 'class="active"' : "" ?> >
				<i class='bx bx-list-ul' ></i>
				<span class="links_name">Item list</span>
			</a>
		</li>
		<li>
			<a href="http://eshop/admin/main/orderlist" <?=""// $currentMenuItem === 'Order list' ? 'class="active"' : "" ?> >
				<i class='bx bx-list-ul' ></i>
				<span class="links_name">Order list</span>
			</a>
		</li>
		<li>
			<a href="http://eshop/admin/main/form" <?= ""//$currentMenuItem === 'Form' ? 'class="active"' : "" ?> >
				<i class='bx bx-grid-alt' ></i>
				<span class="links_name">Form</span>
			</a>
		</li>
		<li class="log_out">
			<a href="#">
                <form class="bx bx-log-out" method="post">
                    <button name="logOut">Log out</button>
                </form>
			</a>
		</li>
	</ul>
</div>
<section class="home-section">
	<nav>
		<div class="sidebar-button">
			<i class='bx bx-menu sidebarBtn'></i>
			<span class="dashboard"><?= $currentMenuItem ?></span>
		</div>
		<span class="admin_name"><?= $username ?></span>
	</nav>

	<div class="home-content">
		<?= $content ?>
	</div>
</section>

<script>
	let sidebar = document.querySelector(".sidebar");
	let sidebarBtn = document.querySelector(".sidebarBtn");
	sidebarBtn.onclick = function() {
		sidebar.classList.toggle("active");
		if(sidebar.classList.contains("active")){
			sidebarBtn.classList.replace("bx-menu" ,"bx-menu-alt-right");
		}else
			sidebarBtn.classList.replace("bx-menu-alt-right", "bx-menu");
	}
</script>

</body>
</html>

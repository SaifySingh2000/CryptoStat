<nav class="navbar">
    <h1 class="page_title">CryptoStat</h1>
    <ul class="nav_menu">
        <li>
        <a class="active" href="admin_index.php">Home</a>
        </li>
        <li>
        <a href="user.php" class="nav-links">User</a>
        </li>
		<li>
        <a href="../cryptocurrency.php" class="nav-links">Cryptocurrency</a>
        </li>
        <li>
        <a href="latest_news.php" class="nav-links">Latest News</a>
        </li>
        <li>
        <a href="about.php" class="nav-links">About</a>
        </li>
        <li>
        <a href="support.php" class="nav-links">Support</a>
        </li>
    </ul>
    <div class="content">
		<!-- notification message -->
		<?php if (isset($_SESSION['success'])) : ?>
			<div class="error success" >
				<h3>
					<?php 
						echo $_SESSION['success']; 
						unset($_SESSION['success']);
					?>
				</h3>
			</div>
		<?php endif ?>

		<!-- logged in user information -->
		<div class="profile_info">
			<img src="../images/admin_profile.png"  >

			<div>
				<?php  if (isset($_SESSION['user'])) : ?>
					<strong><?php echo $_SESSION['user']['username']; ?></strong>

					<small>
						<i  style="color: #888;">(<?php echo ucfirst($_SESSION['user']['user_type']); ?>)</i> 
						<br>
						<a href="admin_index.php?logout='1'" style="color: red;">logout</a>
                       &nbsp; <a href="create_user.php"> add user</a>
					</small>
				<?php endif ?>
			</div>
		</div>
	</div>
</nav>
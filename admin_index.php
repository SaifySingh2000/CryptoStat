<?php
/**
Saify Singh
**/
include('../connect.php');
include('../functions.php');

if (!isAdmin()) {
	$_SESSION['msg'] = "You must log in first";
	header('location: ../login.php');
}

if (isset($_GET['logout'])) {
	session_destroy();
	unset($_SESSION['user']);
	header("location: ../login.php");
}

if (isset($_POST['submit']) && $_POST['submit'] == 'add' && !empty($_POST['cryptocurrency']) && !empty($_POST['symbol']) && !empty($_POST['supply'])) {
    $cryptocurrency = filter_input(INPUT_POST, 'cryptocurrency', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$rank = filter_input(INPUT_POST, 'rank', FILTER_SANITIZE_NUMBER_INT);
	$symbol = filter_input(INPUT_POST, 'symbol', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$supply = filter_input(INPUT_POST, 'supply', FILTER_SANITIZE_NUMBER_INT);
	$maximum_supply = filter_input(INPUT_POST, 'maximum_supply', FILTER_SANITIZE_NUMBER_INT);
	$website = filter_input(INPUT_POST, 'website', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

	if(isset($_FILES['image'])){
		$file_name = $_FILES['image']['name'];
		$file_size = $_FILES['image']['size'];
		$file_tmp = $_FILES['image']['tmp_name'];
		$file_type = $_FILES['image']['type'];
		$file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
		$extensions = array("jpeg", "jpg", "png", "");

		if(in_array($file_ext, $extensions) === true){
			move_uploaded_file($file_tmp, "../uploads/".$file_name);
		}
	}

	if(in_array($file_ext, $extensions) === false){
		$error = "File extension is not allowed";
	}
	else{

		//set timezone
		date_default_timezone_set('US/Central');
		$date = date("F j, Y, g:i a");

		// Build and prepare SQL String with :title and :content placeholder parameter.
		$query = "INSERT INTO crypto_currency (cryptocurrency,rank,symbol,supply,maximum_supply,website,image,date) 
				VALUES (:cryptocurrency, :rank, :symbol, :supply, :maximum_supply, :website, :image, :date)";
		$statement = $database->prepare($query);

		// Bind the :title and :content parameter in the query to the sanitized.
		$statement->bindValue(':cryptocurrency', $cryptocurrency);
		$statement->bindValue(':rank', $rank);
		$statement->bindValue(':symbol', $symbol);
		$statement->bindValue(':supply', $supply);
		$statement->bindValue(':maximum_supply', $maximum_supply);
		$statement->bindValue(':website', $website);
		$statement->bindValue(':image', $file_name);
		$statement->bindValue(':date', $date);

		// Execute the SQL statement 
		$statement->execute();

		// Redirect after the submitting the blog.
		header("Location: admin_index.php");
		exit;
	}
}

	$select_query = "SELECT * FROM crypto_currency ORDER BY id DESC;";

	$fetch_statement = $database->prepare($select_query);

	$fetch_statement->execute();

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Home</title>
	<link rel="stylesheet" type="text/css" href="../style.css">
	<link rel="stylesheet" type="text/css" href="admin_header.css">
	<style>
	.header {
		background: #003366;
	}
	button[name=register_btn] {
		background: #003366;
	}
	</style>
</head>
<body>
	
	<header>
		<?php include('admin_index_header.php') ?>
	</header>
	<section>
		<main>
	<div id="searchbox">
		<?php if(isset($error)): ?>
			<p style="color:red"><?= $error ?></p>
		<?php endif ?>
			<form method="POST" enctype="multipart/form-data" action="">
				<h2>Add new currency</h2>
				<table>
					<thead>
						<tr>
							<td>Crytpocurrency</td>
							<td>Rank</td>
							<td>Symbol</td>
							<td>Supply</td>
							<td>Maximum Supply</td>
							<td>Website</td>
							<td>Image</td>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><input type="text" name="cryptocurrency" /></td>
							<td><input type="text" name="rank" /></td>
							<td><input type="text" name="symbol" /></td>
							<td><input type="number" name="supply" /></td>
							<td><input type="number" name="maximum_supply" /></td>
							<td><input type="text" name="website" /></td>
							<td><input type="file" name="image" /></td>
						</tr>
					</tbody>
				</table>

				<input type="submit" name="submit" value="add" />
				<input type="reset" name="submit" value="Clear" />
			</form>
		</div>
		<div class="limiter">
			<div class="container-table100">
				<div class="wrap-table100">
					<div class="table100">
						<table class="responsive-table">
							<thead>
								<tr class="table100-head">
									<th class="column1">Crytpocurrency</th>
									<th></th>
									<th class="column2">Rank</th>
									<th class="column3">Symbol</th>
									<th class="column4">Supply</th>
									<th class="column5">Maximum Supply</th>
									<th class="column6">Website</th>
									<th class="column7">Image</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								<?php while($row = $fetch_statement->fetch()) : ?>
									<tr class="table-row">
										<td class="column1"><?= $row['cryptocurrency'] ?><td>
										<td class="column2"><?= $row['rank'] ?></td>
										<td class="column3"><?= $row['symbol'] ?></td>
										<td class="column4"><?= $row['supply'] ?></td>
										<td class="column5"><?= $row['maximum_supply'] ?></td>
										<td class="column6"><a href="<?= $row['website'] ?>"><?= $row['website'] ?></a></td>
										<?php if(empty($row['image']) === false): ?>
											<td>
												<img src="../uploads/<?=$row['image']?>" alt = "<?=$row['image']?>" width="50" height="50" >
											</td>
										<?php else: ?>
											<td>No image</td>
										<?php endif ?>
										<td class="column7"><a href="edit_currency.php?id=<?= $row['id'] ?>">edit</a></td>
										<td class="column8"><a href="delete_currency.php?id=<?= $row['id'] ?>" onclick="return confirm('Are you sure you wish to delete this record?')">delete</a></td>
									</tr>
								<?php endwhile ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		</main>
		<aside>
			<h2>Latest News</h2>
		</aside>
		</section>
	<footer>
			<small>Copyright @<?= date('Y') ?> - Saify Inc. - All rights reserved</small>
	</footer>
	
</body>
</html>

<?php
	include('connect.php'); 
	include('functions.php');
	
    if (!isLoggedIn()) {
        $_SESSION['msg'] = "You must log in first";
        header('location: login.php');
    }

	$select_query = "SELECT * FROM crypto_currency ORDER BY date DESC LIMIT 10;";

	$fetch_statement = $database->prepare($select_query);

	$fetch_statement->execute();
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Home</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<link rel="stylesheet" type="text/css" href="user_header.css">
</head>
<body>
	<header>
		<?php include('user_header.php') ?>
	</header>
	<section>
		<main>
	<div>
		<div>
			<h2>Latest News</h2>
			<p></P>
		</div>
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
			<h2>Comments</h2>
		</aside>
		</section>
		<footer>
				<small>Copyright @<?= date('Y') ?> - Saify Inc.</small>
		</footer>
</body>
</html>
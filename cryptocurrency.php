<?php
	include('connect.php'); 
	include('functions.php');

	define("ROW_PER_PAGE",2);
	
    if (!isLoggedIn()) {
        $_SESSION['msg'] = "You must log in first";
        header('location: login.php');
    }

	// Search cryptocurrency functionality
	$search_keyword = '';
	if(!empty($_POST['search']['keyword'])) {
		$search_keyword = $_POST['search']['keyword'];
	}
	$search_query = 'SELECT * FROM crypto_currency WHERE cryptocurrency LIKE :keyword OR rank LIKE :keyword OR symbol LIKE :keyword ORDER BY id DESC ';

	// Pagination
	$per_page_html = '';
	$page = 1;
	$start=0;
	if(!empty($_POST["page"])) {
		$page = $_POST["page"];
		$start=($page-1) * ROW_PER_PAGE;
	}
	$limit=" limit " . $start . "," . ROW_PER_PAGE;
	$pagination_statement = $database->prepare($search_query);
	$pagination_statement->bindValue(':keyword', '%' . $search_keyword . '%', PDO::PARAM_STR);
	$pagination_statement->execute();

	$row_count = $pagination_statement->rowCount();
	if(!empty($row_count)){
		$per_page_html .= "<div style='text-align:center;margin:20px 0px;'>";
		$page_count=ceil($row_count/ROW_PER_PAGE);
		if($page_count>1) {
			for($i=1;$i<=$page_count;$i++){
				if($i==$page){
					$per_page_html .= '<input type="submit" name="page" value="' . $i . '" class="btn-page current" />';
				} else {
					$per_page_html .= '<input type="submit" name="page" value="' . $i . '" class="btn-page" />';
				}
			}
		}
		$per_page_html .= "</div>";
	}

	$query = $search_query.$limit;

	$fetch_statement = $database->prepare($query);

	$fetch_statement->bindValue(':keyword', '%' . $search_keyword . '%', PDO::PARAM_STR);

	$fetch_statement->execute();

    $row = $fetch_statement->fetchAll();

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Home</title>
	
	<link rel="stylesheet" type="text/css" href="user_header.css">
	<style>
		/* general styling */
		body {
		font-family: "Open Sans", sans-serif;
		line-height: 1.25;
		}

		table {
		border: 1px solid #ccc;
		border-collapse: collapse;
		margin: 10px;
		padding: 0;
		width: 100%;
		table-layout: fixed;
		}

		table caption {
		font-size: 1.5em;
		margin: .5em 0 .75em;
		}

		table tr {
		background-color: #f8f8f8;
		border: 1px solid #ddd;
		padding: .35em;
		}

		table th,
		table td {
		padding: .625em;
		text-align: center;
		word-wrap: break-word;
		}

		table th {
		font-size: .85em;
		letter-spacing: .1em;
		text-transform: uppercase;
		}

		footer{
			font-size: 20px;
			text-align: center;
			color: #b6b7bf;
		}

		@media screen and (max-width: 600px) {
			table {
				border: 0;
			}

			table caption {
				font-size: 1.3em;
			}
			
			table thead {
				border: none;
				clip: rect(0 0 0 0);
				height: 1px;
				margin: -1px;
				overflow: hidden;
				padding: 0;
				position: absolute;
				width: 1px;
			}
			
			table tr {
				border-bottom: 3px solid #ddd;
				display: block;
				margin-bottom: .625em;
			}
			
			table td {
				border-bottom: 1px solid #ddd;
				display: block;
				font-size: .8em;
				text-align: right;
			}
			
			table td::before {
				/*
				* aria-label has no advantage, it won't be read inside a table
				content: attr(aria-label);
				*/
				content: attr(data-label);
				float: left;
				font-weight: bold;
				text-transform: uppercase;
			}
			
			table td:last-child {
				border-bottom: 0;
			}
		}
	</style>
</head>
<body>
	<header>
		<?php include('user_header.php') ?>
	</header>
    <form action="" method="POST">
		<div>
			<label>Search the cryptocurrency</label>
        <input id="searchBox" type="text" name='search[keyword]' value="<?php echo $search_keyword; ?>" id='keyword' maxlength='25' placeholder="Search Here..." >

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
								<?php foreach($row as $data) : ?>
									<tr class="table-row">
										<td class="column1"><?= $data['cryptocurrency'] ?><td>
										<td class="column2"><?= $data['rank'] ?></td>
										<td class="column3" style="text-tranform: uppercase;"><?= $data['symbol'] ?></td>
										<td class="column4"><?= $data['supply'] ?></td>
										<td class="column5"><?= $data['maximum_supply'] ?></td>
										<td class="column6"><a href="<?= $data['website'] ?>"><?= $data['website'] ?></a></td>
									</tr>
								<?php endforeach ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<?php echo $per_page_html; ?>
		</form>
	<footer>
			<small>Copyright @<?= date('Y') ?> - Saify Inc. - All rights reserved</small>
	</footer>
</body>
</html>

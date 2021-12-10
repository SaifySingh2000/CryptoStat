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

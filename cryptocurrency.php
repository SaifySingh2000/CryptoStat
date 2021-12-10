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

?>

<?php
include('../functions.php');

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

$query = mysqli_query($db,"SELECT * FROM crypto_currency WHERE id = '$id'");

if(isset($_POST['update'])) // when click on Update button
{
    $cryptocurrency = $_POST['cryptocurrency'];
	$rank = $_POST['rank'];
	$symbol = $_POST['symbol'];
	$supply = $_POST['supply'];
	$maximum_supply = $_POST['maximum_supply'];
	$website = $_POST['website'];
        
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
	
    $edit = mysqli_query($db,"UPDATE crypto_currency 
                SET cryptocurrency='$cryptocurrency', rank='$rank', symbol='$symbol', supply='$supply', maximum_supply='$maximum_supply', website='$website', image='$file_name'
                WHERE id='$id' LIMIT 1");

    header("Location: admin_index.php");
    exit;
}

$row = mysqli_fetch_array($query); // fetch data
	
?>

<!DOCTYPE html>
<html>

<head>
	<title>Home</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="../style.css">
</head>

<body>
    <form method="POST" enctype="multipart/form-data">
        <label for="cryptocurrency">Cryptocurrency:</label>
        <input type="text" id="cryptocurrency" name="cryptocurrency" value="<?= $row['cryptocurrency'] ?>">
        <br />
        <label for="rank">Rank:</label>
        <input type="number" id="rank" name="rank" value="<?= $row['rank'] ?>">
        <br>
        <label for="symbol">Symbol:</label>
        <input type="text" id="symbol" name="symbol" value="<?= $row['symbol'] ?>">
        <br>
        <label for="supply">Supply:</label>
        <input type="number" id="supply" name="supply" value="<?= $row['supply'] ?>">
        <br>
        <label for="maximum_supply">Maximum Supply:</label>
        <input type="number" id="maximum_supply" name="maximum_supply" value="<?= $row['maximum_supply'] ?>">
        <br>
        <label for="supply">Website:</label>
        <input type="text" id="website" name="website" value="<?= $row['website'] ?>">
        <br>
        <label for="supply">Image:</label>
        <input type="file" id="website" name="image">
        <br /><br />
        <img src="../uploads/<?= $row['image'] ?>" alt="<?= $row['image'] ?>" height="150px" />
        <br>

        <input type="submit" name="update" value="Update">
    </form>
</body>
</html
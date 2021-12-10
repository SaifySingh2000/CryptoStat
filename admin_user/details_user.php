<?php

    require('../connect.php');

    // Check if there is any id or not through the GET parameter, if there is perform the following delete query.
    if ($_GET && isset($_GET['id'])) {
        
        // Gets a id external variable and filters it.
        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        // Build and prepare SQL String with :id parameter.
        $select_query = "SELECT * FROM users WHERE id=:id LIMIT 1";
        
        // Prepare the Database Object with the query
        $fetch_statement = $database->prepare($select_query);

        // Bind the values to the placeholders
        $fetch_statement->bindValue(':id', $id, PDO::PARAM_INT); // Explicit data type for the parameter using the PDO::PARAM_INT, can cast if necessary

        // Execute the SQL statement.
        $fetch_statement->execute();

        $row = $fetch_statement->fetch();
    }
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Home</title>
	
	<link rel="stylesheet" type="text/css" href="user_header.css">
  <style>
    table, th, td{
      border: 1px solid;
    }
  </style>
</head>
<body>
    <div>
      <table>
            <caption>Edit</caption>
            <tr>
                <th>Username</th>
                <td><?= $row['username']?></td>
            <tr>
            <tr>
                <th>Email</th>
                <td><?= $row['email'] ?></td>
            </tr>
            <tr>
                <th>User Type</th>
                <td><?= $row['user_type'] ?></td>
            </tr>
            <tr>
                <th>Password</th>
                <td><?= $row['password'] ?></td>
            </tr>
      </table>
      <button><a href="edit_user.php?id=<?= $row['id'] ?>">Edit</a></button>
      <button onClick="return confirm('Are you sure you wish to delete this record?')"><a href="delete_user.php?id=<?= $row['id'] ?>">Delete</a></button>
  </div>
</body>
</html>
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
	<title>Edit User</title>
</head>
<body>
    <div>
        <form method="POST">
            <caption>Edit</caption>
            <div>
                <label>Username:</label>
                <input id="username" name="username" type="text" value="<?= $row['username'] ?>" />
            </div>
            <br>
            <div>
                <label>Email:</label>
                <input id="email" name="email" type="text" value="<?= $row['email'] ?>" />
            </div>
            <br>
            <div>
                <label>User Type:</label>
                <input id="user_type" name="user_type" type="text" value="<?= $row['user_type'] ?>" />
            </div>
            <br>
            <div>
                <label>Password:</label>
                <input id="password" name="password" type="text" value="<?= $row['password'] ?>" />
            </div>
            <br>
            <button><a href="update_user.php?id=<?= $row['id'] ?>">Update</a></button>
            <button onClick="return confirm('Are you sure you wish to delete this record?')"><a href="delete_user.php?id=<?= $row['id'] ?>">Delete</a></button>
        </form>
  </div>
</body>
</html>
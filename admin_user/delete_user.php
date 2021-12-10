<?php

    require('../connect.php');

    // Check if there is any id or not through the GET parameter, if there is perform the following delete query.
    if ($_GET && isset($_GET['id'])) {
        
        // Gets a id external variable and filters it.
        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        // Build and prepare SQL String with :title and :content placeholder parameter.
        $delete_query = "DELETE FROM users WHERE id=:id LIMIT 1";
        
        // Prepare the Database Object with the query
        $statement = $database->prepare($delete_query);

        // Bind the values to the placeholders
        $statement->bindValue(':id', $id, PDO::PARAM_INT); // Explicit data type for the parameter using the PDO::PARAM_INT, can cast if necessary

        // Execute the SQL statement.
        $statement->execute();

        // Redirect after the deletion of the currency record.
        header("Location: user.php");
        exit;
    } 
?>
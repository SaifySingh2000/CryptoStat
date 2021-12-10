<?php
    require('..\connect.php');

    $search =$_POST['search'];

    $select_query = "SELECT * 
                    FROM users 
                    WHERE username LIKE '%$search%' OR email LIKE '%$search%' OR user_type LIKE '%$search%' ";

    $fetch_statement = $database->prepare($select_query);

    $fetch_statement->execute();

    $HTTP_RAW_POST_DATA
    if(isset($data['0']){
        $html='
        <table>
        <thead>
          <tr>
            <th>Username</th>
            <th>Email</th>
            <th>User Type</th>
            <th>Password</th>
            <th></th>
            <th></th>
            <th></th>
          </tr>
        </thead>';
        foreach($data as $list){
            $html.='<tr>
            <td>'.$list['username'].'</td>
            <td>'.$list['email'].'</td>
            <td>'.$list['user_type'].'</td>
            <td>'.$list['password'].'</td>
            <td><a href="edit_user.php?id='.$list['id'].'">Edit</a></td>
            <td><a href="details_user.php?id='.$list['id'].'">Details</a></td>
            <td><a href="delete_user.php?id='.$list['id'].'" onClick="return confirm('Are you sure you wish to delete this record?')">Delete</a></td>'
        }
        $html.='</table>';
        echo $html;

    }else{
        echo "No data found";
    })
?>
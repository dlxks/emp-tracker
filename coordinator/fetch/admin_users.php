<?php
require_once('../../config.php');

$admin_search = $_POST['admin_search'];

if (isset($admin_search)) {
    $sql = "SELECT * FROM users as us 
    INNER JOIN branches as br 
    ON us.branch_id = br.id 
    WHERE us.employee_id LIKE '%$admin_search%'
    OR us.first_name LIKE'%$admin_search%'
    OR us.last_name LIKE'%$admin_search%'
    OR us.email LIKE'%$admin_search%'
    OR us.status LIKE'%$admin_search%'
    OR br.branch_name LIKE'%$admin_search%'
    HAVING us.role = 'admin' 
    ";

    $query = mysqli_query($conn, $sql);
    $data = '';

    if ($count = mysqli_num_rows($query) == 0) {
        echo '<tr>
            <td colspan="6" class="text-center">
                <span class="fw-bold text-danger">No Records</span>
            </td>
        </tr>';
    } else {
        
        while ($row = mysqli_fetch_assoc($query)) {
            $data .= '
      <tr>
       <td>' . $row["branch_name"] . '</td>
       <td>' . $row["employee_id"] . '</td> 
       <td>' . $row["first_name"] . ' ' . $row["last_name"] . '</td>
       <td>' . $row["email"] . '</td>
       <td>' . $row["status"] . '</td>
       <td>
        <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#editAdmin' .  $row["id"] . '"><span class="fa fa-pen-to-square"></span> View</button>
        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#removeAdmin' .  $row["id"] . '"><span class="fa fa-trash"></span> Remove</button>
       </td>
      </tr>
     ';
        }
        echo $data;
    }
}

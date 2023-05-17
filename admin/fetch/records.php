<?php
require_once('../../config.php');

$record_search = $_POST['record_search'];

if (isset($record_search)) {
    $sql = "SELECT rec.*, br.id as branch_id, br.branch_name
    FROM records as rec 
    INNER JOIN branches as br 
    ON rec.branch_id = br.id  
    WHERE year LIKE '%$record_search%'
    OR total_graduates LIKE '%$record_search%'
    OR br.branch_name LIKE '%$record_search%'
    ";

    $query = mysqli_query($conn, $sql);
    $data = '';

    if ($count = mysqli_num_rows($query) == 0) {
        echo '<tr>
            <td colspan="6" class="text-center">
                <span class="fw-bold text-danger">No Recordss</span>
            </td>
        </tr>';
    } else {

        while ($row = mysqli_fetch_assoc($query)) {
            $data .= '
      <tr>
       <td>' . $row["branch_name"] . '</td>
       <td>' . $row["year"] . '</td> 
       <td>' . $row["total_graduates"] . '</td>
       <td>' . $row["total_employed"] . '</td>
       <td>' . $row["total_percentage"] . '</td>
       <td>
        <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#editRecord' .  $row["id"] . '"><span class="fa fa-pen-to-square"></span> View</button>
        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#removeRecord' .  $row["id"] . '"><span class="fa fa-trash"></span> Remove</button>
       </td>
      </tr>
     ';
        }
        echo $data;
    }
}

<?php
require_once('../../config.php');

$branch_search = $_POST['branch_search'];

if (isset($branch_search)) {
  $sql = "SELECT * FROM branches WHERE branch_name LIKE '%$branch_search%' OR branch_desc LIKE '%$branch_search%'";
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
       <td>' . $row["id"] . '</td>
       <td>' . $row["branch_name"] . '</td>
       <td>' . $row["branch_desc"] . '</td>
       <td>
        <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#editBranch' .  $row["id"] . '"><span class="fa fa-pen-to-square"></span> Edit</button>
        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#removeBranch' .  $row["id"] . '"><span class="fa fa-trash"></span> Remove</button>
       </td>
      </tr>
     ';
    }
    echo $data;
  }
}

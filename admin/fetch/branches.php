<?php
require_once('../../config.php');

$branch_search = $_POST['branch_search'];

if (isset($branch_search)) {
  $sql = "SELECT * FROM branches WHERE branch_name LIKE '%$branch_search%' OR branch_desc LIKE '%$branch_search%'";
  $query = mysqli_query($conn, $sql);
  $data = '';
  while ($row = mysqli_fetch_assoc($query)) {
    $data .= '
      <tr>
       <td>' . $row["id"] . '</td>
       <td>' . $row["branch_name"] . '</td>
       <td>' . $row["branch_desc"] . '</td>
       <td>
           <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#course_edit<?php ?>"><span class="fa fa-pen-to-square"></span> Edit</button>
           <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#course_edit<?php ?>"><span class="fa fa-trash"></span> Delete</button>
       </td>
      </tr>
     ';
  }
  echo $data;
}

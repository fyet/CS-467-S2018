<?php
require_once '../../config.php';
$query = "SELECT id, email FROM user WHERE account_type='admin'";
$response = mysqli_query($dbc, $query);

while($row = mysqli_fetch_assoc($response)){
    echo "<tr id={$row['id']}>
    <td> {$row['email']} </td>
    <td>
      <button type='button'
            class='btn btn-secondary btn-sm active'
            float='right'
            data-toggle='modal'
            data-target='#editAdminModal'
            data-id={$row['id']}
            data-email={$row['email']}>
            <svg xmlns=\"http://www.w3.org/2000/svg\" width=\"14\" height=\"16\" viewBox=\"0 0 14 16\"><path fill-rule=\"evenodd\" d=\"M0 11.592v3h3l8-8-3-3-8 8zm3 2H1v-2h1v1h1v1zm10.3-9.3l-1.3 1.3-3-3 1.3-1.3a.996.996 0 0 1 1.41 0l1.59 1.59c.39.39.39 1.02 0 1.41z\"/></svg>
            <span class='btn-txt'>Edit</span>
      </button>
    </td>
    <td>
      <button type='button'
            class='btn btn-danger btn-sm active'
            float='right'
            data-toggle='modal'
            data-target='#deleteAdminModal'
            data-id={$row['id']}
            data-email={$row['email']}>
            <svg xmlns=\"http://www.w3.org/2000/svg\" width=\"12\" height=\"16\" viewBox=\"0 0 12 16\"><path fill-rule=\"evenodd\" d=\"M7.71 8.23l3.75 3.75-1.48 1.48-3.75-3.75-3.75 3.75L1 11.98l3.75-3.75L1 4.48 2.48 3l3.75 3.75L9.98 3l1.48 1.48-3.75 3.75z\"/></svg>
            <span class='btn-txt'>Delete</span>
      </button>
    </td>
    </tr>";
  }
  mysqli_close($dbc);

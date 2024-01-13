<!-- Add Modal -->
<div class="modal fade" id="addAdmin" tabindex="-1" aria-labelledby="branchModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="branchModalTitle">Add User</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="actions/actions.php" method="POST" id="addForm">
                <div class="modal-body">
                    <!-- Row -->
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-outline">
                                <label class="form-label">Branch/College</label>
                                <select name="branch_id" id="branch_id" class="form-control" required>
                                    <option value="" disabled>Choose branch</option>
                                    <?php
                                    $branches_stmt = "SELECT * FROM branches";
                                    $branches_qry = mysqli_query($conn, $branches_stmt) or die(mysqli_error($conn));

                                    while ($branches_row = mysqli_fetch_assoc($branches_qry)) {
                                    ?>
                                        <option value="<?= $branches_row['id'] ?>" <?php if (isset($_POST['employee_id'])) echo "selected"; ?>><?= $branches_row['branch_name'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-outline">
                                <label class="form-label" for="role">Role</label>
                                <select name="role" id="role" class="form-control" required>
                                    <option value="" disabled>Choose role</option>
                                    <?php
                                    $role_stmt = "SELECT * FROM roles";
                                    $role_qry = mysqli_query($conn, $role_stmt) or die(mysqli_error($conn));

                                    while ($role_row = mysqli_fetch_assoc($role_qry)) {
                                    ?>
                                        <option value="<?= $role_row['role'] ?>" <?php if (isset($_POST['role'])) echo "selected"; ?>><?= $role_row['role'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-outline">
                                <label class="form-label" for="employee_id">Employeed ID</label>
                                <input type="number" id="employee_id" name="employee_id" class="form-control" value="<?php if (isset($_POST['employee_id'])) echo $_POST['employee_id']; ?>" required />
                            </div>
                        </div>
                    </div>
                    <!-- End Row -->

                    <!-- Row -->
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-outline">
                                <label class="form-label" for="firstname">First Name</label>
                                <input type="text" id="firstname" name="firstname" class="form-control form-control" value="<?php if (isset($_POST['firstname'])) echo $_POST['firstname']; ?>" required />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-outline">
                                <label class="form-label" for="middlename">Middle Name</label>
                                <input type="text" id="middlename" name="middlename" class="form-control form-control" value="<?php if (isset($_POST['middlename'])) echo $_POST['middlename']; ?>" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-outline">
                                <label class="form-label" for="lastname">Last Name</label>
                                <input type="text" id="lastname" name="lastname" class="form-control form-control" value="<?php if (isset($_POST['lastname'])) echo $_POST['lastname']; ?>" required />
                            </div>
                        </div>
                    </div>
                    <!-- End Row -->

                    <!-- Row -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-outline">
                                <label class="form-label" for="email">Email</label>
                                <input type="email" id="email" name="email" class="form-control form-control" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>" required />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-outline">
                                <label class="form-label" for="phonenumber">Phone Number</label>
                                <input type="tel" id="phonenumber" name="phonenumber" placeholder="63-912-345-6789" pattern="[6]{1}[3]{1}[0-9]{10}" class=" form-control form-control" value="<?php if (isset($_POST['phonenumber'])) echo $_POST['phonenumber']; ?>" required />
                            </div>
                        </div>
                    </div>
                    <!-- End Row -->

                    <!-- Row -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-outline">
                                <label class="form-label" for="password">Password</label>
                                <input type="password" id="password" name="password" class="form-control form-control" disabled />
                                <span id='add_message'></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-outline">
                                <label class="form-label" for="confirm_password">Confirm Password</label>
                                <input type="password" id="confirm_password" name="confirm_password" class="form-control form-control" disabled />
                            </div>
                        </div>
                    </div>
                    <!-- End Row -->

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <input type="submit" name="add_user" class="btn btn-primary" value="Save">
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editAdmin<?= $id; ?>" tabindex="-1" aria-labelledby="branchModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="branchModalTitle">Update Information</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="actions/actions.php" method="POST">
                <div class="modal-body">
                    <!-- Row -->
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-outline">
                                <input type="hidden" id="e_id" name="e_id" class="form-control form-control" value="<?= $row['id']; ?>" required />

                                <label class="form-label" for="e_branch_id">Branch/College</label>
                                <select name="e_branch_id" id="e_branch_id" class="form-control" required>
                                    <option value="" disabled>Choose branch</option>
                                    <?php
                                    $branches_stmt = "SELECT * FROM branches";
                                    $branches_qry = mysqli_query($conn, $branches_stmt) or die(mysqli_error($conn));

                                    while ($branches_row = mysqli_fetch_assoc($branches_qry)) {
                                    ?>
                                        <option value="<?= $branches_row['id'] ?>" <?php if ($branches_row['id'] == $row['branch_id']) echo "selected"; ?>><?= $branches_row['branch_name'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-outline">
                                <label class="form-label" for="e_role">Role</label>
                                <select name="e_role" id="e_role" class="form-control" required>
                                    <option value="" disabled>Choose role</option>
                                    <?php
                                    $role_stmt = "SELECT * FROM roles";
                                    $role_qry = mysqli_query($conn, $role_stmt) or die(mysqli_error($conn));

                                    while ($role_row = mysqli_fetch_assoc($role_qry)) {
                                    ?>
                                        <option value="<?= $role_row['role'] ?>" <?php if ($role_row['role'] == $row['role']) echo "selected"; ?>><?= $role_row['role'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-outline">
                                <label class="form-label" for="d_employee_id">Employeed ID</label>
                                <input type="number" id="d_employee_id" class="form-control" value="<?= $row['employee_id']; ?>" required disabled />
                                <input type="hidden" id="e_employee_id" name="e_employee_id" class="form-control" value="<?= $row['employee_id']; ?>" required />
                            </div>
                        </div>
                    </div>
                    <!-- End Row -->

                    <!-- Row -->
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-outline">
                                <label class="form-label" for="e_firstname">First Name</label>
                                <input type="text" id="e_firstname" name="e_firstname" class="form-control form-control" value="<?= $row['first_name']; ?>" required />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-outline">
                                <label class="form-label" for="e_middlename">Middle Name</label>
                                <input type="text" id="e_middlename" name="e_middlename" class="form-control form-control" value="<?= $row['middle_name']; ?>" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-outline">
                                <label class="form-label" for="e_lastname">Last Name</label>
                                <input type="text" id="e_lastname" name="e_lastname" class="form-control form-control" value="<?= $row['last_name']; ?>" required />
                            </div>
                        </div>
                    </div>
                    <!-- End Row -->

                    <!-- Row -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-outline">
                                <label class="form-label" for="e_email">Email</label>
                                <input type="email" id="e_email" name="e_email" class="form-control form-control" value="<?= $row['email']; ?>" required />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-outline">
                                <label class="form-label" for="e_phonenumber">Phone Number</label>
                                <input type="tel" id="e_phonenumber" name="e_phonenumber" placeholder="63-912-345-6789" pattern="[6]{1}[3]{1}[0-9]{10}" class=" form-control form-control" value="<?= $row['phone_number']; ?>" required />
                            </div>
                        </div>
                    </div>
                    <!-- End Row -->

                    <!-- Row -->
                    <div class="row">
                        <div class="col">
                            <div class="form-outline">
                                <label class="form-label" for="e_status">Status</label>
                                <select name="e_status" id="e_status" class="form-control" required>
                                    <option value="" disabled>Select</option>
                                    <option value="pending" <?php if ($row['status'] == "pending") echo "selected"; ?>>Pending</option>
                                    <option value="active" <?php if ($row['status'] == "active") echo "selected"; ?>>Active</option>
                                    <option value="denied" <?php if ($row['status'] == "denied") echo "selected"; ?>>Denied</option>
                                </select>
                            </div>
                            <div class="form-outline">
                                <span class="text-secondary fst-italic">New password for password reset is Employee ID + "." + uppercase last name</span>
                            </div>
                        </div>
                    </div>
                    <!-- End Row -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="user_reset_password" class="btn btn-warning" data-bs-dismiss="modal">Reset Password</button>
                        <input type="submit" name="update_user" class="btn btn-primary" value="Update">

                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteAdmin<?= $id; ?>" tabindex="-1" aria-labelledby="branchModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-5" id="branchModalTitle">Delete this record?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="actions/actions.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" id="user_id" name="user_id" value="<?= $row['id']; ?>" required />
                    <input type="hidden" id="user_role" name="user_role" value="<?= $row['role']; ?>" required />
                    <h4 class="text-danger">Are you sure you want to delete <span class="fw-bold"><?= $row['employee_id'] . ': ' . $row['first_name'] . ' ' . $row['last_name'] ?></span>?</h4>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="delete_user" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
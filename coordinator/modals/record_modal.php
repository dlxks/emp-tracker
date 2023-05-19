<!-- Add Modal -->
<div class="modal fade" id="addRecord" tabindex="-1" aria-labelledby="branchModalTitle" aria-hidden="true">
    <div class="modal-dialog modal modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="branchModalTitle">Add User</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="actions/actions.php" method="POST" id="addForm">
                <div class="modal-body">
                    <!-- Row -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-outline">
                                <label class="form-label">Branch/College</label>
                                <select name="branch_id" id="branch_id" class="form-control" required>
                                    <option value="" disabled selected>Choose branch</option>
                                    <?php
                                    $branches_stmt = "SELECT * FROM branches WHERE id = '$user_branch'";
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
                        <div class="col-md-6">
                            <div class="form-outline">
                                <label class="form-label" for="year">Year</label>
                                <input type="text" class="form-control" name="year" id="year" />
                            </div>
                        </div>
                    </div>
                    <!-- End Row -->

                    <!-- Row -->
                    <div class="row">
                        <div class="col">
                            <div class="form-outline">
                                <label class="form-label" for="graduates">Graduates</label>
                                <input type="number" id="graduates" name="graduates" class="form-control form-control" value="<?php if (isset($_POST['graduates'])) echo $_POST['graduates']; ?>" required />
                            </div>
                        </div>
                    </div>
                    <!-- End Row -->

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <input type="submit" name="add_record" class="btn btn-primary" value="Add">
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Delete Modal -->
<div class="modal fade" id="removeRecord<?= $id; ?>" tabindex="-1" aria-labelledby="branchModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-5" id="branchModalTitle">Delete this branch?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="actions/actions.php" method="POST">
                <div class="modal-body">

                    <input type="hidden" id="record_id" name="record_id" value="<?= $row['id']; ?>" required />
                    <h4 class="text-danger">Are you sure you want to delete record for <span class="fw-bold"><?= $row['branch_name'] ?>,</span> year <span class="fw-bold"><?= $row['year'] ?></span>?</h4>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="delete_record" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
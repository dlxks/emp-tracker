<!-- Add Modal -->
<div class="modal fade" id="addBranch" tabindex="-1" aria-labelledby="branchModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="branchModalTitle">Add Branch</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="actions/actions.php" method="POST">
                <div class="modal-body">

                    <div class="input-group mb-3">
                        <label class="input-group-text" id="inputGroup-sizing-sm">Branch/College</label>
                        <input type="text" id="branch_name" name="branch_name" placeholder="ex: CEIT" class="form-control" required />
                    </div>

                    <div class="input-group mb-3">
                        <label class="input-group-text" id="inputGroup-sizing-sm">Description</label>
                        <input type="text" id="branch_desc" name="branch_desc" placeholder="ex: College of Engineering and Information Technology" class="form-control" required />
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="add_branch" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editBranch<?= $id; ?>" tabindex="-1" aria-labelledby="branchModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="branchModalTitle">Edit Branch</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="actions/actions.php" method="POST">
                <div class="modal-body">

                    <div class="input-group mb-3">
                        <label class="input-group-text" id="inputGroup-sizing-sm">Branch/College</label>
                        <input type="hidden" id="branch_id" name="branch_id" value="<?= $row['id']; ?>" disable required />
                        <input type="text" id="branch_name" name="branch_name" value="<?= $row['branch_name']; ?>" placeholder="ex: CEIT" class="form-control" required />
                    </div>

                    <div class="input-group mb-3">
                        <label class="input-group-text" id="inputGroup-sizing-sm">Description</label>
                        <input type="text" id="branch_desc" name="branch_desc" value="<?= $row['branch_desc']; ?>" placeholder="ex: College of Engineering and Information Technology" class="form-control" required />
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="update_branch" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="removeBranch<?= $id; ?>" tabindex="-1" aria-labelledby="branchModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-5" id="branchModalTitle">Delete this branch?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="actions/actions.php" method="POST">
                <div class="modal-body">

                    <input type="hidden" id="branch_id" name="branch_id" value="<?= $row['id']; ?>" disable required />
                    <h4 class="text-danger">Are you sure you want to delete <span class="fw-bold"><?= $row['branch_name'] ?></span>?</h4>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="delete_branch" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
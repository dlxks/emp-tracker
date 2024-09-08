<!-- Add Modal -->

<div class="modal fade" id="addQuarter<?= $record_id; ?>" tabindex="-1" aria-labelledby="branchModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-5" id="branchModalTitle">Add Record</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="actions/actions.php" method="POST" id="addForm">
                <div class="modal-body">

                    <input type="hidden" id="record_id" name="record_id" value="<?= $record_id; ?>" required />
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-outline">
                                <label class="form-label">Quarter</label>
                                <select name="quarter" id="quarter" class="form-control" required>
                                    <option value="" disabled selected>Choose quarter</option>
                                    <option value="1st">1st Quarter</option>
                                    <option value="2nd">2nd Quarter</option>
                                    <option value="3rd">3rd Quarter</option>
                                    <option value="4th">4th Quarter</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-outline">
                                <label class="form-label" for="year">No. of Employed</label>
                                <input type="number" class="form-control" name="no_of_employed" id="no_of_employed" />
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="add_quarter" class="btn btn-primary">Add Record</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="removeQuarter<?= $id; ?>" tabindex="-1" aria-labelledby="branchModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-5" id="branchModalTitle">Delete this branch?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="actions/actions.php" method="POST">
                <div class="modal-body">

                    <input type="hidden" id="quarter_id" name="quarter_id" value="<?= $id; ?>" required />
                    <h4 class="text-danger">Are you sure you want to delete this record?</h4>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="delete_quarter" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
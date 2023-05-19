<!-- Add Modal -->
<div class="modal fade z-index1" id="exportData" tabindex="-1" aria-labelledby="branchModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title fs-5" id="branchModalTitle">What data to export?</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="actions/actions.php" method="POST">
                <div class="modal-body">

                    <div class="input-group mb-3">
                        <label class="input-group-text" id="inputGroup-sizing-sm">Data</label>
                        <select name="data_from" id="" class="form-control" required>
                            <option value="" selected disabled>Select data</option>
                            <option value="records">Records</option>
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="export_data" class="btn btn-primary">Export</button>
                </div>
            </form>
        </div>
    </div>
</div>
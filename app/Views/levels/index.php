<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<h2 class="mb-3">Levels</h2>

<button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addModal">Add Level</button>

<table class="table table-bordered table-hover shadow-sm">
    <thead class="table-dark">
        <tr>
            <th>Name</th>
            <th>Min Points</th>
            <th>Max Points</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($levels as $level): ?>
        <tr id="levelRow<?= $level['id'] ?>">
            <td><?= esc($level['level_name']) ?></td>
            <td><?= esc($level['min_points']) ?></td>
            <td><?= esc($level['max_points']) ?></td>
            <td>
                <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                    data-bs-target="#editModal<?= $level['id'] ?>">Edit</button>
                <button class="btn btn-sm btn-danger" data-bs-toggle="modal"
                    data-bs-target="#deleteModal<?= $level['id'] ?>">Delete</button>
            </td>
        </tr>

        <div class="modal fade" id="editModal<?= $level['id'] ?>" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form class="editLevelForm" data-id="<?= $level['id'] ?>">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Level</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label>Level Name</label>
                                <input type="text" name="level_name" class="form-control"
                                    value="<?= esc($level['level_name']) ?>" required>
                            </div>
                            <!-- Add / Edit Inputs -->
                            <div class="mb-3">
                                <label>Min Points</label>
                                <input type="number" name="min_points" class="form-control min-points" min="0"
                                    value="<?= isset($level) ? esc($level['min_points']) : '' ?>" required>
                            </div>
                            <div class="mb-3">
                                <label>Max Points</label>
                                <input type="number" name="max_points" class="form-control max-points" min="0"
                                    value="<?= isset($level) ? esc($level['max_points']) : '' ?>" required>
                                <div class="invalid-feedback">Max Points must be greater than or equal to Min Points
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="deleteModal<?= $level['id'] ?>" tabindex="-1">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <form class="deleteLevelForm" data-id="<?= $level['id'] ?>">
                        <div class="modal-header">
                            <h5 class="modal-title text-danger">Confirm Delete</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <p>Delete <strong><?= esc($level['level_name']) ?></strong>?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-danger">Yes</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <?php endforeach; ?>
    </tbody>
</table>

<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="addLevelForm">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Level</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Level Name</label>
                        <input type="text" name="level_name" class="form-control" required>
                    </div>
                    <!-- Add / Edit Inputs -->
                    <div class="mb-3">
                        <label>Min Points</label>
                        <input type="number" name="min_points" class="form-control min-points" min="0"
                            value="<?= isset($level) ? esc($level['min_points']) : '' ?>" required>
                    </div>
                    <div class="mb-3">
                        <label>Max Points</label>
                        <input type="number" name="max_points" class="form-control max-points" min="0"
                            value="<?= isset($level) ? esc($level['max_points']) : '' ?>" required>
                        <div class="invalid-feedback">Max Points must be greater than or equal to Min Points</div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Save</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
$(document).ready(function() {

    function validateMinMax(form) {
        let min = parseInt(form.find('.min-points').val());
        let maxInput = form.find('.max-points');
        let max = parseInt(maxInput.val());

        if (max < min) {
            maxInput.addClass('is-invalid');
            return false;
        } else {
            maxInput.removeClass('is-invalid');
            return true;
        }
    }

    $('#addLevelForm').on('submit', function(e) {
        e.preventDefault();
        if (!validateMinMax($(this))) return;

        $.post('/levels/store', $(this).serialize(), function(response) {
            if(response.status === 'success') {
                $('#addModal').modal('hide');
                toastr.success(response.message || 'Level added');
                setTimeout(() => location.reload(), 800);
            } else if(response.status === 'error') {
                let firstError = Object.values(response.errors)[0];
                toastr.error(firstError);
            }
        }, 'json');
    });

    $('.editLevelForm').on('submit', function(e) {
        e.preventDefault();
        if (!validateMinMax($(this))) return;

        let id = $(this).data('id');
        $.post('/levels/update/' + id, $(this).serialize(), function(response) {
            if(response.status === 'success') {
                $('#editModal' + id).modal('hide');
                toastr.success(response.message || 'Level updated');
                setTimeout(() => location.reload(), 800);
            } else if(response.status === 'error') {
                let firstError = Object.values(response.errors)[0];
                toastr.error(firstError);
            }
        }, 'json');
    });

    $('.deleteLevelForm').on('submit', function(e) {
        e.preventDefault();
        let id = $(this).data('id');
        $.post('/levels/delete/' + id, $(this).serialize(), function(response) {
            if(response.status === 'success') {
                $('#deleteModal' + id).modal('hide');
                toastr.success(response.message || 'Level deleted');
                $('#levelRow' + id).remove();
            } else if(response.status === 'error') {
                let firstError = Object.values(response.errors)[0];
                toastr.error(firstError);
            }
        }, 'json');
    });

    $('.min-points, .max-points').on('input', function() {
        let form = $(this).closest('form');
        validateMinMax(form);
    });

});
</script>


<?= $this->endSection() ?>

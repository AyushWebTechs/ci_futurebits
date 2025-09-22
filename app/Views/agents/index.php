<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<h2 class="mb-3">Agents</h2>

<table class="table table-bordered table-hover shadow-sm">
    <thead class="table-dark">
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Current Level</th>
            <th>Points</th>
            <th>Level Expiry</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($agents as $agent): ?>
        <tr id="agentRow<?= $agent['id'] ?>">
            <td><?= esc($agent['name']) ?></td>
            <td><?= esc($agent['email']) ?></td>
            <td><?= esc($agent['level_name']) ?></td>
            <td><?= esc($agent['points']) ?></td>
            <td><?= esc($agent['level_expires_at']) ?></td>
            <td>
                <button class="btn btn-sm btn-success" data-bs-toggle="modal"
                    data-bs-target="#pointsModal<?= $agent['id'] ?>">Add/Remove Points</button>
                <a href="/agents/history/<?= $agent['id'] ?>" class="btn btn-sm btn-info">History</a>
            </td>
        </tr>

        <!-- Points Modal -->
        <div class="modal fade" id="pointsModal<?= $agent['id'] ?>" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form class="pointsForm" data-id="<?= $agent['id'] ?>">
                        <div class="modal-header">
                            <h5 class="modal-title">Update Points for <?= esc($agent['name']) ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label>Points (+/-)</label>
                                <input type="number" name="points" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>Comment</label>
                                <textarea name="comment" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Save</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </tbody>
</table>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
$(document).ready(function() {
    $('.pointsForm').on('submit', function(e) {
        e.preventDefault();
        let id = $(this).data('id');
        $.post('/agents/addPoints/' + id, $(this).serialize(), function(response) {
            if(response.status === 'success') {
                $('#pointsModal' + id).modal('hide');
                toastr.success(response.message);
                setTimeout(() => location.reload(), 800);
            } else {
                toastr.error('Failed to update points');
            }
        }, 'json');
    });
});
</script>

<?= $this->endSection() ?>

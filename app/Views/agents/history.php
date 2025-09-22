<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<h2>Transaction History</h2>

<table class="table table-bordered table-hover shadow-sm">
    <thead class="table-dark">
        <tr>
            <th>Points</th>
            <th>Comment</th>
            <th>Admin ID</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($transactions as $txn): ?>
        <tr>
            <td><?= esc($txn['points']) ?></td>
            <td><?= esc($txn['comment']) ?></td>
            <td><?= esc($txn['admin_user_id']) ?></td>
            <td><?= esc($txn['created_at']) ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<h2>Level Unlock History</h2>
<table class="table table-bordered table-hover shadow-sm">
    <thead class="table-dark">
        <tr>
            <th>Level</th>
            <th>Unlocked At</th>
            <th>Expiry At</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($levels as $lvl): ?>
        <tr>
            <td><?= esc($lvl['level_name']) ?></td>
            <td><?= esc($lvl['unlocked_at']) ?></td>
            <td><?= esc($lvl['expiry_at']) ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>


<a href="/agents" class="btn btn-secondary">Back</a>

<?= $this->endSection() ?>

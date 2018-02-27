<div class="card-title">Users retention</div>
<div class="table-responsive m-t-10">
    <table class="table">
        <thead>
            <tr>
                <th>All Users</th>
                <?php for ($i = 0; $i < $nthCount; $i++): ?>
                    <th><?php echo $nthType . ' ' . $i; ?></th>
                <?php endfor; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cohorts as $key => $row): ?>
                <tr>
                    <td><?php echo $key; ?></td>
                    <?php foreach ($row as $value): ?>
                        <td class="user-retention <?php echo ($value['retentionRate'] == 0) ? 'zero' : ''; ?>">
                            <div 
                                data-active-users="<?php echo $value['activeUsers']; ?>" 
                                data-retention-rate="<?php echo $value['retentionRate']; ?>" 
                                data-trigger="hover"
                                data-toggle="popover" data-placement="top" data-content="<?php echo 'Active Users: ' . $value['activeUsers'] . ' | Retention Rate: ' . $value['retentionRate'] . '%'; ?>" title="" data-original-title="<?php echo $key; ?>">
                                <?php echo $value['retentionRate']; ?>
                            </div>
                        </td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
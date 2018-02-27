<div class="table-responsive">
    <table class="table table-condensed table-hover" id="realtime-report-active-screen">
        <thead>
            <tr>
                <th>Screen Name</th>
                <th style="text-align: right;">Views</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($screens as $key => $value): ?>
                <tr>
                    <td><?php echo $key; ?></td>
                    <td class="text-right"><?php echo $value; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
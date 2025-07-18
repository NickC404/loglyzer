<div data-theme="light">
    <div class="wrap">
        <h1 style="color: #0c54e5;">Loglyzer Logs!</h1>
    </div>
    <?php if (!empty($logs)) { ?>
        <div class="wrap">
            <table data-theme="light">
                <thead>
                    <tr>
                        <th scope="col">Error</th>
                        <th scope="col">Code</th>
                        <th scope="col">Created At</th>
                        <th scope="col">Context</th>
                    </tr>
                </thead>
                <tbody><?php
                    foreach ($logs as $log) { ?>
                        <tr>
                            <td><?= $log->get_error_message() ?></td>
                            <td><?= $log->get_error_code() ?></td>
                            <td><?= $log->get_datetime()->format('Y-m-d H:i:s'); ?></td>
                            <td><?= json_encode($log->get_context(), JSON_PRETTY_PRINT); ?></td>
                        </tr><?php
                    } ?>
                </tbody>
            </table>
        </div>
    <?php } else { ?>
        <p>No logs to display</p><?php
    } ?>
</div>
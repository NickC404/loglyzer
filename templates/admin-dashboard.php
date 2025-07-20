<?php
    /** @var array $pagination_info */
?>
<div data-theme="light">
    <div class="wrap">
        <h1 style="color: black;">Loglyzer Logs!</h1>
    </div>
    <br />
    <div class="grid">
        <div>
            <form>
                <select name="recordsFor" aria-label="Show logs for..." required>
                    <option selected disabled value="">
                        Select your log range
                    </option>
                    <option>last 30 days</option>
                    <option>last 6 months</option>
                </select>
            </form>
        </div>
    </div>
    <br />
    <div class="grid" style="padding-right: 100px;">
        <canvas id="loglyzer-pie" style="width: 350px; height: 350px;" width="350" height="350"></canvas>
        <canvas id="loglyzer-line" style="width: 100%; max-width: 600px; height: 300px;"></canvas>
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
                <tfoot>
                    <tr>
                        <td colspan="4" style="text-align:center !important;">
                            <?= $pagination_info['start'] + 1 ?> to <?= $pagination_info['end'] + 1 ?> of <?= $pagination_info['max_records'] ?>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    <?php } else { ?>
        <p>No logs to display</p><?php
    } ?>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const ctx = document.getElementById("loglyzer-line").getContext("2d");

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'], // X-axis
                datasets: [{
                    label: 'Error Logs',
                    data: [12, 19, 7, 5, 2, 3, 9], // Y-axis data
                    fill: false,
                    borderColor: '#e74c3c',
                    backgroundColor: '#e74c3c',
                    tension: 0.3 // Smooth curve
                }]
            },
            options: {
                responsive: false,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    },
                    title: {
                        display: true,
                        text: 'Errors per Day'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });

    document.addEventListener("DOMContentLoaded", function () {
        const ctx = document.getElementById("loglyzer-pie").getContext("2d");

        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Info', 'Warning', 'Error', 'Critical'],
                datasets: [{
                    label: 'Log Types',
                    data: [25, 15, 45, 15], // You can dynamically insert PHP values here
                    backgroundColor: [
                        '#36a2eb', // Info
                        '#ffcd56', // Warning
                        '#ff6384', // Error
                        '#e74c3c'  // Critical
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: false,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                    }
                }
            }
        });
    });
</script>
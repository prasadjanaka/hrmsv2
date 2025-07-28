<?php $this->load->view('layouts/header', array('title' => 'Dashboard')); ?>
    <h3 class="mb-4">Dashboard</h3>
    <div class="row g-3">
        <div class="col-md-3">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <h5 class="card-title">Total Employees</h5>
                    <p class="card-text fs-3"><?php echo $stats['total_employees']; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5 class="card-title">Departments</h5>
                    <p class="card-text fs-3"><?php echo $stats['total_departments']; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-info">
                <div class="card-body">
                    <h5 class="card-title">Present Today</h5>
                    <p class="card-text fs-3"><?php echo $stats['present_today']; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning">
                <div class="card-body">
                    <h5 class="card-title">On Leave</h5>
                    <p class="card-text fs-3"><?php echo $stats['on_leave_today']; ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-lg-8 mb-4">
            <div class="card">
                <div class="card-header">
                    Attendance Trend (Last 7 Days)
                </div>
                <div class="card-body">
                    <canvas id="attendanceTrendChart" height="120"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mb-4">
            <div class="card">
                <div class="card-header">
                    Department Distribution
                </div>
                <div class="card-body">
                    <canvas id="departmentDistributionChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    Recent Activities
                </div>
                <div class="card-body">
                    <?php if(!empty($recent_activities)): ?>
                        <ul class="list-group list-group-flush">
                            <?php foreach($recent_activities as $activity): ?>
                                <li class="list-group-item">
                                    <?php echo $activity->first_name.' '.$activity->last_name; ?> - 
                                    <?php echo ucfirst($activity->status); ?> on <?php echo date('M d, Y', strtotime($activity->date)); ?>
                                    <span class="text-muted small">(<?php echo date('H:i', strtotime($activity->created_at)); ?>)</span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p>No recent activities.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

<?php $this->load->view('layouts/footer'); ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
// Attendance Trend Chart
const trendCtx = document.getElementById('attendanceTrendChart').getContext('2d');
const trendLabels = <?php echo json_encode(array_keys($attendance_trend)); ?>;
const trendData = <?php echo json_encode(array_values($attendance_trend)); ?>;
new Chart(trendCtx, {
    type: 'line',
    data: {
        labels: trendLabels,
        datasets: [{
            label: 'Present',
            data: trendData,
            borderColor: '#0d6efd',
            backgroundColor: 'rgba(13,110,253,0.1)',
            tension: 0.3,
            fill: true,
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: { beginAtZero: true }
        }
    }
});

// Department Distribution Pie Chart
const distCtx = document.getElementById('departmentDistributionChart').getContext('2d');
const distLabels = <?php echo json_encode(array_keys($department_distribution)); ?>;
const distData = <?php echo json_encode(array_values($department_distribution)); ?>;
new Chart(distCtx, {
    type: 'pie',
    data: {
        labels: distLabels,
        datasets: [{
            label: 'Employees',
            data: distData,
            backgroundColor: [
                '#0d6efd', '#198754', '#dc3545', '#ffc107', '#6f42c1', '#20c997'
            ]
        }]
    },
    options: { responsive: true }
});
</script>
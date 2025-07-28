<?php $this->load->view('layouts/header', array('title' => 'Dashboard')); ?>

<div class="content-card">
    <div class="row g-3">
        <div class="col-xl-3 col-md-6">
            <div class="card text-white bg-primary h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3">
                        <i class="fas fa-users fa-2x"></i>
                    </div>
                    <div>
                        <h5 class="card-title mb-1">Total Employees</h5>
                        <h2 class="mb-0"><?php echo $stats['total_employees']; ?></h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card text-white bg-success h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3">
                        <i class="fas fa-building fa-2x"></i>
                    </div>
                    <div>
                        <h5 class="card-title mb-1">Departments</h5>
                        <h2 class="mb-0"><?php echo $stats['total_departments']; ?></h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card text-white bg-info h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3">
                        <i class="fas fa-user-check fa-2x"></i>
                    </div>
                    <div>
                        <h5 class="card-title mb-1">Present Today</h5>
                        <h2 class="mb-0"><?php echo $stats['present_today']; ?></h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card text-white bg-warning h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3">
                        <i class="fas fa-calendar-times fa-2x"></i>
                    </div>
                    <div>
                        <h5 class="card-title mb-1">On Leave</h5>
                        <h2 class="mb-0"><?php echo $stats['on_leave_today']; ?></h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8 mb-4">
        <div class="content-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Attendance Trend (Last 7 Days)</h5>
                <div class="text-muted small">
                    <i class="fas fa-chart-line me-1"></i>
                    Daily Present Count
                </div>
            </div>
            <canvas id="attendanceTrendChart" height="120"></canvas>
        </div>
    </div>
    <div class="col-lg-4 mb-4">
        <div class="content-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Department Distribution</h5>
                <div class="text-muted small">
                    <i class="fas fa-pie-chart me-1"></i>
                    Employee Count
                </div>
            </div>
            <canvas id="departmentDistributionChart"></canvas>
        </div>
    </div>
</div>

<div class="content-card">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0">Recent Activities</h5>
        <a href="<?php echo site_url('attendance'); ?>" class="btn btn-sm btn-outline-primary">
            <i class="fas fa-eye me-1"></i>View All
        </a>
    </div>
    <?php if(!empty($recent_activities)): ?>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Employee</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Time</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($recent_activities as $activity): ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="user-avatar bg-secondary me-2" style="width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 12px;">
                                        <?php echo strtoupper(substr($activity->first_name, 0, 1) . substr($activity->last_name, 0, 1)); ?>
                                    </div>
                                    <?php echo $activity->first_name.' '.$activity->last_name; ?>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-<?php echo $activity->status == 'present' ? 'success' : ($activity->status == 'late' ? 'warning' : 'danger'); ?>">
                                    <?php echo ucfirst($activity->status); ?>
                                </span>
                            </td>
                            <td><?php echo date('M d, Y', strtotime($activity->date)); ?></td>
                            <td class="text-muted"><?php echo date('H:i', strtotime($activity->created_at)); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="text-center py-4 text-muted">
            <i class="fas fa-inbox fa-3x mb-3"></i>
            <p>No recent activities.</p>
        </div>
    <?php endif; ?>
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
        labels: trendLabels.map(date => {
            const d = new Date(date);
            return d.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
        }),
        datasets: [{
            label: 'Present',
            data: trendData,
            borderColor: '#0d6efd',
            backgroundColor: 'rgba(13,110,253,0.1)',
            tension: 0.4,
            fill: true,
            pointBackgroundColor: '#0d6efd',
            pointBorderColor: '#fff',
            pointBorderWidth: 2,
            pointRadius: 5,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: { 
                beginAtZero: true,
                grid: {
                    color: 'rgba(0,0,0,0.1)'
                }
            },
            x: {
                grid: {
                    display: false
                }
            }
        }
    }
});

// Department Distribution Pie Chart
const distCtx = document.getElementById('departmentDistributionChart').getContext('2d');
const distLabels = <?php echo json_encode(array_keys($department_distribution)); ?>;
const distData = <?php echo json_encode(array_values($department_distribution)); ?>;

new Chart(distCtx, {
    type: 'doughnut',
    data: {
        labels: distLabels,
        datasets: [{
            label: 'Employees',
            data: distData,
            backgroundColor: [
                '#0d6efd', '#198754', '#dc3545', '#ffc107', '#6f42c1', '#20c997'
            ],
            borderWidth: 0,
            hoverOffset: 4
        }]
    },
    options: { 
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    usePointStyle: true,
                    padding: 15
                }
            }
        }
    }
});
</script>
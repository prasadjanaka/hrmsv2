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

<!-- Quick Action Buttons -->
<div class="content-card">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0">Quick Actions</h5>
        <small class="text-muted">Frequently used functions</small>
    </div>
    <div class="row g-3">
        <div class="col-lg-2 col-md-4 col-sm-6">
            <a href="<?php echo site_url('employees/add'); ?>" class="btn btn-outline-primary w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3 text-decoration-none">
                <i class="fas fa-user-plus fa-2x mb-2"></i>
                <span class="small">Add Employee</span>
            </a>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6">
            <a href="<?php echo site_url('attendance'); ?>" class="btn btn-outline-success w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3 text-decoration-none">
                <i class="fas fa-clock fa-2x mb-2"></i>
                <span class="small">Mark Attendance</span>
            </a>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6">
            <a href="<?php echo site_url('leaves'); ?>" class="btn btn-outline-warning w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3 text-decoration-none">
                <i class="fas fa-calendar-alt fa-2x mb-2"></i>
                <span class="small">Apply Leave</span>
            </a>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6">
            <a href="<?php echo site_url('salary'); ?>" class="btn btn-outline-info w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3 text-decoration-none">
                <i class="fas fa-money-bill-wave fa-2x mb-2"></i>
                <span class="small">Generate Payroll</span>
            </a>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6">
            <a href="<?php echo site_url('reports'); ?>" class="btn btn-outline-secondary w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3 text-decoration-none">
                <i class="fas fa-chart-bar fa-2x mb-2"></i>
                <span class="small">View Reports</span>
            </a>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6">
            <a href="<?php echo site_url('settings'); ?>" class="btn btn-outline-dark w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3 text-decoration-none">
                <i class="fas fa-cog fa-2x mb-2"></i>
                <span class="small">Settings</span>
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8 mb-4">
        <div class="content-card">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h5 class="mb-1">Weekly Attendance Overview</h5>
                    <p class="text-muted small mb-0">Last 7 days attendance summary</p>
                </div>
                <div class="badge bg-primary">This Week</div>
            </div>
            
            <div class="row g-2" id="attendanceTrendCards">
                <!-- Attendance cards will be generated by JavaScript -->
            </div>
            
            <div class="mt-4 pt-3 border-top">
                <div class="row text-center">
                    <div class="col-4">
                        <div class="text-success fw-bold h5 mb-1" id="avgAttendance">0</div>
                        <small class="text-muted">Avg Daily</small>
                    </div>
                    <div class="col-4">
                        <div class="text-primary fw-bold h5 mb-1" id="totalPresent">0</div>
                        <small class="text-muted">Total Present</small>
                    </div>
                    <div class="col-4">
                        <div class="text-info fw-bold h5 mb-1" id="attendanceRate">0%</div>
                        <small class="text-muted">Rate</small>
                    </div>
                </div>
            </div>
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
// Attendance Trend Cards
const trendLabels = <?php echo json_encode(array_keys($attendance_trend)); ?>;
const trendData = <?php echo json_encode(array_values($attendance_trend)); ?>;

function createAttendanceCards() {
    const container = document.getElementById('attendanceTrendCards');
    const totalEmployees = <?php echo $stats['total_employees']; ?>;
    let totalPresent = 0;
    
    trendLabels.forEach((date, index) => {
        const presentCount = trendData[index];
        const attendancePercentage = totalEmployees > 0 ? Math.round((presentCount / totalEmployees) * 100) : 0;
        totalPresent += presentCount;
        
        const dateObj = new Date(date);
        const dayName = dateObj.toLocaleDateString('en-US', { weekday: 'short' });
        const dayNumber = dateObj.getDate();
        
        // Determine card color based on attendance rate
        let cardClass = 'border-success bg-light-success';
        let iconClass = 'fas fa-check-circle text-success';
        if (attendancePercentage < 50) {
            cardClass = 'border-danger bg-light-danger';
            iconClass = 'fas fa-times-circle text-danger';
        } else if (attendancePercentage < 80) {
            cardClass = 'border-warning bg-light-warning';
            iconClass = 'fas fa-exclamation-circle text-warning';
        }
        
        const cardHtml = `
            <div class="col">
                <div class="card h-100 ${cardClass} border-2">
                    <div class="card-body text-center p-3">
                        <div class="mb-2">
                            <i class="${iconClass} fa-lg"></i>
                        </div>
                        <div class="fw-bold text-dark">${dayName}</div>
                        <div class="small text-muted mb-2">${dayNumber}</div>
                        <div class="fw-bold h6 text-dark">${presentCount}</div>
                        <div class="small text-muted">${attendancePercentage}%</div>
                    </div>
                </div>
            </div>
        `;
        container.innerHTML += cardHtml;
    });
    
    // Update summary stats
    const avgAttendance = Math.round(totalPresent / trendLabels.length);
    const overallRate = totalEmployees > 0 ? Math.round((totalPresent / (totalEmployees * 7)) * 100) : 0;
    
    document.getElementById('avgAttendance').textContent = avgAttendance;
    document.getElementById('totalPresent').textContent = totalPresent;
    document.getElementById('attendanceRate').textContent = overallRate + '%';
}

// Custom CSS for light backgrounds
const style = document.createElement('style');
style.textContent = `
    .bg-light-success { background-color: rgba(25, 135, 84, 0.1) !important; }
    .bg-light-warning { background-color: rgba(255, 193, 7, 0.1) !important; }
    .bg-light-danger { background-color: rgba(220, 53, 69, 0.1) !important; }
`;
document.head.appendChild(style);

// Initialize attendance cards
createAttendanceCards();

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
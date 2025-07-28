<?php $this->load->view('layouts/header', array('title' => 'Employees')); ?>

<div class="content-card">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
        <div class="mb-2 mb-md-0">
            <h3 class="mb-1">Employees</h3>
            <p class="text-muted mb-0">Manage employee information and records</p>
        </div>
        <a href="<?php echo site_url('employees/add'); ?>" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Add Employee
        </a>
    </div>

    <!-- Search and Filter Form -->
    <form class="row g-3 mb-4" method="get" action="<?php echo site_url('employees'); ?>">
        <div class="col-md-4 col-sm-6">
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-search"></i></span>
                <input type="text" name="keyword" class="form-control" placeholder="Search by name or ID" value="<?php echo $this->input->get('keyword'); ?>">
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <select name="department" class="form-select">
                <option value="">All Departments</option>
                <?php foreach($departments as $d): ?>
                    <option value="<?php echo $d->id; ?>" <?php echo $this->input->get('department')==$d->id?'selected':''; ?>><?php echo $d->name; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-3 col-sm-6">
            <select name="designation" class="form-select">
                <option value="">All Designations</option>
                <?php foreach($designations as $des): ?>
                    <option value="<?php echo $des->id; ?>" <?php echo $this->input->get('designation')==$des->id?'selected':''; ?>><?php echo $des->title; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-2 col-sm-6">
            <button type="submit" class="btn btn-secondary w-100">
                <i class="fas fa-filter me-1"></i>Filter
            </button>
        </div>
    </form>

    <!-- Desktop Table View -->
    <div class="table-responsive d-none d-lg-block">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Employee</th>
                    <th>Department</th>
                    <th>Designation</th>
                    <th>Salary Mode</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($employees as $emp): ?>
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="employee-avatar me-3">
                                <?php if($emp->profile_photo): ?>
                                    <img src="<?php echo base_url($emp->profile_photo); ?>" width="40" height="40" class="rounded-circle object-fit-cover">
                                <?php else: ?>
                                    <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center text-white" style="width: 40px; height: 40px;">
                                        <?php echo strtoupper(substr($emp->first_name, 0, 1) . substr($emp->last_name, 0, 1)); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div>
                                <div class="fw-medium"><?php echo $emp->first_name.' '.$emp->last_name; ?></div>
                                <small class="text-muted"><?php echo $emp->employee_id; ?></small>
                            </div>
                        </div>
                    </td>
                    <td><?php echo $emp->department_name; ?></td>
                    <td><?php echo $emp->designation_title; ?></td>
                    <td>
                        <span class="badge bg-<?php echo $emp->salary_mode == 'monthly' ? 'primary' : 'success'; ?>">
                            <?php echo ucfirst($emp->salary_mode); ?>
                        </span>
                    </td>
                    <td class="text-center">
                        <div class="btn-group" role="group">
                            <a href="<?php echo site_url('employees/edit/'.$emp->id); ?>" class="btn btn-sm btn-outline-primary" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="<?php echo site_url('employees/delete/'.$emp->id); ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this employee?');" title="Delete">
                                <i class="fas fa-trash"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Mobile Card View -->
    <div class="d-lg-none">
        <?php foreach($employees as $emp): ?>
        <div class="card mb-3">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="employee-avatar me-3">
                        <?php if($emp->profile_photo): ?>
                            <img src="<?php echo base_url($emp->profile_photo); ?>" width="50" height="50" class="rounded-circle object-fit-cover">
                        <?php else: ?>
                            <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center text-white" style="width: 50px; height: 50px;">
                                <?php echo strtoupper(substr($emp->first_name, 0, 1) . substr($emp->last_name, 0, 1)); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="mb-1"><?php echo $emp->first_name.' '.$emp->last_name; ?></h6>
                        <small class="text-muted"><?php echo $emp->employee_id; ?></small>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="<?php echo site_url('employees/edit/'.$emp->id); ?>"><i class="fas fa-edit me-2"></i>Edit</a></li>
                            <li><a class="dropdown-item text-danger" href="<?php echo site_url('employees/delete/'.$emp->id); ?>" onclick="return confirm('Delete this employee?');"><i class="fas fa-trash me-2"></i>Delete</a></li>
                        </ul>
                    </div>
                </div>
                <div class="row text-sm">
                    <div class="col-6">
                        <strong>Department:</strong><br>
                        <span class="text-muted"><?php echo $emp->department_name; ?></span>
                    </div>
                    <div class="col-6">
                        <strong>Designation:</strong><br>
                        <span class="text-muted"><?php echo $emp->designation_title; ?></span>
                    </div>
                </div>
                <div class="mt-2">
                    <span class="badge bg-<?php echo $emp->salary_mode == 'monthly' ? 'primary' : 'success'; ?>">
                        <?php echo ucfirst($emp->salary_mode); ?> Salary
                    </span>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <?php if(empty($employees)): ?>
    <div class="text-center py-5">
        <i class="fas fa-users fa-4x text-muted mb-3"></i>
        <h5 class="text-muted">No employees found</h5>
        <p class="text-muted">Try adjusting your search criteria or add a new employee.</p>
        <a href="<?php echo site_url('employees/add'); ?>" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Add First Employee
        </a>
    </div>
    <?php endif; ?>
</div>

<?php $this->load->view('layouts/footer'); ?>
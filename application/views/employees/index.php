<?php $this->load->view('layouts/header', array('title' => 'Employees')); ?>
<div class="d-flex justify-content-between mb-3">
    <h3>Employees</h3>
    <a href="<?php echo site_url('employees/add'); ?>" class="btn btn-primary">Add Employee</a>
</div>

<form class="row g-2 mb-4" method="get" action="<?php echo site_url('employees'); ?>">
    <div class="col-md-4">
        <input type="text" name="keyword" class="form-control" placeholder="Search by name or ID" value="<?php echo $this->input->get('keyword'); ?>">
    </div>
    <div class="col-md-3">
        <select name="department" class="form-select">
            <option value="">All Departments</option>
            <?php foreach($departments as $d): ?>
                <option value="<?php echo $d->id; ?>" <?php echo $this->input->get('department')==$d->id?'selected':''; ?>><?php echo $d->name; ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-md-3">
        <select name="designation" class="form-select">
            <option value="">All Designations</option>
            <?php foreach($designations as $des): ?>
                <option value="<?php echo $des->id; ?>" <?php echo $this->input->get('designation')==$des->id?'selected':''; ?>><?php echo $des->title; ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-md-2">
        <button type="submit" class="btn btn-secondary w-100">Filter</button>
    </div>
</form>

<table class="table table-bordered table-hover">
    <thead class="table-light">
        <tr>
            <th>ID</th>
            <th>Photo</th>
            <th>Name</th>
            <th>Department</th>
            <th>Designation</th>
            <th>Salary Mode</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($employees as $emp): ?>
        <tr>
            <td><?php echo $emp->employee_id; ?></td>
            <td><?php if($emp->profile_photo): ?><img src="<?php echo base_url($emp->profile_photo); ?>" width="40" height="40"><?php endif; ?></td>
            <td><?php echo $emp->first_name.' '.$emp->last_name; ?></td>
            <td><?php echo $emp->department_name; ?></td>
            <td><?php echo $emp->designation_title; ?></td>
            <td><?php echo ucfirst($emp->salary_mode); ?></td>
            <td>
                <a href="<?php echo site_url('employees/edit/'.$emp->id); ?>" class="btn btn-sm btn-warning">Edit</a>
                <a href="<?php echo site_url('employees/delete/'.$emp->id); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this employee?');">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php $this->load->view('layouts/footer'); ?>
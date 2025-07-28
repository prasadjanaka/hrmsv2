<?php $this->load->view('layouts/header', array('title' => isset($employee)?'Edit Employee':'Add Employee')); ?>
<?php if(isset($error)) echo $error; ?>
<?php echo form_open_multipart(); ?>
<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label">Employee ID</label>
            <input type="text" name="employee_id" class="form-control" value="<?php echo set_value('employee_id', $employee->employee_id ?? ''); ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">First Name</label>
            <input type="text" name="first_name" class="form-control" value="<?php echo set_value('first_name', $employee->first_name ?? ''); ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Last Name</label>
            <input type="text" name="last_name" class="form-control" value="<?php echo set_value('last_name', $employee->last_name ?? ''); ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="<?php echo set_value('email', $employee->email ?? ''); ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Phone</label>
            <input type="text" name="phone" class="form-control" value="<?php echo set_value('phone', $employee->phone ?? ''); ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Address</label>
            <textarea name="address" class="form-control"><?php echo set_value('address', $employee->address ?? ''); ?></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Department</label>
            <select name="department_id" class="form-select">
                <option value="">Select</option>
                <?php foreach($departments as $d): ?>
                    <option value="<?php echo $d->id; ?>" <?php echo set_select('department_id', $d->id, ($employee->department_id ?? '')==$d->id); ?>><?php echo $d->name; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Designation</label>
            <select name="designation_id" class="form-select">
                <option value="">Select</option>
                <?php foreach($designations as $des): ?>
                    <option value="<?php echo $des->id; ?>" <?php echo set_select('designation_id', $des->id, ($employee->designation_id ?? '')==$des->id); ?>><?php echo $des->title; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label">Cadre</label>
            <select name="cadre_id" class="form-select">
                <option value="">Select</option>
                <?php foreach($cadres as $c): ?>
                    <option value="<?php echo $c->id; ?>" <?php echo set_select('cadre_id', $c->id, ($employee->cadre_id ?? '')==$c->id); ?>><?php echo $c->name; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Shift</label>
            <select name="shift_id" class="form-select">
                <option value="">Select</option>
                <?php foreach($shifts as $s): ?>
                    <option value="<?php echo $s->id; ?>" <?php echo set_select('shift_id', $s->id, ($employee->shift_id ?? '')==$s->id); ?>><?php echo $s->name; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Salary Mode</label>
            <select name="salary_mode" class="form-select" id="salary_mode_select" required>
                <option value="monthly" <?php echo set_select('salary_mode', 'monthly', ($employee->salary_mode ?? 'monthly')=='monthly'); ?>>Monthly</option>
                <option value="daily" <?php echo set_select('salary_mode', 'daily', ($employee->salary_mode ?? '')=='daily'); ?>>Daily</option>
            </select>
        </div>
        <div class="mb-3" id="monthly_salary_group">
            <label class="form-label">Monthly Salary</label>
            <input type="number" step="0.01" name="monthly_salary" class="form-control" value="<?php echo set_value('monthly_salary', $employee->monthly_salary ?? ''); ?>">
        </div>
        <div class="mb-3" id="daily_rate_group" style="display:none;">
            <label class="form-label">Daily Rate</label>
            <input type="number" step="0.01" name="daily_rate" class="form-control" value="<?php echo set_value('daily_rate', $employee->daily_rate ?? ''); ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Profile Photo</label>
            <input type="file" name="profile_photo" class="form-control">
            <?php if(!empty($employee->profile_photo)): ?>
                <img src="<?php echo base_url($employee->profile_photo); ?>" width="80" class="mt-2">
            <?php endif; ?>
        </div>
    </div>
</div>
<button type="submit" name="submit" class="btn btn-success">Save</button>
<a href="<?php echo site_url('employees'); ?>" class="btn btn-secondary">Back</a>
<?php echo form_close(); ?>

<script>
// Toggle salary fields visibility
function toggleSalaryFields() {
    const mode = document.getElementById('salary_mode_select').value;
    document.getElementById('monthly_salary_group').style.display = mode==='monthly' ? 'block':'none';
    document.getElementById('daily_rate_group').style.display = mode==='daily' ? 'block':'none';
}

document.getElementById('salary_mode_select').addEventListener('change', toggleSalaryFields);
// Initial call
toggleSalaryFields();
</script>
<?php $this->load->view('layouts/footer'); ?>
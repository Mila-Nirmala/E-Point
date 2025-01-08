<?php $__env->startSection('content'); ?>
<h1>Daftar</h1>
<br>
<a href="<?php echo e(route('login')); ?>">Login</a>
<br>
<form action="<?php echo e(route('store')); ?>" method="post">
    <?php echo csrf_field(); ?>
    <label>Nama Lengkap</label>
    <input type="text" name="name" id="name" value="<?php echo e(old('name')); ?>">
    <?php if($errors->first('name')): ?>
    <span class="text-danger"><?php echo e($errors->first('name')); ?></span>
    <?php endif; ?>
    <br>

    <label>Email Address</label>
    <input type="email" name="email" id="email" value="<?php echo e(old('email')); ?>">
    <?php if($errors->first('email')): ?>
    <span class="text-danger"><?php echo e($errors->first('email')); ?></span>
    <?php endif; ?>
    <br>

    <label>Password</label>
    <input type="password" name="password" id="password">
    <?php if($errors->first('password')): ?>
    <span class="text-danger"><?php echo e($errors->first('password')); ?></span>
    <?php endif; ?>
    <br>

    <label for="password_confirmation" class="col-md-4 col-form-label text-md-end text-start">Confirm Password</label>
    <div class="col-md-6">
        <input type="password" class="form-control" name="password_confirmation" id="password_confirmation">
    </div>
    <input type="submit" value="Register">
</form>
<?php echo $__env->make('auth.layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\mila_nirmala\resources\views/auth/register.blade.php ENDPATH**/ ?>
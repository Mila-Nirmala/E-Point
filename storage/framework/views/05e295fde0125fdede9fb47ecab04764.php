<?php $__env->startSection('content'); ?>

<h1>Login</h1>
<a href="<?php echo e(route('register')); ?>">Daftar</a>
<br>
<form action="<?php echo e(route ('authenticate')); ?>" method="post">
    <?php echo csrf_field(); ?>
    <label>Email</label>
    <br>
    <input type="email" name="email" id="email" value=" <?php echo e(old ('email')); ?>">
    <br>
    <label>Password</label>
    <br>
    <input type="password" name="password" id="password">
    <br>
    <input type="submit" value="Login">
</form>
<?php echo $__env->make('auth.layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\mila_nirmala\resources\views/auth/login.blade.php ENDPATH**/ ?>
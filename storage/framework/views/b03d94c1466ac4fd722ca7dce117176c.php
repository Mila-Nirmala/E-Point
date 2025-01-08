<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
</head>
<body>
    <a href="<?php echo e(route('siswa.index')); ?>" class="nav-link">Data Siswa</a>
    <a href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>
    <form action="<?php echo e(route('logout')); ?>" id="logout-form" method="POST">
        <?php echo csrf_field(); ?> 
    </form>
    <h1>Dashboard Admin</h1>
    <?php if($message = Session::get('success')): ?>
    <p><?php echo e($message); ?></p>
    <?php else: ?>
    <p>Kamu Telah Login</p>
    <?php endif; ?>
</body>
</html><?php /**PATH C:\laragon\www\mila_nirmala\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>
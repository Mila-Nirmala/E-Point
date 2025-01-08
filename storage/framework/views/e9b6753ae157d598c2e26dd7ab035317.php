<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Data</title>
    <style>
        table{
            width:100%;
            border-collapse: collapse;
            margin: 20px 0px;
        }

        table,
        th,
        td{
            border: 1px solid;
        }
    </style>
</head>
<body>
    <h1>Edit Siswa</h1>
    <a href="<?php echo e(route('siswa.index')); ?>">Kembali</a>
    <br><br>

    <?php if($errors->any()): ?>
    <div class="alert alert-danger">
        <ul>
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
    <?php endif; ?>

    <form action="<?php echo e(route('siswa.update', $siswa->id)); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        <h2>Data Siswa</h2>
        <label>Foto Siswa</label>
        <img src="<?php echo e(asset('storage/public/siswas/' .$siswa->image)); ?>" width="120px" height="120px">
        <input type="file" name="image" accept="image/*">
        <br><br>

        <label >Nis Siswa</label>
        <input type="text" name="nis" id="nis" value="<?php echo e(old('nis', $siswa->nis)); ?>" required>
        <br><br>

        <label>Nama Lengkap</label>
        <input type="text" name="name" id="name" value="<?php echo e(old('name', $siswa->name)); ?>" required>
        <br><br>

        <label>Tingkatan</label>
        <select name="tingkatan">
            <option <?php echo e('X' == $siswa->tingkatan ? 'selected' : ''); ?> value="X"> X </option>
            <option <?php echo e('XI' == $siswa->tingkatan ? 'selected' : ''); ?> value="XI"> XI </option>
            <option <?php echo e('XII' == $siswa->tingkatan ? 'selected' : ''); ?> value="XII"> XII </option>
        </select>
        <br><br>

        <label>Jurusan</label>
        <select name="jurusan">
            <option <?php echo e('TBSM' == $siswa->jurusan ? 'selected' : ''); ?> value="TBSM"> TBSM </option>
            <option <?php echo e('TJKT' == $siswa->jurusan ? 'selected' : ''); ?> value="TJKT"> TJKT </option>
            <option <?php echo e('PPLG' == $siswa->jurusan ? 'selected' : ''); ?> value="PPLG"> PPLG </option>
            <option <?php echo e('DKV' == $siswa->jurusan ? 'selected' : ''); ?> value="DKV"> DKV </option>
            <option <?php echo e('TOI' == $siswa->jurusan ? 'selected' : ''); ?> value="TOI"> TOI </option>
        </select>
        <br><br>

        <label>Kelas</label>
        <select name="kelas">
            <option <?php echo e('1' == $siswa->kelas ? 'selected' : ''); ?> value="1"> 1 </option>
            <option <?php echo e('2' == $siswa->kelas ? 'selected' : ''); ?> value="2"> 2 </option>
            <option <?php echo e('3' == $siswa->kelas ? 'selected' : ''); ?> value="3"> 3 </option>
            <option <?php echo e('4' == $siswa->kelas ? 'selected' : ''); ?> value="4"> 4 </option>
        </select>
        <br><br>

        <label>No Hp</label>
        <input type="text" name="hp" value="<?php echo e(old('hp', $siswa->hp)); ?>" required>
        <br><br>

        <label>Status</label>
        <select name="status">
            <option <?php echo e('1' == $siswa->status ? 'selected' : ''); ?> value="1"> Aktif </option>
            <option <?php echo e('0' == $siswa->status ? 'selected' : ''); ?> value="0"> Tidak Aktif </option>
        </select>
        <br>
        <br>

        <button type="submit">SIMPAN DATA</button>
        <button type="reset">RESET DATA</button>
    </form>
</body>
</html><?php /**PATH C:\laragon\www\mila_nirmala\resources\views/admin/siswa/edit.blade.php ENDPATH**/ ?>
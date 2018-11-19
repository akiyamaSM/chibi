<form action=" <?php echo route('test_csrf') ?>" method="POST">
    <label for="name">Name</label>
    <input type="text" name="name" />
    <input type="hidden" name="csrf_token" value="<?php echo \Kolores\Session\Session::put('csrf_token', '12345') ?>" />
    <input type="submit">
</form>
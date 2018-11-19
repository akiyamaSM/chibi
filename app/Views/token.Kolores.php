<form action=" <?php echo route('test_csrf') ?>" method="POST">
    <label for="name">Name</label>
    <input type="text" name="name" />
    @csrf_field
    <input type="submit">
</form>
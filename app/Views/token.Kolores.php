<form action="@route_to('Hola', [ 'Houssain'])" method="POST">
    <label for="name">Name</label>
    <input type="text" name="name" />
    @csrf_field
    <input type="submit">
</form>

<form action="@route_to('test_csrf')" method="POST">
    <label for="name">Last Name</label>
    <input type="text" name="last_name" />
    @csrf_field
    <input type="submit">
</form>
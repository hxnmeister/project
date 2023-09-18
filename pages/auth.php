<h1>Authorization</h1>

<form action="/auth" method="post">
    <div class="form-group mt-5">
        <label>Email:</label>
        <input type="email" name="email" class="form-control">
    </div>

    <div class="form-group mt-3">
        <label>Password:</label>
        <input type="password" name="password" class="form-control">
    </div>

    <button class="btn btn-outline-success mt-5" name="action" value="checkAuth">Log In</button>
</form>
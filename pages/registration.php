<h1>Registration</h1>

<form action="/registration" method="post">
    <div class="form-group">
        <label>Email:</label>
        <input type="email" name="email" class="form-control">
    </div>

    <div class="form-group mt-3">
        <label>Password:</label>
        <input type="password" name="password" class="form-control">
    </div>

    <div class="form-group mt-3">
        <label>Repeat Password:</label>
        <input type="password" name="reppassword" class="form-control">
    </div>

    <button class="btn btn-primary mt-3" name="action" value="checkRegistration">Sign Up</button>
</form>
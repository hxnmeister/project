<h1>Registration</h1>

<?php Message::show()?>

<form action="/registration" method="post">
    <div class="form-group mt-5">
        <label>Email:</label>
        <input type="email" name="email" class="form-control" value="<?= OldInputs::get('email') ?>">
    </div>

    <div class="form-group mt-3">
        <label>Password:</label>
        <input type="password" name="password" class="form-control">
    </div>

    <div class="form-group mt-3">
        <label>Repeat Password:</label>
        <input type="password" name="reppassword" class="form-control">
    </div>

    <button class="btn btn-outline-success mt-5" name="action" value="checkRegistration">Sign Up</button>
</form>
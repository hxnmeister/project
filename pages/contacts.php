<h1>Contacts</h1>

<?php Message::show();?>

<form action="/contacts" method="post">
    <div class="form-group">
        <label>Name:</label>
        <input type="text" class="form-control" name="name" value="<?= OldInputs::get('name') ?>">
    </div>

    <div class="form-group mt-3">
        <label>Email:</label>
        <input type="email" class="form-control" name="email" value="<?= OldInputs::get('email') ?>">
    </div>

    <div class="form-group mt-3">
        <label>Message:</label>
        <textarea type="text" class="form-control" name="message"><?= OldInputs::get('message') ?></textarea>
    </div>

    <button class="btn btn-primary mt-3" name="action" value="sendEmail">Send</button>
</form>
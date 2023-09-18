<h1>Contacts</h1>

<form action="/contacts" method="post">
    <div class="form-group">
        <label>Name:</label>
        <input type="text" class="form-control" name="name">
    </div>

    <div class="form-group mt-3">
        <label>Email:</label>
        <input type="email" class="form-control" name="email">
    </div>

    <div class="form-group mt-3">
        <label>Message:</label>
        <textarea type="text" class="form-control" name="message"></textarea>
    </div>

    <button class="btn btn-primary mt-3" name="action" value="sendEmail">Send</button>
</form>
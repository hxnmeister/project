<h1>Uploads</h1>

<?= Message::show()?>

<form action="/uploads" method="post" enctype="multipart/form-data">
    <input class="mt-3" type="file" name="file">
    <br>
    <button class="btn btn-outline-primary mt-5" name="action" value="uploadImage">Load File</button>
</form>
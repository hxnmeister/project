<h1>Upload with custom directory</h1>

<?= Message::show()?>

<form action="/custom-dir-upload" method="post" enctype="multipart/form-data">
    <label>Enter directory name:</label>
    <input type="text" name="dir-name" class="form-control" value="<?= OldInputs::get('dir-name')?>">

    <input type="file" name="files[]" class="mt-3" multiple>
    <br>
    <button class="btn btn-outline-primary mt-5" name="action" value="uploadFewImages">Load File(-s)</button>
</form>
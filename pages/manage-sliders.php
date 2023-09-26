<h1>Manage Sliders</h1>

<?= Message::show()?>

<form action="/manage-sliders" method="post" enctype="multipart/form-data">
    <div class="d-flex justify-content-between mt-5">
        <div class="form-group col-3">
            <label>Enter directory name:</label>
            <input class="form-control" type="text" name="dir-name" value="<?= OldInputs::get('dir-name')?>">

            <button class="btn btn-outline-primary float-end mt-3" name="action" value="createSlider">Create Slider</button>        
        </div>

        <div class="form-group">
            <label>Load Image</label>
            <select name="selected-slider" class="form-select">
                <?= getSlidersDirs()?>
            </select>

            <input class="form-control mt-3" type="file" name="files[]" multiple>
            <button class="btn btn-outline-primary float-end mt-3" name="action" value="loadImageToSlider">Save Image</button>
        </div>

        <div class="form-group col-3">
            <label>Delete Slider</label>
            <select name="selected-slider" class="form-select">
                <?= getSlidersDirs()?>
            </select>

            <button class="btn btn-outline-primary float-end mt-3" name="action" value="deleteSlider">Confirm Deleting</button>
        </div>
    </div>
</form>
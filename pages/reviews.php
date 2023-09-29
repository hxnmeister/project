<h1>Reviews</h1>

<?php Message::show(); ?>

<form action="/reviews" method="post">
    <div class="form-group">
        <label>Your Name:</label>
        <input type="text" name="name" class="form-control">
    </div>
    <div class="form-group mt-3">
        <label>Review Text:</label>
        <textarea name="review" class="form-control" cols="30" rows="2"></textarea>
    </div>

    <img src="./images/captcha.php" alt="">

    <button class="btn btn-outline-success mt-3" name="action" value="sendReview">Send</button>
</form>

<?php showReviews(); ?>
<h1>Home Page</h1>

<?php 
    Message::show();

    if(isset($_SESSION['user'])):
?>
    <a href="./functions/downloadUsers.php">Download All Users</a>
<?php endif;?>
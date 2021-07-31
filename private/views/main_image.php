<h1>Test page</h1>
<a href="upload">Upload more images</a>
<hr>


<form action="api/get_image" id="image_name">
    <select name="main_image_name">
        <option value="not_existed_image">not existed image</option>
        <?php foreach ($media_list as $media) : ?>
            <option value="<?=$media?>"><?=$media?></option>
        <?php endforeach; ?>
    </select>
    <input type="submit" value="Submit">
</form>

<?php
    if (isset($_GET['main_image_name']) && is_string($_GET['main_image_name'])) {
        $image_name = $_GET['main_image_name'];
    }
?>
<img class="main_image" src="http://localhost/media/<?=$image_name?>" width="200" >
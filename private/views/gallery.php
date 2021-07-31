<h2 style="text-align:center">Lightbox</h2>

<div class="row">
  <?php foreach ($media_list as $key => $media) : ?>
  <div class="column">
    <img src="media/<?= $media ?>" style="width:100%" onclick="openModal();currentSlide(<?= $key + 1; ?>)" class="hover-shadow cursor">
  </div>
  <?php endforeach; ?>
</div>

<div id="myModal" class="modal">
  <span class="close cursor" onclick="closeModal()">&times;</span>
  <div class="modal-content">

  <?php $count = count($media_list);
   foreach ($media_list as $key => $media) : ?>
    <div class="mySlides">
      <div class="numbertext"><?= $key + 1; ?> / <?= $count; ?></div>
      <img src="media/<?= $media ?>" style="width:100%">
    </div>
  <?php endforeach; ?>
    
    <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
    <a class="next" onclick="plusSlides(1)">&#10095;</a>

    <div class="caption-container">
      <p id="caption"></p>
    </div>


    <?php foreach ($media_list as $key => $media) : ?>
      <div class="column">
        <img class="demo cursor" src="media/<?= $media ?>" style="width:100%" onclick="currentSlide(<?= $key + 1; ?>)">
      </div>
    <?php endforeach; ?>
  </div>
</div>

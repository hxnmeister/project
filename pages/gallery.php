<h1>Gallery</h1>

<style>
    .swiper
    {
        width: 800px; 
        height: 400px;
    }
</style>

<div class="swiper">
  <div class="swiper-wrapper">
    <?php 
        $folders = glob('./sliders/*', GLOB_ONLYDIR);

        foreach($folders as $folder):
            $images = glob("$folder/*.{jpg,jpeg,png,gif,webp,avif}", GLOB_BRACE);

            foreach($images as $image):
    ?>
        <div class="swiper-slide">
            <a href="<?= $image?>" data-fancybox data-caption="Single image">
                <img src="<?= $image?>" />
            </a>
        </div>
    <?php 
            endforeach;
        endforeach;
    ?>

    <!-- <div class="swiper-slide"><img src="../uploadedImages/650c74b0aa4fd__raa3uli6rm2emcjf8i62r0iafkpik9o3.png" class="ms-5"></div>
    <div class="swiper-slide">
        <a href="../uploadedImages/650c74b0aa4fd__raa3uli6rm2emcjf8i62r0iafkpik9o3.png" data-fancybox data-caption="Single image">
            <img src="../uploadedImages/650c7b7a9f669__raa3uli6rm2emcjf8i62r0iafkpik9o3.jpg" />
        </a></div>
    <div class="swiper-slide">Slide 3</div> -->
  </div>
  <div class="swiper-pagination"></div>

  <div class="swiper-button-prev"></div>
  <div class="swiper-button-next"></div>

  <div class="swiper-scrollbar"></div>
</div>
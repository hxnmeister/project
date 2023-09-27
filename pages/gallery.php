<h1>Gallery</h1>

<div class="swiper mt-5">
    <div class="swiper-wrapper">
        <?php 
            $folders = glob('./sliders/*', GLOB_ONLYDIR);
            $galleryNumber = 0;

            foreach($folders as $folder):
                $images = glob("$folder/*.{jpg,jpeg,png,gif,webp,avif}", GLOB_BRACE);
                ++$galleryNumber;
        ?>
                <div class="swiper-slide">
                    <?php foreach($images as $image):?>
                        <a href="<?= $image?>" data-fancybox="gallery #<?= $galleryNumber?>">
                            <img src="<?= "$folder/small/".basename($image)?>" />
                        </a>
                    <?php endforeach; ?>
                </div>
        <?php 
            endforeach;
        ?> 
    </div>

    <div class="swiper-button-prev"></div>
    <div class="swiper-button-next"></div>

    <!-- DO NOT DELETE! AFTER REMOVING THE SCROLLBAR, FANCYBOX EFFECTS STOP WORKING! -->
    <div class="swiper-scrollbar"></div>
</div>

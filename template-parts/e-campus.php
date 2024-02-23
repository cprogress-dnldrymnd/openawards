<?php
$staff_room_title = carbon_get_theme_option('staff_room_title');
$staff_room_url = carbon_get_theme_option('staff_room_url');

$learner_centre_title = carbon_get_theme_option('learner_centre_title');
$learner_centre__url = carbon_get_theme_option('learner_centre__url');

$reception_title = carbon_get_theme_option('reception_title');
$reception_url = carbon_get_theme_option('reception_url');

$library_title = carbon_get_theme_option('library_title');
$library_url = carbon_get_theme_option('library_url');

$shop_title = carbon_get_theme_option('shop_title');
$shop_url = carbon_get_theme_option('shop_url');

$newsroom_title = carbon_get_theme_option('newsroom_title');
$newsroom_url = carbon_get_theme_option('newsroom_url');

?>

<section class="e-campus">
    <div class="e-campus-container">
        <img class="road" src="https://openawards.theprogressteam.com/wp-content/uploads/2024/02/road.svg" alt="road">
        <a class="buildings building-1" href="<?= $reception_url ?>">
            <img src="https://openawards.theprogressteam.com/wp-content/uploads/2024/02/reception.svg">
            <div class="text">
                <?= $reception_title ?>
            </div>
        </a>
        <a class="buildings building-2" href="<?= $learner_centre__url ?>">
            <img src="https://openawards.theprogressteam.com/wp-content/uploads/2024/02/learner-centre.svg">
            <div class="text">
                <?= $learner_centre_title ?>
            </div>
        </a>
        <a class="buildings building-3" href="<?= $staff_room_url ?>">
            <img src="https://openawards.theprogressteam.com/wp-content/uploads/2024/02/staff-room.svg">
            <div class="text">
                <?= $staff_room_title ?>
            </div>
        </a>
        <a class="buildings building-4" href="<?= $newsroom_url ?>">
            <img src="https://openawards.theprogressteam.com/wp-content/uploads/2024/02/newsroom.svg">
            <div class="text">
                <?= $newsroom_title ?>
            </div>
        </a>
        <a class="buildings building-5" href="<?= $shop_url ?>">
            <img src="https://openawards.theprogressteam.com/wp-content/uploads/2024/02/shop.svg">
            <div class="text">
                <?= $shop_title ?>
            </div>
        </a>
        <a class="buildings building-6" href="<?= $library_url ?>">
            <img src="https://openawards.theprogressteam.com/wp-content/uploads/2024/02/library.svg">
            <div class="text">
                <?= $library_title ?>
            </div>
        </a>
    </div>
</section>
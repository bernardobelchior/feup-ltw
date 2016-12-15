<?php
include_once('../database/restaurants.php');
include_once('../database/users.php');
include_once('../utils/utils.php');

$id = (int)htmlspecialchars($_GET['id']);

if (!isset($id) || !restaurantIdExists($id)) {
    header('HTTP/1.0 404 Not Found');
    header('Location: index.php?page=404.html');
    die();
}

$_SESSION['token'] = generateRandomToken();
$_SESSION['restaurantId'] = $id;

$restaurantInfo = getRestaurantInfo($id);
$ownerId = $restaurantInfo['OwnerID'];
$name = $restaurantInfo['Name'];
$address = $restaurantInfo['Address'];
$phoneNumber = $restaurantInfo['TelephoneNumber'];
$costForTwo = $restaurantInfo['CostForTwo'];
$description = $restaurantInfo['Description'];
$openingTime = $restaurantInfo['OpeningHour'];
$closingTime = $restaurantInfo['ClosingHour'];
$_SESSION['ownerId'] = $ownerId;
$photos = getRestaurantPhotos($id);
$mainPhoto = $photos[0]['Path'];
unset($restaurantInfo);
?>

<link rel="stylesheet" href="../css/restaurant_profile.min.css">
<script src="../js/restaurant_profile.js"></script>

<div id="restaurant-profile" class="page_content">

    <div id="restaurant-presentation" class="maindiv" style="padding: 1em">
        <?php if (count($photos) > 0) {

            echo '<div class="restaurant-main-picture-container" >
            <img src="../' . $mainPhoto . ' " >
        </div >';
        } ?>
        <div class="restaurant-general ">
            <ul>
                <li id="rest-name"><?= $name ?>
                    <?php
                    if (groupIdHasPermissions((int)$_SESSION['groupId'], 'EDIT_ANY_RESTAURANT') || (int)$_SESSION['userId'] === (int)$ownerId)
                        echo '<a id="edit-restaurant" href="index.php?page=edit_restaurant.php&id=' . $id . '"><button>Edit Restaurant Profile</button></a>';
                    ?>
                </li>
                <li id="rating"><?= getStarsHTML(getRestaurantAverageRating($id)) ?></li>
                <li id="cost-for-2">€ <?= $costForTwo ?> (for two)</li>
                <li id="rest-is-open>">
                    <?php
                    if (isset($openingTime) && isset($closingTime)) {
                        $now = date("H:i");
                        sscanf($now, "%d:%d", $hours, $mins);
                        $time = $hours - 1 + $mins / 60;
                        if (($openingTime < $closingTime && $time >= $openingTime && $time <= $closingTime) || //is open on day hours
                            $openingTime > $closingTime &&                                                    //is open through midnight
                            ($time <= $openingTime && $time <= $closingTime) ||      //is open through midnight
                            $time >= $openingTime || $closingTime == $openingTime
                        )
                            //is open through midnight
                            echo '<span class="open-info">The restaurant is <strong class="open-info">open</strong> now</span>';
                        else
                            echo '<span class="closed-info">The restaurant is <strong class="closed-info">closed</strong> now</span>';
                    }
                    ?>
                </li>
            </ul>
        </div>
    </div>
    <div id="restaurant-information">
        <span id="restaurant-location-phone" class="maindiv">
            <div class="page_title"><strong>Restaurant Information</strong></div>
            <div id="restaurant-location-phone-cont">
                <ul>
                    <li id="rest-addr">
                        <a class="rest-info-title"><strong>Location</strong></a><br>
                        <a style="padding-left: 20px"><?= $address ?></a>
                    </li>
                    <li id="rest-phone-no">
                        <a class="rest-info-title"><strong>Telephone</strong></a><br>
                        <a style="padding-left: 20px"><?= $phoneNumber ?></a>
                    </li>
                </ul>
                <div class="google-map">
                    <iframe id="map" frameborder="0"
                            src="https://www.google.com/maps/embed/v1/place?q=<?= $address ?>&key=AIzaSyCdqMmRf8c1f_yTgtjt7zT_5tdO5UOPka4"
                            allowfullscreen>
                    </iframe>
                </div>
            </div>
        </span>
        <span id="restaurant-desc-categ" class="maindiv">
            <div id="hours">
                <div class="page_title"><strong>Working Hours</strong></div>
                <div id="restaurant-description-cont">
                    <?php if ($openingTime == $closingTime)
                        echo '<a id="rest-hour-cont">Open All Day</a>';
                    else {
                        echo '<a id="rest-hour-cont">From ' . floor($openingTime) . ':' . ($openingTime - floor($openingTime)) * 60 . 'h to ' . floor($closingTime) . ':' . ($closingTime - floor($closingTime)) * 60 . 'h</a>';
                    }
                    ?>
                </div>
            </div>
            <div id="restaurant-description">
                <div class="page_title"><strong>Description</strong></div>
                <div id="restaurant-description-cont">
                    <a id="rest-desc"><?= $description ?></a>
                </div>
            </div>
            <div id="restaurant-categ-div">
                <div class="page_title"><strong>Categories</strong></div>
                <?php
                $categories = getRestaurantCategories($id);

                echo '<ul id="restaurant-categories">';
                foreach ($categories as $category)
                    echo '<li>' . $category['Name'] . '</li>';

                echo '</ul>';
                ?>
            </div>
        </span>
    </div>
    <div class="maindiv" id="photos-div">
        <div class="page_title">Photos</div>
        <div id="restaurant-gallery">
            <?php
            if (count($photos) > 0) {
                echo '<div class="arrow_bg" id="left_arrow_bg">
            <i id="left-arrow" class="fa fa-chevron-left fa-4x" aria-hidden="true"></i>
            </div>';
                foreach ($photos as $photo) {
                    echo '<img class="rest-photo" src ="../' . $photo['Path'] . '">';
                    if ($photo['UploaderID'] === $ownerId)
                        $photoUploader = $name;
                    else
                        $photoUploader = getUserField($photo['UploaderID'], 'Name');
                }


                echo '
            <div class="arrow_bg" id="right_arrow_bg">
            <i id="right-arrow" class="fa fa-chevron-right fa-4x" aria-hidden="true"></i>
            </div>';
            }
            ?>
        </div>
        <?php
        if (count($photos) > 0)
            echo '<div class="photo-label" > Photo added by: ' . $photoUploader . '</div>';
        ?>
    </div>

    <div id="reviews" class="maindiv" style="padding: 1em">
        <div class="page_title"><strong>Restaurant Reviews</strong></div>
        <?php
        $reviews = getAllReviews($id);

        if (sizeof($reviews) > 0) {

            foreach ($reviews as $review) {
                echo '<div id="review' . $review['ID'] . '" class="review-container">';

                echo '<div class="response-header">';
                echo '<div class="review-header-left">';
                echo '<span class="review-title">' . $review['Title'] . ' </span>';
                echo '<span class="review-score">' . getStarsHTML($review['Score']) . ' </span>';
                echo '</div>';

                if ((isset($_SESSION['groupId']) && groupIdHasPermissions($_SESSION['groupId'], 'REMOVE_ANY_REVIEW')) || (isset($_SESSION['userId']) && $review['ReviewerID'] === $_SESSION['userId'])) {
                    echo '<form class="delete-review" action="../actions/delete_review.php" method="post">
                <input type="text" name="token" value="' . $_SESSION['token'] . '" hidden="hidden"/>
                <input type="text" name="review-id" value="' . $review['ID'] . '" hidden="hidden"/>
                <button class="delete-response-button" type="submit"><i class="fa fa-trash-o" aria-hidden="true" ></i></button>
                </form>';
                }
                echo '</div>';
                echo '<a href="index.php?page=profile.php&id=' . $review['ReviewerID'] . '" class="reviewer-name">' . getUserField($review['ReviewerID'], 'Name') . '</a>';
                echo '<span class="review-date"> - ' . strftime('%d/%b/%G %R', $review['Date']) . '</span>';
                echo '<p class="review-comment">' . $review['Comment'] . '</p>';

                $replies = getAllReplies($review['ID']);

                if (count($replies) > 0) {
                    echo '<a href="#review' . $review['ID'] . '" class="toggle-replies">Show replies</a>';

                    foreach ($replies as $reply) {
                        echo '<div class="reply" hidden="hidden">';

                        echo '<div class="response-header">';
                        // If the replier is the owner of the restaurant,
                        // reply in name of the restaurant
                        if ($reply['ReplierID'] === $ownerId)
                            echo '<a href="index.php?page=restaurant_profile.php&id=' . $id . '" class="reply-name replier-restaurant">' . $name . ' </a>';
                        else
                            echo '<a href="index.php?page=profile.php&id=' . $reply['ReplierID'] . '" class="reply-name">' . getUserField($reply['ReplierID'], 'Name') . ' </a>';

                        if ((isset($_SESSION['groupId']) && groupIdHasPermissions($_SESSION['groupId'], 'REMOVE_ANY_REPLY')) || (isset($_SESSION['userId']) && $reply['ReplierID'] === $_SESSION['userId'])) {
                            echo '<form class="delete-review" action="../actions/delete_reply.php" method="post">
                        <input type="text" name="token" value="' . $_SESSION['token'] . '" hidden="hidden"/>
                        <input type="text" name="reply-id" value="' . $reply['ID'] . '" hidden="hidden"/>
                        <button class="delete-response-button" type="submit"><i class="fa fa-trash-o" aria-hidden="true" ></i></button>
                        </form>';
                        }

                        echo '</div>';
                        echo '<div class="reply-date">' . strftime('%d/%b/%G %R', $reply['Date']) . '</div>';
                        echo '<p class="reply-text">' . $reply['Text'] . '</p>';

                        echo '</div>';
                    }
                }
                if ((isset($_SESSION['userId']) && $ownerId === $_SESSION['userId']) || (isset($_SESSION['groupId']) && groupIdHasPermissions($_SESSION['groupId'], 'ADD_REPLY'))) {
                    echo '<form class="add-reply" method="post" action="../actions/add_reply.php">

                <input type="hidden" name="review-id" value="' . $review['ID'] . '">
                <input type="hidden" name="token" value="' . $_SESSION['token'] . '">
                <textarea name="reply" placeholder="Reply" rows="3"></textarea>
                <button type="submit">Reply</button>

                </form>';
                }
                echo '</div>';
            }
        } else {
            echo '<span>No reviews yet :(</span>';
        }
        if (isset($_SESSION['groupId']) && groupIdHasPermissions($_SESSION['groupId'], 'ADD_REVIEW')) {
            if ((isset($_SESSION['userId']) && $ownerId !== $_SESSION['userId']) ||
                (isset($_SESSION['groupId']) && groupIdHasPermissions($_SESSION['groupId'], 'ADD_REVIEW_TO_OWN_RESTAURANT'))
            ) {
                echo '<form id="add-review" action="../actions/add_review.php" method="post">
        <input type="hidden" name="token" value="' . $_SESSION['token'] . '">
        <input id="review-title" type="text" name="title" placeholder="Title" required>
        <input id="review-score" type="number" min="1" max="5" name="score" placeholder="Score" required>
        <span id="review-stars" hidden="hidden">' . getStarsHTML(0) . '</span>
        <textarea id="review-comment" name="comment" placeholder="Comment(optional)" rows="4" cols="50"></textarea>
        <button type="submit">Send review</button>
    </form>';
            }
        }

        if (isset($_SESSION['userId']))
            echo '<div id="user-photos">Add your photos:</div>
    <form id="photos-form" method="post" action="../actions/upload_restaurant_photo.php"
    enctype="multipart/form-data">
    <input type="hidden" id="token" name="token" value="' . $_SESSION['token'] . '"/>
    <input type="hidden" id="restaurant_id" name="restaurant_id" value="' . $id . '"/>
    <input name="photos[]" type="file" multiple="multiple"/>
    <button class="upload_photos" type="submit">Submit</button>
  </form>';
        ?>

    </div>
</div>

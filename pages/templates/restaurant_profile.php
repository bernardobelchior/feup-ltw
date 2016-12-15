<?php
include_once('../database/restaurants.php');
include_once('../database/users.php');
include_once('../utils.php');

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
unset($restaurantInfo);
?>

<link rel="stylesheet" href="../css/common.min.css">
<link rel="stylesheet" href="../css/restaurant_profile.min.css">
<script src="../js/restaurant_profile.js"></script>

<div id="restaurant-profile" class="container">
    <div id="restaurant-profile-header">
        <div id="restaurant-info">
            <div id="restaurant-header">
                <span id="restaurant-name"><?= $name ?></span>
                <span id="average">
                <?= getStarsHTML(getRestaurantAverageRating($id)) ?>
            </span>
            </div>

            <div id="restaurant-cost-for-two">
                Cost for two: <?= $costForTwo ?>€
            </div>

            <div id="restaurant-phone-number">
                Phone number: <?= $phoneNumber ?>
            </div>

            <?php
            if(isset($openingTime) && isset($closingTime)){
              $now = date("H:i");
              sscanf($now, "%d:%d", $hours, $mins);
              $time = $hours-1 + $mins/60;
              if($openingTime < $closingTime && $time > $openingTime && $time < $closingTime || //is open on day hours
              $openingTime > $closingTime &&                                                    //is open through midnight
                                          ($time < $openingTime && $time < $closingTime ||      //is open through midnight
                                           $time > $openingTime))                               //is open through midnight
                echo '<span class="open-info">The restaurant is open now</span>';
              else
                echo '<span class="closed-info">The restaurant is closed now</span>';
            }
            ?>

            <?php
            $categories = getRestaurantCategories($id);

            echo '<ul id="restaurant-categories">';
            foreach ($categories as $category)
                echo '<li>' . $category['Name'] . '</li>';

            echo '</ul>';
            ?>

            <p id="restaurant-description">
                <?= $description ?>
            </p>
        </div>

        <div id="restaurant-gallery">
            <?php
            $photos = getRestaurantPhotos($id);

            if (count($photos) > 0) {
                echo '<i id="left-arrow" class="fa fa-chevron-left fa-4x" aria-hidden="true"></i>
            <div>';

                foreach ($photos as $photo) {
                    echo '<img class="photo" src="' . '../' . $photo['Path'] . '" alt="Restaurant photo"></img>';
                }

                echo '</div>
            <i id="right-arrow" class="fa fa-chevron-right fa-4x" aria-hidden="true"></i>';
            }
            ?>

            <!-- <div id="upload"> -->
          <!-- </div> -->
        </div>
    </div>
    <?php if(isset($_SESSION['userId']))
    echo '<span>Add your photos:</span>
    <form id="photos-form" method="post" action="../actions/upload_restaurant_photo.php"
    enctype="multipart/form-data">
    <input type="hidden" id="token" name="token" value="' . $_SESSION['token'] . '"/>
    <input type="hidden" id="restaurant_id" name="restaurant_id" value="' . $id . '"/>
    <input name="photos[]" type="file" multiple="multiple"/>
    <button class="upload_photos" type="submit">Submit</button>
  </form>';
  ?>
    <?php
    if (groupIdHasPermissions((int)$_SESSION['groupId'], 'EDIT_ANY_RESTAURANT') || (int)$_SESSION['userId'] === (int)$ownerId)
        echo '<a id="edit-restaurant" href="index.php?page=edit_restaurant.php&id=' . $id . '"><span>Edit Profile</span></a>';
    ?>

    <iframe id="map" frameborder="0"
            src="https://www.google.com/maps/embed/v1/place?q=<?= $address ?>&key=AIzaSyCdqMmRf8c1f_yTgtjt7zT_5tdO5UOPka4"
            allowfullscreen></iframe>

</div>

<div id="reviews" class="container">
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

    ?>

</div>

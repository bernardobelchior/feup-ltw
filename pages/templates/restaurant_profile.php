<?php
include_once('../database/restaurants.php');
include_once('../database/users.php');
include_once('utils/utils.php');

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
$description = $restaurantInfo['Description'];
$_SESSION['ownerId'] = $ownerId;
unset($restaurantInfo);
?>

<link rel="stylesheet" href="../css/common.min.css">
<link rel="stylesheet" href="../css/restaurant_profile.min.css">
<script src="../js/restaurant_profile.js"></script>

<div id="restaurant-profile" class="container">
    <!-- photo -->
    <div id="restaurant-info">
        <div id="restaurant-header">
            <span id="restaurant-name"><?php echo $name; ?></span>
            <span id="average">
                <?php echo getStarsHTML(getRestaurantAverageRating($id)); ?>
            </span>
        </div>

        <div id="restaurant-address">
            <?php echo $address; ?>
        </div>

        <p id="restaurant-description">
            <?php echo $description; ?>
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

    </div>
</div>

<div id="reviews" class="container">
    <?php
    $reviews = getAllReviews($id);

    if (sizeof($reviews) > 0) {

        foreach ($reviews as $review) {
            echo '<div id="review' . $review['ID'] . '" class="review-container">';

            echo '<span class="review-title">' . $review['Title'] . ' </span>';
            echo '<span class="review-score">' . getStarsHTML($review['Score']) . ' </span><br/>';
            echo '<span class="reviewer-name">' . getUserField($review['ReviewerID'], 'Name') . '</span>';
            echo '<span class="review-date"> - ' . strftime('%d/%b/%G %R', $review['Date']) . '</span>';
            echo '<p class="review-comment">' . $review['Comment'] . '</p>';

            $replies = getAllReplies($review['ID']);

            if (count($replies) > 0) {
                echo '<a href="#review' . $review['ID'] . '" class="toggle-replies">Show replies</a>';

                foreach ($replies as $reply) {
                    echo '<div class="reply" hidden="hidden">';

                    echo '<div class="reply-name">' . getUserField($reply['ReplierID'], 'Name') . ' </div>';
                    echo '<div class="reply-date">' . strftime('%d/%b/%G %R', $reply['Date']) . '</div>';
                    echo '<p class="reply-text">' . $reply['Text'] . '</p>';

                    echo '</div>';
                }
            }


            if ($ownerId === $_SESSION['userId'] || groupIdHasPermissions($_SESSION['groupId'], 'ADD_REPLY')) {
                echo '<form class="add-reply" method="post" action="actions/add_reply.php">

                <input type="hidden" name="review-id" value="' . $review['ID'] . '">
                <input type="hidden" name="token" value="' . $_SESSION['token'] . '">
                <textarea name="reply" placeholder="Reply" rows="2"></textarea>
                <button type="submit">Reply</button>
                
                </form>';
            }

            echo '</div>';
        }

    } else {
        echo '<span>No reviews yet :(</span>';
    }

    if (groupIdHasPermissions($_SESSION['groupId'], 'ADD_REVIEW')) {
        if ($ownerId !== $_SESSION['userId'] ||
            groupIdHasPermissions($_SESSION['groupId'], 'ADD_REVIEW_TO_OWN_RESTAURANT')
        ) {
            echo '<form id="add-review" action="actions/add_review.php" method="post">
        <input type="hidden" name="token" value="' . $_SESSION['token'] . '">
        <input type="text" name="title" placeholder="Title">
        <input type="number" name="score" min="1" max="5" required>
        <textarea name="comment" placeholder="Comment(optional)"></textarea>
        <button type="submit">Submit</button>
    </form>';
        }
    }

    ?>

</div>

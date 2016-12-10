<?php
include_once('../database/restaurants.php');
include_once('../database/users.php');
include_once('utils/utils.php');

$id = (int)htmlspecialchars($_GET['id']);

if (!isset($id) || !restaurantIdExists($id)) {
    header('HTTP/1.0 404 Not Found');
    header('Location: 404.php');
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

<script type="text/javascript" src="../js/edit_restaurant.js"></script>

<div id="restaurant-profile" class="container">
  <input type="hidden" id="token" name="token" value="<?php echo $_SESSION['token']; ?>"/>
  <input type="hidden" id="restaurant_id" name="restaurant_id" value="<?php echo $id; ?>"/>
    <ul id="profile_attr_list">
      <li id="name">
          <span class="list_attr_name"><strong>Name</strong></span>
          <span class="list_attr_content"><?php echo $name; ?></span>
          <span class="edit_link">Edit</span>
      </li>
      <li id="address">
          <span class="list_attr_name"><strong>Address</strong></span>
          <span class="list_attr_content"><?php echo $address; ?></span>
          <span class="edit_link">Edit</span>
      </li>
      <li id="description">
          <span class="list_attr_name"><strong>Description</strong></span>
          <span class="list_attr_content"><?php echo $description; ?></span>
          <span class="edit_link">Edit</span>
      </li>
    </ul>
    <!-- photo -->
</div>

<div id="reviews" class="container">
    <?php
    $reviews = getAllReviews($id);

    if (sizeof($reviews) > 0) {

        foreach ($reviews as $review) {
            echo '<div class="review-container">';

            echo '<span>' . $review['Title'] . ' </span>';
            echo '<span>' . $review['Score'] . ' </span>';
            echo '<span>' . getUserField($review['ReviewerID'], 'Name') . '</span>';
            echo '<div>' . strftime('%d/%b/%G %R', $review['Date']) . '</div>';
            echo '<p>' . $review['Comment'] . '</p>';

            $replies = getAllReplies($review['ID']);

            foreach ($replies as $reply) {
                echo '<div class="container">';

                echo '<span>' . getUserField($reply['ReplierID'], 'Name') . ' </span>';
                echo '<span>' . strftime('%d/%b/%G %R', $reply['Date']) . '</span>';
                echo '<p>' . $reply['Text'] . '</p>';

                echo '</div>';
            }

            if ($ownerId === $_SESSION['userId'] || groupIdHasPermissions($_SESSION['groupId'], 'ADD_REPLY')) {
                echo '<form method="post" action="actions/add_reply.php">

                <input type="hidden" name="review-id" value="' . $review['ID'] . '">
                <input type="hidden" name="token" value="' . $_SESSION['token'] . '">
                <textarea name="reply" placeholder="Reply"></textarea>
                <button type="submit">Reply</button>

                </form>';
            }

            echo '</div>';
        }

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

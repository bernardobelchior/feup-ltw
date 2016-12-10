$(document).ready(function () {
    // Gallery
    $('#restaurant-gallery img:not(:first)').hide();

    $('#right-arrow').on('click', nextImage);
    $('#left-arrow').on('click', previousImage);

    // Show and hide replies
    $('.toggle-replies').off('click').on('click', toggleReplies);

    // Review stars
    $('#review-score').hide();
    $('#review-stars').show();

    $('#review-stars .star').on('mouseenter', hoverStar).on('click', clickStar);
    $('#review-stars').on('mouseleave', clearStars);
});

function nextImage() {
    let currentImage = $('#restaurant-gallery img:not(:hidden):first');
    currentImage.hide();

    let next = currentImage.next('img');

    if (next.length === 0)
        next = currentImage.siblings().first();

    next.show();
}

function previousImage() {
    let currentImage = $('#restaurant-gallery img:not(:hidden):first');
    currentImage.hide();

    let prev = currentImage.prev('img');

    if (prev.length === 0)
        prev = currentImage.siblings().last();

    prev.show();
}

function toggleReplies(event) {
    // Don't let the anchor tag move to the selected id.
    event.preventDefault();

    let anchor = $(this);
    let review = $(anchor.attr('href'));

    review.children().siblings('.reply').toggle();
    if (anchor.text() === 'Hide replies')
        anchor.text('Show replies');
    else
        anchor.text('Hide replies');
}

function hoverStar() {
    let currentStar = $(this);

    currentStar.nextAll().removeClass('fa-star').addClass('fa-star-o');
    currentStar.removeClass('fa-star-o').addClass('fa-star');
    currentStar.prevAll().removeClass('fa-star-o').addClass('fa-star');
}

function clearStars() {
    $(this).children().siblings().removeClass('fa-star').addClass('fa-star-o');
}

function clickStar() {
    //Update the stars showing
    hoverStar.call(this);

    $('#review-score').attr('value', $(this).prevAll().length + 1);

    $(this).off('mouseenter').parent().off('mouseleave');
    $(this).siblings().off('mouseenter');
}

function validateForm() {
   return true;
}

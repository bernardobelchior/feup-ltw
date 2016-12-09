$(document).ready(function () {
    $('#restaurant-gallery img:not(:first)').hide();

    $('#right-arrow').on('click', nextImage);
    $('#left-arrow').on('click', previousImage);


    $('.toggle-replies').off('click').on('click', toggleReplies);
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
    if(anchor.text() === 'Hide replies')
        anchor.text('Show replies');
    else
        anchor.text('Hide replies');
}

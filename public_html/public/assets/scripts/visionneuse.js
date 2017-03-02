$(document).ready(function() {
    $('.photos_projet').magnificPopup({
        delegate: 'a',
        type: 'image',
        tLoading: 'Loading image #%curr%...',
        mainClass: 'mfp-fade',
        gallery: {
            enabled: true,
            navigateByImgClick: true,
            preload: [0,1] // Will preload 0 - before current, and 1 after the current image
        },
        image: {
            tError: '<a href="%url%">L\'image #%curr%</a> n\'a pu être chargée.',
            titleSrc: function(item) {
                return item.el.attr('title');
            }
        }
    });
});
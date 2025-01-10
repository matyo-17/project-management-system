var loader = $("#loader");
function hideLoader() {
    setTimeout(function () {
        loader.css({"opacity": 0, "display": "none"});
    }, 500);
}

function showLoader() {
    loader.css({"opacity": 0.9, "display": "flex"});
}

$(window).on('load', function () {
    hideLoader();
});
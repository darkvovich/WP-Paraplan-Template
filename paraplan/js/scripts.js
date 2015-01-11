var windowHeight = $(window).innerHeight();
var scrl_top = window.chrome ? "body": "html";

var wait = 1;
if (navigator.platform.match(/(Mac|iPhone|iPod|iPad)/i)) {
    wait = 1000;
}

// contact form
function formSended(new_slogan) {
    var slogan = $('#contacts h3'),
        current_slogan = slogan.text();
    // clear form
    $('#contacts .wpcf7-form')[0].reset();
    // mess
    slogan.hide().html('<span class="green">' + new_slogan + '</span>').fadeIn();
    setTimeout(function() { slogan.hide().text(current_slogan).fadeIn(); }, 5000);
}

// exec
$(document).ready(function() {
    $('.nojs').removeClass('nojs');
});

$(document).ready(function() {
    var showChar = 200;
    var ellipsestext = "...";
    $('.more').each(function() {
        var content = $(this).html();

        if(content.length > showChar) {
            var c = content.substr(0, showChar);
            var h = content.substr(showChar-1, content.length - showChar);
            var html = c + '<span class="moreellipses">' + ellipsestext+ '&nbsp;</span>';
            $(this).html(html);
        }
    });
});

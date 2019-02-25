/**
 * Home page content
 * */
$(function () {
    var last_news = $('#ajax_last_news');
    var last_forums = $('#ajax_last_forums');
    var top_forums = $('#ajax_top_forums');
    getLastNews(last_news);
    getLastNews(last_forums);
    getLastNews(top_forums);
});
function getLastNews(container) {
    $.get(container.attr('data-path'), {}, function (html) {
        container.html(html);
        $('.load-wrapp').hide();
    });
}


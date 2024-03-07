
// functions.js

$(document).ready(function () {
    var includes = $('[data-include]');
    $.each(includes, function () {
        var file = '/components/' + $(this).data('include') + '.html';
        $(this).load(file);
    });
});

function toggleNavbarMenu() {
    const offcanvasNavbar = new bootstrap.Offcanvas(document.getElementById('offcanvasNavbar'));
    offcanvasNavbar.toggle();
}
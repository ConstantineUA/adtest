$(function () {
    $('.js-delete-button').on('click', function (e) {
        if (window.confirm('Are you sure you want to delete this banner?')) {
            window.location.href = $(e.target).attr('href');
        }

        return false;
    });
});
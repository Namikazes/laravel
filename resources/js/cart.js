import "./app.js"

$(document).on('change', '.counter', function (event) {
    event.preventDefault();
    $(this).parents('form').submit();
})

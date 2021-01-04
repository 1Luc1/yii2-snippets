$(function() {
    // start tour if tour help is clicked
    $(document).on('click', '#tourHelp', function() {
        tour.restart();
    });
});
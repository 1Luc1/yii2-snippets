$(function () {
    // about the warning of the brwoser caus of synchronious calls 
    // -> http://stackoverflow.com/questions/28322636/synchronous-xmlhttprequest-warning
    // -> https://github.com/jquery/jquery/issues/1895

    $(document).on('click', '.showModalButton', function () {
        // reset content before show
        $('#modal').find('#modalContent').html("<div style='text-align:center'><img src='/image/ajax-loader.gif'></div>");
        //if modal isn't open; open it and load content
        $('#modal').on('hidden.bs.modal', function () { }).modal('show')
                .find('#modalContent')
                .load($(this).attr('value'), function () {
                    // show the popover within a modal window after everything is loaded
                    $('[data-toggle="popover"]').popover();
                });

        //dynamiclly set the header for the modal
        //document.getElementById('headerTitle').innerHTML = $(this).attr('header') ? $(this).attr('header') : $(this).attr('title');
        $("#headerTitle").html($(this).attr('header') ? $(this).attr('header') : $(this).attr('title'));
    });

    // show popover in whole application
    $('[data-toggle="popover"]').popover();
    
    $('#sidebarCollapse').on('click', function () {
        $('#sidebar, #content').toggleClass('active');
    });
});






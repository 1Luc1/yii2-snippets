function startBackup() {
    window.onbeforeunload = function () {
        return 'Please save';
    };

    // prevent modal to close on click outside
    $('#modal').on('hide.bs.modal', function (e) {
        e.preventDefault();
    });

    $('#options-panel').hide();
    $('#progBar').show();
    $('#info-panel').slideDown('fast');

    ajaxRequest = $.ajax({
        async: true,
        type: "post",
        dataType: 'json',
        url: $("#progress-btn").attr("data-nexturl"),
        data: null
    });

    addRow($("#progress-btn").attr("data-nextlabel"));
    ajaxRequest.done(backupCallback);
}

function backupCallback(response) {
    if (!response.hasOwnProperty('success')) {
        endBackup();
    } else if (response.success) {
        addStatus(((response.success === 'skipped') ? $("#app").attr("data-skipped") : $("#app").attr("data-done")) + "<br>");
        // to set the progressbar width dynamicly a hack has to be used; only works with inline style
        $('.progress-bar').css("width", parseInt($('.progress-bar')[0].style.width) + 20 + "%");
        ajaxRequest = $.ajax({
            async: true,
            type: "post",
            dataType: 'json',
            url: response.nextUrl,
            data: {inclPic: $('#backpic').bootstrapSwitch('state'), filename: response.filename}
        });
        addRow(response.nextLabel);
        ajaxRequest.done(backupCallback);
        ajaxRequest.fail(function (response) {
            callEnd(response);
        });

    } else if (!response.success) {
        callEnd(response);
    }
}

function callEnd(response) {
    endBackup(true);
    $('#error-panel').slideDown('fast');
    $('#detail-error').append(response.errorMsg);
}

function endBackup(failed) {
    failed = failed === undefined ? false : failed;
    addStatus(failed ? $("#app").attr("data-failed") : $("#app").attr("data-done"));
    if (!failed) {
        $('.progress-bar').css("width", '100%');
    }
    barClass = failed ? "progress-bar-danger" : "progress-bar-success";
    $('.progress-bar').toggleClass("progress-bar-info " + barClass);
    window.onbeforeunload = null;
    $('#modal').off('hide.bs.modal');
}

function addRow(label) {
    $('#info-body').append($('#info-row').clone().removeAttr('id'));
    $('#info-body').children().last().children().first().append(label);
}

function addStatus(status) {
    $('#info-body').children().last().children().last().append(status);
}
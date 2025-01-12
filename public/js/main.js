function loading(status) {
    let loader = $("#loader");
    if (status) {
        loader.css({"opacity": 0.7, "display": "flex"});
    } else {
        setTimeout(function () { loader.css({"opacity": 0, "display": "none"}); }, 500);
    }
}

function toast(type, title, message) {
    toast_item = $('#toast');
    toast_item.removeClass("text-bg-success text-bg-danger")
                .addClass("text-bg-" + type);

    $('#toast-title').html(title);
    $('#toast-message').html(message);

    toast_item.toast({
        animation: true, 
        autohide: true,
        delay: 2000
    });
    toast_item.toast("show");
}

var doubleConfirm = function (action, callback) {
    $("#confirm-action").html(action);
    $("#double-confirm").modal('show');

    $("#confirm-yes").on("click", function() {
        $("#double-confirm").modal('hide');
        callback();
    });

    $("#confirm-no").on("click", function() {
        $("#double-confirm").modal('hide');
    });
}

function formToObject(formId) {
    var formObject = {};
    var formArray = $("#"+formId).serializeArray();

    for (let i=0; i<formArray.length; i++) {
        key = formArray[i]['name'].replace('-', '_');
        value = formArray[i]['value'];

        if (key.includes("[]")) {
            if (formObject[key] === undefined) {
                formObject[key] = [];
            }
            formObject[key].push(value);
        } else {
            formObject[key] = value;
        }
    }
    return formObject;
}

$(window).on('load', function () {
    loading(false);

    $.ajaxSetup({
        headers: ajaxHeaders,
        beforeSend: function(xhr, settings) {
            loading(true);
        },
        success: function(result, status, xhr) {
            loading(false);
        },
        error: function(xhr, status, error) {
            loading(false);
        },
        complete: function(xhr, status) {
            loading(false);
            if (xhr.responseJSON?._token) {
                $('[name*="_token"]').val(xhr.responseJSON?._token);
            }
        }
    });

    $(".select2").select2( {
        theme: "bootstrap-5",
        width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
        placeholder: $(this).data('placeholder'),
        closeOnSelect: true,
    } );
});
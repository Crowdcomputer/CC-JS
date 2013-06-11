//GET url pars
console.log("croco4cc");
function gup(name) {
    var regexS = "[\\?&]" + name + "=([^&#]*)";
    var regex = new RegExp(regexS);
    var tmpURL = window.location.href;
    var results = regex.exec(tmpURL);
    if (results == null) return null;
    return results[1];
}

//
// This method decodes the query parameters that were URL-encoded
//

function decode(strToDecode) {
    var encoded = strToDecode;
    if (encoded == null) return "";
    return unescape(encoded.replace(/\+/g, " "));
}




$(document).ready(

function() {

$("form input[type=submit]").attr("value", "Submit to CC and Requester");
    // this should automatically find the form.
    $("form input[type=submit]").click(

    function() {
        $("form input[type=submit]").prop("disabled", true);
        $("form input[type=submit]").attr("value", "Sending data, please wait");
        // extract original action
        var action = $("form").attr("action");

        // do an asyn post to original page with all the form data to the
        // original URL.
        $.ajax({
            type: 'POST',
            url: action,
            data: $("form").serialize(),
            success: function(data) {
                $.each($.parseJSON(data), function(i, el) {
                    var input = $('<input/>').attr({
                        type: 'hidden',
                        id: el.id,
                        name: el.id,
                        value: el.value,
                        "class": "croco"
                    });
                    $("form").append(input);
                });
            },
            async: false
        });

        // send to croco
        var csrftoken = "'" + gup("csrf") + "'";

        var fields = $('form input:not(.croco)');
        fields.prop("disabled", true);

        var task_instance_uuid = gup('uuid');
        console.log(task_instance_uuid);
        var url = decode(gup('ccl')) + '/mt/taskinstance/' + task_instance_uuid + '/finish/';
        console.log(url);
        console.log($("form").serialize());
        // send to croco.
        $("form").submit();
    });
});
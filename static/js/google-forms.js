$(document).ready(function(){
    
    //Depending on the parameter 'mode'
    if (email_row_mode==0) //hide the field
        $('.ss-form-entry:eq(0)').children('input').parent().parent().parent().hide();
    if (email_row_mode==1) //make the field readonly
        $('.ss-form-entry:eq(0)').children('input').attr('readonly','readonly');
    //else if mode>1 then field is visible
    
    $('.ss-terms').hide();
    var powered='<div class="powered-by-logo"><span class="powered-by-text">Powered by</span>\n\
<strong><a class="ss-logo-link" href="http://docs.google.com">Google Drive</a> | \n\
<a class="ss-logo-link" href="http://survey.eu01.aws.af.cm/">SurveyManager</a> | \n\
<a class="ss-logo-link" href="http://cm.eu01.aws.af.cm/">CrowdComputer</a></strong></div>';
    $('.disclaimer').empty().append(powered);
    $('[type=submit]').val('Save');
    $.receiveMessage(function(e) {
        $('.ss-form-entry:eq(0)').children('input').val(e.data);
        //console.log('data from crowd machine: '+e.data);
    });
});
    
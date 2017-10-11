$(document).ready(function(){
    getUserTimezone();
    function getUserTimezone() {
    var timezoneName = Intl.DateTimeFormat().resolvedOptions().timeZone; 
    $('#timezone').val(timezoneName);
}
});
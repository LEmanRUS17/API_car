$(document).ready(function() {
    var disabled = false;
    $('#butSpecification').click(function() {
        if (disabled) {
            $("#specification").prop('disabled', false);       // if disabled, enable
        }
        else {
            $("#specification").prop('disabled', true);        // if enabled, disable
        }
        disabled = !disabled;
    })
});
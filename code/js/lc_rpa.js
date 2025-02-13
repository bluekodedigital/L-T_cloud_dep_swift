function validate_lcvalue(value, venid) {
    var lcbv = $('#lc_balance').val();
    if (value > lcbv) {
//        alert('Enter LC value exceeds LC Balance Value');
        $('#error').html('Entered LC value exceeds LC Balance Value');
        $('#lc_value').val('');
    } else if (value === '' || value === '0') {
        $('#error').html('Entered LC value should not be empty or Zero');
        $('#lc_value').val('');
    }
}


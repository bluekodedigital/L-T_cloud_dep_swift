function changelc(lcid, page) {
//    swal(lcid);
    $.post("code/changelc.php", {key: lcid}, function (data) {
        var lcm_venid = JSON.parse(data).lcm_venid;
        var lcm_num = JSON.parse(data).lcm_num;
        var lcm_value = JSON.parse(data).lcm_value;
        var lcm_balance = JSON.parse(data).lcm_balance;
        var lcm_date = JSON.parse(data).lcm_date;
        var lcm_from = JSON.parse(data).lcm_from;
        var lcm_to = JSON.parse(data).lcm_to;
        var lcm_cpid = JSON.parse(data).lcm_cpid;
        var lcm_appname = JSON.parse(data).lcm_appname;
        var lcm_appbank = JSON.parse(data).lcm_appbank;
        var lcm_venbank = JSON.parse(data).lcm_venbank;
        var lcm_venbankaddress = JSON.parse(data).lcm_venbankaddress;
        var lcm_currency = JSON.parse(data).lcm_currency;
        var lcm_forex = JSON.parse(data).lcm_forex;
        var lcm_valueinr = JSON.parse(data).lcm_valueinr;
        var lcm_incoterm = JSON.parse(data).lcm_incoterms;
        var lcm_country = JSON.parse(data).lcm_country;
        var poval = JSON.parse(data).poval;



        $('#vendor').val(lcm_venid);
        $('#lc_num').val(lcm_num);
        $('#lc_date').val(lcm_date);
        $('#from_lc').val(lcm_from);
        $('#to_lc').val(lcm_to);
        $('#lc_value').val(lcm_value);
        $('#lcid').val(lcid);
        $('#lcm_cpid').val(lcm_cpid);
        $('#applicant').val(lcm_appname);
        $('#app_bank').val(lcm_appbank);
        $('#app_address').val(lcm_appbank);
        $('#bf_bank').val(lcm_venbank);
        $('#bf_bank_address').val(lcm_venbankaddress);
        $('#currency').val(lcm_currency);
        $('#forex').val(lcm_forex);
        $('#inr_val').val(lcm_valueinr);
        $('#inco_terms').val(lcm_incoterm);
        $('#country').val(lcm_country);
        $('#total_poVal').val(poval);
        $('#lcmst_update').show();
        $('#lcmst_create').hide();
        if (page == 1) {
            $('#vendor option:not(:selected)').attr('disabled', true);
            $('#lcm_cpid option:not(:selected)').attr('disabled', true);
            $('#app_bank option:not(:selected)').attr('disabled', true);
        }





    });
}
function fetch_vendorcode(ven_id) {
    $.post("code/fetch_vendorcode.php", {key: ven_id}, function (data) {
        $('#rpa_num').val(data);
    });
}
function changerpa(lcid) {
//    swal(lcid);
    $.post("code/changerpa.php", {key: lcid}, function (data) {
        var lcm_venid = JSON.parse(data).lcm_venid;
        var lcm_num = JSON.parse(data).lcm_num;
        var rpa_bank = JSON.parse(data).rpa_bank;

        var lcm_date = JSON.parse(data).lcm_date;
        var lcm_from = JSON.parse(data).lcm_from;
        var lcm_to = JSON.parse(data).lcm_to;
        $('#vendor').val(lcm_venid);
        $('#rpa_num').val(lcm_num);
        $('#rpa_date').val(lcm_date);
        $('#from_rpa').val(lcm_from);
        $('#to_rpa').val(lcm_to);
        $('#bank_name').val(rpa_bank);
        $('#rpaid').val(lcid);
        $('#rpamst_update').show();
        $('#rpamst_create').hide();

    });
}

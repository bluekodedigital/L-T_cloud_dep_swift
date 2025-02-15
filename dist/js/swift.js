function swift_upload(packid,projid) {
    var fname = $('#ppo_attach').val();
    var ponum = $('#apo_num').val();
    // alert(projid);
    //alert(ponum);
    $('.fa-cloud-upload').html('<img src="../images/loading.gif" >');
    if (ponum == "") {
        alert('Please Fill Po Number');
        $('.fa-cloud-upload').html('');
    } else if (fname == '') {
        alert('Please Upload CSV File & Proceed');
        $('.fa-cloud-upload').html('');
    } else {

        var formData = new FormData();
        formData.append('file', $('#ppo_attach')[0].files[0]);
        formData.append('packid', packid);
        formData.append('projid', projid);
        formData.append('ponum', ponum);
        $.ajax({
            url: 'assets/swift_upload.php',
            type: 'POST',
            data: formData,
            processData: false, // tell jQuery not to process the data
            contentType: false, // tell jQuery not to set contentType
            success: function (data) {
                if ($.trim(data) === '0') {
                    alert('Empty Filed Detected in ItemCode field in CSV');
                    $('.fa-cloud-upload').html('');
                } else if ($.trim(data) === '1') {
                    alert('Empty Filed Detected in Description field in CSV');
                    $('.fa-cloud-upload').html('');
                } else if ($.trim(data) === '2') {
                    alert('Empty Filed Detected in Qty field in CSV');
                    $('.fa-cloud-upload').html('');
                } else if ($.trim(data) === '3') {
                    alert('Empty Filed Detected in Rate field in CSV');
                    $('.fa-cloud-upload').html('');
                } else if ($.trim(data) === 'Error') {
                    alert('Upload Error');
                    $('.fa-cloud-upload').html('');
                } else {
                    alert('Upload Success');
                    $('#apo_val').val(data);
                    //swift_entrybyuser(val, name, qid)
                    $('.fa-cloud-upload').html('');
                }
            }
        });
    }
}
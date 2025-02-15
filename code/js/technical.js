// function readmore() {
//     $('#moreew').show();
//     $('#rless').show();
//     $('#less').hide();
//     $('#rmore').hide();
// }
// function readless() {
//     $('#moreew').hide();
//     $('#rless').hide();
//     $('#less').show();
//     $('#rmore').show();

// }
function readmore(id) {
    $('#moreew' + id).show();
    $('#rless' + id).show();
    $('#less' + id).hide();
    $('#rmore' + id).hide();
}

function readless(id) {
    $('#moreew' + id).hide();
    $('#rless' + id).hide();
    $('#less' + id).show();
    $('#rmore' + id).show();
}
function save_expected(pack_id, stage_id) {
    var exp_date = $('#dasexpected_date' + pack_id).val();
    $.post("code/save_expected.php", {key: pack_id, stage_id: stage_id, exp_date: exp_date}, function (data) {
        swal("Updated Successfully");
    });

}
function expert_filesuplod(expert) {

    if (expert === "expert") {
        expert = 1;
    } else {
        expert = 0;
    }
    var pack_id = $('#packageid').val();
    var projid = $('#projectid').val();
    var doc_name = $('#doc_name').val();
    var file_name = $('#inputGroupFile01').val();
    var file_data = $('#inputGroupFile01').prop('files')[0];
//    var doc_id = $('#doc_name_1').val();
  // alert(doc_name);


    if (doc_name == "") {
        swal('Please fill doc Name');
    } else if (file_name == "") {
        swal('Please Choose file');
    } else {
        $('#progress-wrp').show();
        var form_data = new FormData();
        form_data.append('file', file_data);
        form_data.append('projid', projid);
        form_data.append('pack_id', pack_id);
        form_data.append('doc_name', doc_name);
//        form_data.append('doc_id', doc_id);
        $.ajax({
            xhr: function () {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function (evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = ((evt.loaded / evt.total) * 100);

                        $(".progress-bar").css("width", +percentComplete.toFixed(2) + "%");
                        $(".status").text(percentComplete.toFixed(2) + "%");
//                        $(".progress-bar").width(percentComplete + '%');
//                        $(".progress-bar").html(percentComplete + '%');
                    }
                }, false);
                return xhr;
            },           
            url: 'code/exp_filesupload.php', // point to server-side PHP script 
            dataType: 'text', // what to expect back from the PHP script, if anything
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            beforeSend: function () {
                $(".progress-bar").css("width", "0%");
                $(".status").text("0%");
//                $(".progress-bar").width('0%');
//                $('#uploadStatus').html('<img src="images/loading.gif"/>');
            },
            error: function () {
                $('#output').html('<p style="color:#EA4335;">File upload failed, please try again.</p>');
            },
            success: function (php_script_response) {
                swal(php_script_response);
                if ($.trim(php_script_response) === "success") {
                    if (expert == 0) {
                        fetch_exp_uploaddocument(projid, pack_id);
                    } else if (expert == 1) {
                        fetch_exp_uploaddocument1(projid, pack_id, expert);
                    }

                }
                $('#progress-wrp').hide();
            }
        });
    }
}
function fetch_exp_uploaddocument(projid, pack_id) {
    $('#uptable').html('<img src="images/loading.gif" alt=""/>');
    $.post("code/fetch_exp_uploaddocument.php", {key: pack_id, proj_id: projid}, function (data) {
        $('#exp_uptable').html(data);

    });
}
function fetch_exp_uploaddocument1(projid, pack_id, expert) {
    $('#uptable').html('<img src="images/loading.gif" alt=""/>');
    $.post("code/fetch_exp_uploaddocument.php", {key: pack_id, proj_id: projid, expert: expert}, function (data) {
        $('#exp_uptable').html(data);

    });
}

function remove_expupload(id, projid, pack_id) {
    $.post("code/remove_expupload.php", {key: id}, function (data) {

        if ($.trim(data) === '1') {
            fetch_exp_uploaddocument(projid, pack_id);
        } else {
            swal('Something went wrong');
        }
    });
}

function remove_expupload1(id, projid, pack_id) {
    $.post("code/remove_expupload.php", {key: id}, function (data) {
        $expert = "expert";
        if ($.trim(data) === '1') {
            fetch_exp_uploaddocument1(projid, pack_id, $expert);
        } else {
            swal('Something went wrong');
        }
    });
}

// function  fetch_exp_uploaddocument_view(proj_id, pack_id) {
//     $('#exp_uptable').html('<center><img src="images/loading.gif" alt=""/></center>');
//     $.post("code/fetch_exp_uploaddocument_view.php", {key: pack_id, proj_id: proj_id}, function (data) {
//         $('#exp_uptable').html(data);
//         alert("hsdww");
//     });
// }
function   fetch_ops_exp_uploaddocument(projid, pack_id) {
    $('#ops_exp_uptable').html('<center><img src="images/loading.gif" alt=""/></center>');
    $.post("code/fetch_ops_exp_uploaddocument_view.php", {key: pack_id, proj_id: projid}, function (data) {
        $('#ops_exp_uptable').html(data);
    });
}

// function view_attachments(a, b, c, d) {
//     $("#proj").text(a);
//     $("#pack").html(b);
//     $.post("functions/filesforcto.php", {key: d}, function (data) {
//         var planned_date = JSON.parse(data).planned_date;
//         var mat_req_date = JSON.parse(data).mat_req_date;
//         var pm_packagename = JSON.parse(data).pm_packagename;
//         $('#planned_date').html(planned_date);
//         $('#mat_req_date').html(mat_req_date);
//         $('#exp_date').val(mat_req_date);
//         fetch_exp_uploaddocument_view(c, d);
//     });
//     //        $.post("functions/expertremarks.php", {key: pack_id}, function (data) {
//     //            $('#expr').html(data);
//     //        });

// }

function view_attachments(a, b, c, d, s,t) {

    // exit();
    $("#proj").text(a);
    $("#pack1").text(b);
    $("#projid").val(c);
    $("#packid").val(d);
    
    $(".type_sty").text(t);
    $.post("functions/filesfor_attachment.php", {
        key: d,
        stage: s
    }, function(data) {
        var planned_date = JSON.parse(data).planned_date;
        var mat_req_date = JSON.parse(data).mat_req_date;
        var pm_packagename = JSON.parse(data).pm_packagename;
        $('#planned_date').html(planned_date);
        $('#mat_req_date').html(mat_req_date);
        $('#exp_date').html(mat_req_date);
        fetch_all_document(c, d, s);

    });
    //        $.post("functions/expertremarks.php", {key: pack_id}, function (data) {
    //            $('#expr').html(data);
    //        });

    function view_dist_files(a, b, c, d, s) {

        // exit();
        $("#proj").text(a);
        $("#pack").html(b);
        $("#projid").val(c);
        $("#packid").val(d);
    
        $.post("functions/filesfor_distributor.php", {
            key: d,
            
        }, function(data) {
            var planned_date = JSON.parse(data).planned_date;
            var mat_req_date = JSON.parse(data).mat_req_date;
            var pm_packagename = JSON.parse(data).pm_packagename;
            $('#planned_date').html(planned_date);
            $('#mat_req_date').html(mat_req_date);
            $('#exp_date').html(mat_req_date);
            fetch_all_dist_doc(c, d, s);
    
        });
        //        $.post("functions/expertremarks.php", {key: pack_id}, function (data) {
        //            $('#expr').html(data);
        //        });
    
    }
    
}

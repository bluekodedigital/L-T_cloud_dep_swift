function create_newpackage(projid) {
    //alert(projid);
    $('#package_create').show();
    $('#eproj_name').val(projid);
    $('#proj_name').val(projid);
}
function filesfor_techspoc(pack_id) {

    $.post("code/filesfortechspoc.php", { key: pack_id }, function (data) {
        var proj_name = JSON.parse(data).proj_name;
        var pack_name = JSON.parse(data).pack_name;
        var planned = JSON.parse(data).planned;
        var actual = JSON.parse(data).actual;
        var expected = JSON.parse(data).expected;
        var pm_material_req = JSON.parse(data).pm_material_req;
        var proj_id = JSON.parse(data).proj_id;
        $('#project').html(proj_name);
        $('#pack').html(pack_name);
        $('#expected_date').val(expected);
        $('#actual_date').val(actual);
        $('#pdate').html(planned);
        $('#mtred').html(pm_material_req);
        $('#planneddate').val(planned);
        $('#projectid').val(proj_id);
        $('#packageid').val(pack_id);

    });
}
function get_expected(id) {
    var stage_id = id;
    if (stage_id == 2 || stage_id == 7) {
        var actual = $('#actual_date').val();
        $('#expected_date').val(actual);
    }

}
function filesfromcto(pack_id) {

    $.post("code/filesfromcto.php", { key: pack_id }, function (data) {
        var proj_name = JSON.parse(data).proj_name;
        var pack_name = JSON.parse(data).pack_name;
        var planned = JSON.parse(data).planned;
        var actual = JSON.parse(data).actual;
        var expected = JSON.parse(data).expected;
        var pm_material_req = JSON.parse(data).pm_material_req;
        var proj_id = JSON.parse(data).proj_id;

        $('#project').html(proj_name);
        $('#pack').html(pack_name);

        $('#expected_date').val(expected);
        $('#actual_date').val(actual);
        $('#pdate').html(planned);
        $('#mtred').html(pm_material_req);
        $('#planneddate').val(planned);
        $('#projectid').val(proj_id);
        $('#packageid').val(pack_id);
        $('#projid').val(proj_id);
        $('#packid').val(pack_id);
        fetch_exp_uploaddocument_view(proj_id, pack_id);
        fetch_ops_exp_uploaddocument(proj_id, pack_id);
    });
    $.post("code/cto_to_opsremarks.php", { key: pack_id }, function (data) {
        $('#ctor').html(data);
    });
}

function filesfrom_om(pack_id) {
    $.post("code/filesfrom_om.php", { key: pack_id }, function (data) {
        //alert(data);
        var proj_name = JSON.parse(data).proj_name;
        var pack_name = JSON.parse(data).pack_name;
        var planned = JSON.parse(data).planned;
        var actual = JSON.parse(data).actual;
        var expected = JSON.parse(data).expected;
        var pm_material_req = JSON.parse(data).pm_material_req;
        var proj_id = JSON.parse(data).proj_id;
        $('#project').html(proj_name);
        $('#pack').html(pack_name);
        $('#expected_date').val(expected);
        $('#actual_date').val(actual);
        $('#pdate').html(planned);
        $('#mtred').html(pm_material_req);
        $('#planneddate').val(planned);
        $('#projectid').val(proj_id);
        $('#packageid').val(pack_id);
        fetch_om_uploaddocument_view(proj_id, pack_id);
        fetch_exp_uploaddocument_view(proj_id, pack_id);
        fetch_ops_exp_uploaddocument(proj_id, pack_id);
    });
    $.post("code/om_to_opsremarks.php", { key: pack_id }, function (data) {
        $('#ctor').html(data);
    });
}
function filesfrom_scm(pack_id) {
    $.post("code/filesfrom_scm.php", { key: pack_id }, function (data) {
        //alert(data);
        var proj_name = JSON.parse(data).proj_name;
        var pack_name = JSON.parse(data).pack_name;
        var planned = JSON.parse(data).planned;
        var actual = JSON.parse(data).actual;
        var expected = JSON.parse(data).expected;
        var pm_material_req = JSON.parse(data).pm_material_req;
        var proj_id = JSON.parse(data).proj_id;
        // alert(proj_id);
        // alert(pack_id);
        $('#project').html(proj_name);
        $('#pack').html(pack_name);
        $('#expected_date').val(expected);
        $('#actual_date').val(actual);
        $('#pdate').html(planned);
        $('#mtred').html(pm_material_req);
        $('#planneddate').val(planned);
        $('#projectid').val(proj_id);
        $('#packageid').val(pack_id);
        $('#projid').val(proj_id);
        $('#packid').val(pack_id);
        fetch_ops_exp_uploaddocument_view(proj_id, pack_id);
        // fetch_ops_exp_uploaddocument(proj_id, pack_id);
    });
    $.post("code/scm_to_opsremarks.php", { key: pack_id }, function (data) {
        $('#ctor').html(data);
    });
}
function filesinom(pack_id) {
    $.post("code/filesinom.php", { key: pack_id }, function (data) {
        //  alert(data);
        var proj_name = JSON.parse(data).proj_name;
        var pack_name = JSON.parse(data).pack_name;
        var planned = JSON.parse(data).planned;
        var actual = JSON.parse(data).actual;
        var expected = JSON.parse(data).expected;
        var pm_material_req = JSON.parse(data).pm_material_req;
        var proj_id = JSON.parse(data).proj_id;
        $('#project').html(proj_name);
        $('#pack').html(pack_name);

        $('#expected_date').val(expected);
        $('#actual_date').val(actual);
        $('#pdate').html(planned);
        $('#mtred').html(pm_material_req);
        $('#planneddate').val(planned);
        $('#projectid').val(proj_id);
        $('#packageid').val(pack_id);
        //addon
        $("#proj").html(proj_name);
        $("#pack1").html(pack_name);
        $("#projid").val(proj_id);
        $("#packid").val(pack_id);

        fetch_om_uploaddocument(proj_id, pack_id);
        fetch_exp_uploaddocument_view(proj_id, pack_id);


    });
    $.post("code/filesinomremarks.php", { key: pack_id }, function (data) {
        $('#ctor').html(data);
    });
}
function filesfrom_smartsign(pack_id) {
    $.post("code/filesfrom_smartsign.php", { key: pack_id }, function (data) {
        //alert(data);
        var proj_name = JSON.parse(data).proj_name;
        var pack_name = JSON.parse(data).pack_name;
        var planned = JSON.parse(data).planned;
        var actual = JSON.parse(data).actual;
        var expected = JSON.parse(data).expected;
        var pm_material_req = JSON.parse(data).pm_material_req;
        var proj_id = JSON.parse(data).proj_id;
        $('#project').html(proj_name);
        $('#pack').html(pack_name);

        $('#expected_date').val(expected);
        $('#actual_date').val(actual);
        $('#pdate').html(planned);
        $('#mtred').html(pm_material_req);
        $('#planneddate').val(planned);
        $('#projectid').val(proj_id);
        $('#packageid').val(pack_id);
    });
}
function filesfor_techapp(pack_id, flag) {
    //alert(flag); exit();
    $.post("code/filesfor_techapp.php", { key: pack_id, flag: flag }, function (data) {
        //alert(data);
        var proj_name = JSON.parse(data).proj_name;
        var pack_name = JSON.parse(data).pack_name;
        var planned = JSON.parse(data).planned;
        var actual = JSON.parse(data).actual;
        var expected = JSON.parse(data).expected;
        var pm_material_req = JSON.parse(data).pm_material_req;
        var proj_id = JSON.parse(data).proj_id;
        $('#project').html(proj_name);
        $('#pack').html(pack_name);
        $('#expected_date').val(expected);
        $('#actual_date').val(actual);
        $('#pdate').html(planned);
        $('#mtred').html(pm_material_req);
        $('#planneddate').val(planned);
        $('#projectid').val(proj_id);
        $('#packageid').val(pack_id);
        $('#flag').val(flag);
        if (flag == 0) {
            $('#senttitle').html('Vendor to Ops Drawing Sample/POC Submission');
        } else if (flag == 1) {
            $('#senttitle').html('Ops to Engineering  Vendor Drawing/POC');
            $('#change_expert').show();
        } else if (flag == 3) {
            $('#senttitle').html('Ops to Vendor (Approved Drawing)');
        }

    });
    $.post("code/filesfor_techappremarks.php", { key: pack_id, flag: flag }, function (data) {
        $('#ctor').html(data);
    });
}
function po_detailsenter(pack_id) {
    //alert(pack_id);
    $.post("code/po_details_entry.php", { key: pack_id }, function (data) {
        //alert(data);
        $('#po_content').html(data);
    });
}
function po_detail_save(packid, name, rid, e, colnum) {
    //    if (e.keyCode == 13)
    //    {
    var date = 'date';
    var attr = name + rid;
    var qty = $('#' + attr).val();
    var cus = $('#cus').val();
    var cnum = colnum;
    var stage_date = $('#' + name + date + rid).val();
    if (qty == "") {
        swal('Please Enter Value & Proceed');
    } else if (stage_date == "") {
        swal('Please Select Date & Proceed');
    } else {
        $.post("code/po_detail_save.php", { packid: packid, name: name, qty: qty, rid: rid, cus: cus, cnum: cnum, stage_date: stage_date }, function (data) {
            //           alert(data); console.log(data); exit();
            if ($.trim(data) === '3') {
                alert('Enter Qty is Exceeds Po Qty');
                $('#' + attr).val('');
            } else if ($.trim(data) === '4') {
                alert('Enter Qty is Exceeds Previous Stage Qty');
                $('#' + attr).val('');
            } else if ($.trim(data) === '5') {
                alert('Entry Not Allowed');
                $('#' + attr).val('');
            } else if ($.trim(data) === '1') {
                alert('Saved');
                po_detailsenter(qid);
                po_detailsenter(packid);
            } else if ($.trim(data) === '2') {
                alert('Updated');
                po_detailsenter(qid);

            } else if ($.trim(data) === '77') {
                alert(' Enter Quantity Exceeds Po Qty');
                po_detailsenter(qid);
            }

        });
        //           po_detailsenter(packid);
    }

    //          for (var i = nr; i < 10; i++) {
    //                $('.em' + nr+rid).val('');
    //                nr=i;
    //            }

    //    }


}
function podetailview(pack_id) {
    $.post("code/podetailview.php", { key: pack_id }, function (data) {
        $('#podetailvie').html(data);
    });
}
function podetailviewscm(pack_id) {
    //    alert(pack_id);
    $.post("code/podetailviewscm.php", { key: pack_id }, function (data) {
        $('#podetailvie').html(data);
    });
}
function podetailviewget(pack_id) {
    var po_number = $('#po_number').val();
    //console.log(po_number);
    $.post("code/podetailviewscm.php", { key: pack_id }, function (data) {
        $('#podetailvie').html(data);
    });
}

function pohistoryview(rowid, pack_id) {
    $.post("code/pohistoryview.php", { rowid: rowid, packid: pack_id }, function (data) {
        $('#pohistory').html(data);
    });
}
function filesfrom_smartsign_loi(pack_id) {
    //alert('sad');
    $.post("code/filesfrom_smartsign_loi.php", { key: pack_id }, function (data) {
        //alert(data);
        var proj_name = JSON.parse(data).proj_name;
        var pack_name = JSON.parse(data).pack_name;
        var planned = JSON.parse(data).planned;
        var actual = JSON.parse(data).actual;
        var expected = JSON.parse(data).expected;
        var pm_material_req = JSON.parse(data).pm_material_req;
        var proj_id = JSON.parse(data).proj_id;
        var hpc_app = JSON.parse(data).hpc_app;
        $('#project').html(proj_name);
        $('#pack').html(pack_name);
        $('#expected_date').val(expected);
        $('#actual_date').val(actual);
        $('#pdate').html(planned);
        $('#mtred').html(pm_material_req);
        $('#planneddate').val(planned);
        $('#projectid').val(proj_id);
        $('#packageid').val(pack_id);

        //        alert(hpc_app);
        if (hpc_app == 1) {
            $('#hpc_app').val(1);
            $('.hpc_div').show();

        } else {
            $('#hpc_app').val(0);
            $('.hpc_div').hide();
        }

    });
}
function save_expected(pack_id, stage_id) {
    var exp_date = $('#dasexpected_date' + pack_id).val();
    $.post("code/save_expected.php", { key: pack_id, stage_id: stage_id, exp_date: exp_date }, function (data) {
        swal('Updated Successfully');
    });
}
function save_expected1(pack_id, stage_id) {
    var exp_date = $('#dasexpected_date' + pack_id).val();
    $.post("code/save_expected.php", { key: pack_id, stage_id: stage_id, exp_date: exp_date }, function (data) {
        //        swal('Updated Successfully');
    });
}
function filesforemr(pack_id) {
    //    alert(pack_id);
    $.post("code/filesforemr.php", { key: pack_id }, function (data) {
        var proj_name = JSON.parse(data).proj_name;
        var pack_name = JSON.parse(data).pack_name;
        var planned = JSON.parse(data).planned;
        var actual = JSON.parse(data).actual;
        var expected = JSON.parse(data).expected;
        var pm_material_req = JSON.parse(data).pm_material_req;
        var proj_id = JSON.parse(data).proj_id;

        var loi_remarks = JSON.parse(data).loi_remarks;
        var loi_number = JSON.parse(data).loi_number;
        var so_loi_date = JSON.parse(data).so_loi_date;
        var so_loi_date = so_loi_date.substring(0, 11);
        var half_remarks = loi_remarks.substring(0, 50);
        var po_wo_app = JSON.parse(data).po_wo_app;
        // alert(proj_name);
        $('#project').html(proj_name);
        $('#pack').html(pack_name);
        $('#expected_date').val(expected);
        $('#actual_date').val(actual);
        $('#pdate').html(planned);
        $('#mtred').html(pm_material_req);
        $('#planneddate').val(planned);
        $('#projectid').val(proj_id);
        $('#packageid').val(pack_id);
        $('#projid').val(proj_id);
        $('#packid').val(pack_id);
        $('#loi_number').text(loi_number);
        $('#loi_date').text(so_loi_date);
        $('#less').text(half_remarks);
        $('#moreew').text(loi_remarks);
        $('#po_wo_app').text(po_wo_app);

        // loi_number
        // so_loi_date
        // loi_remarks
        // loi_filename
        // loi_filepath
        fetch_loi_uploaddocument_view(proj_id, pack_id);

    });

    // $.post("code/fetch_loi_detail.php", {key: pack_id}, function (data) {
    // });
}
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

// function readmore(id) {
//     $('#moreew' + id).show();
//     $('#rless' + id).show();
//     $('#less' + id).hide();
//     $('#rmore' + id).hide();
// }

// function readless(id) {
//     $('#moreew' + id).hide();
//     $('#rless' + id).hide();
//     $('#less' + id).show();
//     $('#rmore' + id).show();
// }
function proj_type_Filter(id) {
    console.log(id);
    $.post("functions/proj_type_Filter.php", {
        key: id,
    }, function (data) {
        // console.log(data);
        var projectlist = JSON.parse(data).projectlist;
        var list = JSON.parse(projectlist);
        var option = '<option value="" >---Select Project --</option>';
        $(list).each(function (key, value) {
            option += '<option value="' + value.proj_id + '" >' + value.proj_name + '</option>';
        });

        $('#proj_Filter').html('');
        $('#proj_Filter').append(option);
    });

}
function proj_type_Filter_email(id) {
    console.log(id);
    $.post("functions/proj_type_Filter.php", {
        key: id,
    }, function (data) {
        // console.log(data);
        var projectlist = JSON.parse(data).projectlist;
        var list = JSON.parse(projectlist);
        var option = '<option value="" >---Select Project --</option>';
        $(list).each(function (key, value) {
            option += '<option value="' + value.proj_id + '" >' + value.proj_name + '</option>';
        });

        $('#sadminproj_Filter').html('');
        $('#sadminproj_Filter').append(option);
    });


}
function proj_type_Filter_proj(id) {
    //alert(id);
    //  console.log(id);
    $.post("functions/proj_type_Filter.php", {
        key: id,
    }, function (data) {
        // console.log(data);
        var projectlist = JSON.parse(data).projectlist;
        var list = JSON.parse(projectlist);
        var option = '<option value="" >---Select Project --</option>';
        $(list).each(function (key, value) {
            option += '<option value="' + value.proj_id + '" >' + value.proj_name + '</option>';
        });

        $('#proj_id').html('');
        $('#proj_id').append(option);
    });

}
function proj_type_Filter_tech(id) {
    //alert(id);
    //  console.log(id);
    $.post("functions/proj_type_Filter.php", {
        key: id,
    }, function (data) {
        // console.log(data);
        var projectlist = JSON.parse(data).projectlist;
        var list = JSON.parse(projectlist);
        var option = '<option value="" >---Select Project --</option>';
        $(list).each(function (key, value) {
            option += '<option value="' + value.proj_id + '" >' + value.proj_name + '</option>';
        });

        $('#project_id').html('');
        $('#project_id').append(option);
    });

}
function proj_type_Filter_wf(id) {
    //alert(id);
    //  console.log(id);
    $.post("functions/proj_type_Filter.php", {
        key: id,
    }, function (data) {
        // console.log(data);
        var projectlist = JSON.parse(data).projectlist;
        var list = JSON.parse(projectlist);
        var option = '<option value="" >---Select Project --</option>';
        $(list).each(function (key, value) {
            option += '<option value="' + value.proj_id + '" >' + value.proj_name + '</option>';
        });

        $('#expert_id').html('');
        $('#expert_id').append(option);
    });

}
function proj_Filter(id, page) {
    //console.log(page );
    var tid = $('#proj_type').val();
    if (page == 2) {
        window.location.href = "files_for_techspoc?pid=" + id + "&ptid=" + tid;
    }
    if (page == 1) {
        window.location.href = "CommanDashboard?pid=" + id + "&ptid=" + tid;
    }
    if (page == 3) {
        window.location.href = "files_from_contract?pid=" + id + "&ptid=" + tid;
    }
    if (page == 4) {
        window.location.href = "package_master?pid=" + id + "&ptid=" + tid;
    }
    if (page == 5) {
        window.location.href = "files_from_CTO?pid=" + id + "&ptid=" + tid;
    }
    if (page == 6) {
        window.location.href = "files_from_OM?pid=" + id + "&ptid=" + tid;
    }
    if (page == 7) {
        window.location.href = "om_workflow?pid=" + id + "&ptid=" + tid;
    }
    if (page == 8) {
        window.location.href = "files_from_Smartsign?pid=" + id + "&ptid=" + tid;
    }
    if (page == 9) {
        window.location.href = "files_for_techapproval?pid=" + id + "&ptid=" + tid;
    }
    if (page == 10) {
        window.location.href = "files_for_POentry?pid=" + id + "&ptid=" + tid;
    }
    if (page == 11) {
        window.location.href = "ops_repository?pid=" + id + "&ptid=" + tid;
    }
    if (page == 12) {
        window.location.href = "om_dasboard?pid=" + id + "&ptid=" + tid;
    }
    if (page == 13) {
        window.location.href = "om_repository?pid=" + id + "&ptid=" + tid;
    }
    if (page == 14) {
        window.location.href = "loi_update?pid=" + id + "&ptid=" + tid;
    }
    if (page == 15) {
        window.location.href = "files_for_wocompletionentry?pid=" + id + "&ptid=" + tid;

    }
    if (page == 16) {
        window.location.href = "dashboard?pid=" + id + "&ptid=" + tid;

    }
    if (page == 17) {
        window.location.href = "dash_version1?pid=" + id + "&ptid=" + tid;

    }

}
function save_wocompletion(pack_id, proj_id) {
    var percen = $('#wo_percentage' + pack_id).val();
    if (percen == "") {
        swal("Please Enter Percentage");
    } else {
        $.post("code/save_wocompletion.php", { key: pack_id, per: percen, proj_id: proj_id }, function (data) {

            if ($.trim(data) == 0) {
                alert('100% Completed already');
            } else if ($.trim(data) == 1) {
                alert('Updated Successfully');
            } else if ($.trim(data) == 2) {
                alert('Updated Successfully');
            }
            window.location.reload(true);
        });
    }
}

function om_filesuplod() {
    var pack_id = $('#packageid').val();
    var projid = $('#projectid').val();
    var doc_name = $('#doc_name').val();
    var file_name = $('#inputGroupFile01').val();
    var file_data = $('#inputGroupFile01').prop('files')[0];

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
            url: 'code/om_filesuplod.php', // point to server-side PHP script 
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
                    fetch_om_uploaddocument(projid, pack_id);
                }
                $('#progress-wrp').hide();

            }
        });
    }
}
function fetch_om_uploaddocument(projid, pack_id) {
    $('#uptable').html('<img src="images/loading.gif" alt=""/>');
    $.post("code/fetch_om_uploaddocument.php", { key: pack_id, proj_id: projid }, function (data) {
        $('#uptable').html(data);

    });
}
function fetch_om_uploaddocument_view(proj_id, pack_id) {
    $('#uptable').html('<center><img src="images/loading.gif" alt=""/></center>');
    $.post("code/fetch_om_uploaddocument_view.php", { key: pack_id, proj_id: proj_id }, function (data) {
        $('#uptable').html(data);

    });
}
function remove_omupload(id, projid, pack_id) {
    $.post("code/remove_omupload.php", { key: id }, function (data) {

        if ($.trim(data) === '1') {
            fetch_om_uploaddocument(projid, pack_id);
        } else {
            swal('Something went wrong');
        }


    });
}
function remove_opsupload(id, projid, pack_id, stage) {

    $.post("code/remove_opsupload.php", { key: id }, function (data) {

        if ($.trim(data) === '1') {
            fetch_uploaded_document(projid, pack_id, stage);
        } else {
            swal('Something went wrong');
        }


    });
}

function remove_opsupload1(id, projid, pack_id, stage) {

    $.post("code/remove_opsupload.php", { key: id }, function (data) {

        if ($.trim(data) === '1') {
            //fetch_uploaded_document(projid, pack_id, stage);
            fetch_pre_uploaded_document_view(projid, pack_id)
        } else {
            swal('Something went wrong');
        }


    });
}

function add_keyflag($i, id, projid, pack_id, stage) {

    if ($('#keyattach_flag' + $i).is(':checked')) {
        var keyflag = 1;
    } else {
        var keyflag = 0;
    }

    $.post("code/add_keyflag.php", { key: id, keyflag: keyflag }, function (data) {

        if ($.trim(data) === '1') {
            //fetch_uploaded_document(projid, pack_id, stage);
            fetch_pre_uploaded_document_view(projid, pack_id)
        } else {
            swal('Something went wrong');
        }


    });
}
function add_keyflag2($i, id, projid, pack_id, stage) {

    if ($('#keyattach_flags' + $i).is(':checked')) {
        var keyflag = 1;
    } else {
        var keyflag = 0;
    }

    $.post("code/add_keyflag.php", { key: id, keyflag: keyflag }, function (data) {

        if ($.trim(data) === '1') {
            fetch_uploaded_document(projid, pack_id, stage);
            fetch_pre_uploaded_document_view(projid, pack_id);

        } else {
            swal('Something went wrong');
        }


    });
}


function loi_filesuplod() {
    var pack_id = $('#packageid').val();
    var projid = $('#projectid').val();
    var doc_name = $('#doc_name').val();
    var file_name = $('#inputGroupFile01').val();
    var file_data = $('#inputGroupFile01').prop('files')[0];

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
            url: 'code/loi_filesuplod.php', // point to server-side PHP script 
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
                    fetch_loi_uploaddocument(projid, pack_id);
                    $('#progress-wrp').hide();
                }

            }
        });
    }
}
function fetch_loi_uploaddocument(projid, pack_id) {
    $('#uptable').html('<img src="images/loading.gif" alt=""/>');
    $.post("code/fetch_loi_uploaddocument.php", { key: pack_id, proj_id: projid }, function (data) {
        $('#uptable').html(data);

    });
}
function fetch_loi_uploaddocument_view(proj_id, pack_id) {
    $('#uptable').html('<center><img src="images/loading.gif" alt=""/></center>');
    $.post("code/fetch_loi_uploaddocument_view.php", { key: pack_id, proj_id: proj_id }, function (data) {
        // alert(data);
        $('#uptable').html(data);

    });
}
function remove_loiupload(id, projid, pack_id) {
    $.post("code/remove_loiupload.php", { key: id }, function (data) {
        if ($.trim(data) === '1') {
            fetch_loi_uploaddocument(projid, pack_id);
        } else {
            swal('Something went wrong');
        }


    });
}
function filesforemrrepo(pack_id) {
    //    alert(pack_id);
    $.post("code/filesforemr_1.php", { key: pack_id }, function (data) {
        var proj_name = JSON.parse(data).proj_name;
        var pack_name = JSON.parse(data).pack_name;
        var planned = JSON.parse(data).planned;
        var actual = JSON.parse(data).actual;
        var expected = JSON.parse(data).expected;
        var pm_material_req = JSON.parse(data).pm_material_req;
        var proj_id = JSON.parse(data).proj_id;
        $('#project').html(proj_name);
        $('#pack').html(pack_name);
        $('#expected_date').val(expected);
        $('#actual_date').val(actual);
        $('#pdate').html(planned);
        $('#mtred').html(pm_material_req);
        $('#planneddate').val(planned);
        $('#projectid').val(proj_id);
        $('#packageid').val(pack_id);
        fetch_loi_uploaddocument_view_1(proj_id, pack_id);
    });
}
function fetch_loi_uploaddocument_view_1(proj_id, pack_id) {
    $('#uptable').html('<center><img src="images/loading.gif" alt=""/></center>');
    $.post("code/fetch_loi_uploaddocument_view_1.php", { key: pack_id, proj_id: proj_id }, function (data) {
        $('#uptable').html(data);

    });
}
// $("input[name=pack_name]").focusout(function () {
//     var cat_name = $(this).val();
// //    alert(cat_name);
//     $.post("code/fetch_leadtime.php", {key: cat_name}, function (data) {
// //        alert(data);
//         if ($.trim(data) == 0) {
//             $('#lead_time').val('');
//         } else {
//             $('#lead_time').val($.trim(data));
//         }


//     });
// });
function view_catmst(id) {
    //    alert(id);
    $.post("code/fetch_procategory.php", { key: id }, function (data) {
        //        alert(data);
        var cat_name = JSON.parse(data).cat_name;
        var leadtime = JSON.parse(data).leadtime;
        $('#package_create').show();
        $('#pc_id').val(id);
        $('#package_cat_create').hide();
        $('#package_cat_update').show();
        $('#lead_time').val(leadtime);
        $('#pack_cat_name').val(cat_name);


    });
}
/* function view_detail(id){
    alert('working');
	
    /* $.post("code/category.php", {key: id}, function (data) {
//        alert(data);
        var cat_name = JSON.parse(data).master;
      
        $('#package_create').show();
        $('#pc_id').val(id);
        $('#package_cat_create').hide();
        $('#package_cat_update').show();
      
        $('#pack_cat_name').val(cat_name);


    });*/




function cat_onchange(id) {

    $.post("code/fetch_leadtime_cat.php", { key: id }, function (data) {
        //        alert(data);
        if ($.trim(data) == 0) {
            $('#lead_time').val('');
        } else {
            $('#lead_time').val($.trim(data));
            calculateMatReqDate ();
        }
       

    });
}

function calculateMatReqDate() {
    var leadTime = parseInt($('#lead_time').val()) || 0;
    var today = new Date(); // Get today's date

    if (leadTime > 0) {
        today.setDate(today.getDate() + leadTime); // Add lead time days

        var newDate = formatDate(today);
        $('#mat_req_site').val(newDate); // Update field
        mat_change();
    }
}

function formatDate(date) {
    var day = date.getDate().toString().padStart(2, '0');
    var month = date.toLocaleString('en-US', { month: 'short' });
    var year = date.getFullYear();
    return `${day}-${month}-${year}`;
}
function wf_onchange(id) {


    //     $.post("code/fetch_leadtime_cat.php", {key: id}, function (data) {
    // //        alert(data);
    //         if ($.trim(data) == 0) {
    //             $('#lead_time').val('');
    //         } else {
    //             $('#lead_time').val($.trim(data));
    //         }


    //     });
}

function repo_dash(pid, stageid, seg) {
    //    alert(stageid);

    $.post("code/report_dash.php", { key: pid, stage: stageid, seg: seg }, function (data) {
        //        alert(data);
        $('#repo_dash').html(data);

        $('#file_export').dataTable()
            .columnFilter({
                aoColumns: [{ type: "select", values: ['Gecko', 'Trident', 'KHTML', 'Misc', 'Presto', 'Webkit', 'Tasman'] },
                { type: "text" },
                    null,
                { type: "number" },
                { type: "select" }
                ]

            });
    });
}
function fetch_pre_uploaded_document_view(proj_id, pack_id) {
    $('#uptable').html('<center><img src="images/loading.gif" alt=""/></center>');
    $.post("code/fetch_pre_uploaded_doc_view.php", { key: pack_id, proj_id: proj_id }, function (data) {
        $('#exp_uptable').html(data);

    });
}

function fetch_exp_uploaddocument_view(proj_id, pack_id) {
    $('#uptable').html('<center><img src="images/loading.gif" alt=""/></center>');
    $.post("code/fetch_exp_uploaddocument_view.php", { key: pack_id, proj_id: proj_id }, function (data) {
        $('#exp_uptable').html(data);


    });
}
function view_packdetails(pid, id) {

    $('#package_create').show();
    $.post("code/view_packdetails.php", { key: id, proj_id: pid }, function (data) {
        var pack_name = JSON.parse(data).pack_name;
        var pack_category = JSON.parse(data).pack_category;
        var org_date = JSON.parse(data).org_date;
        var mt_req = JSON.parse(data).mt_req;
        var lead_time = JSON.parse(data).lead_time;
        var remarks = JSON.parse(data).remarks;
        var proj_type = JSON.parse(data).proj_type;
        var work_flow = JSON.parse(data).work_flow;
        var uid = JSON.parse(data).uid;
        $('#pck_update').show();
        $('#pck_create').hide();
        $('#proj_name').val(pid);
        $('#pack_name').val(pack_name);
        $('#pack_cat_name').val(pack_category);
        $('#org_schedule').val(org_date);
        $('#mat_req_site').val(mt_req);
        $('#lead_time').val(lead_time);
        $('#pck_id').val(id);
        $('#proj_type_name').val(proj_type);
        $('#pack_work_flow').val(work_flow);
        $('#opstospocremarks').val(remarks);
        $('#pack_name').attr("readonly", true);
        setTimeout(() => {
            wf_onchange(work_flow);
            setTimeout(() => {
                $('#user_filter').val(uid);
            }, 500);
        }, 100);
    });
}
function common_filesuplod() {

    var pack_id = $('#packageid').val();
    var projid = $('#projectid').val();
    var doc_name = $('#doc_name').val();
    var stage = $('#cur_stage').val();

    if ($('#keyattach').is(":checked")) {
        var key = 1;
    } else {
        var key = 0;
    }
    var file_name = $('#inputGroupFile01').val();
    var file_data = $('#inputGroupFile01').prop('files')[0];

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
        form_data.append('stage', stage);
        form_data.append('key', key);
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
            url: 'code/common_filesuplod.php', // point to server-side PHP script 
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
                    fetch_uploaded_document(projid, pack_id, stage);
                }
                $('#progress-wrp').hide();

            }
        });
    }
}
function fetch_uploaded_document(projid, pack_id, stage) {

    $('#ops_exp_uptable').html('<center><img src="images/loading.gif" alt=""/></center>');
    var rid = $('#ops_rem').val();

    if (rid == 1) {
        rid = 1;
    } else {
        rid = 0;
    }
    console.log(rid)
    $.post("code/fetch_uploaded_document_view.php", { key: pack_id, proj_id: projid, rid: rid, stage: stage }, function (data) {
        $('#ops_exp_uptable').html(data);

    });
}
function fetch_all_document(projid, pack_id, stage) {

    $('#ops_exp_uptable').html('<center><img src="images/loading.gif" alt=""/></center>');
    var rid = $('#ops_rem').val();

    if (rid == 1) {
        rid = 1;
    } else {
        rid = 0;
    }
    $.post("code/fetch_all_documents.php", { key: pack_id, proj_id: projid, rid: rid, stage: stage }, function (data) {
        $('#ops_exp_uptable').html(data);
        $('#exampleModal').modal('show');

    });
}
function fetch_ops_exp_uploaddocument_view(projid, pack_id) {
    $('#ops_exp_uptable').html('<center><img src="images/loading.gif" alt=""/></center>');
    var rid = 0;

    $.post("code/fetch_ops_exp_uploaddocument_view.php", { key: pack_id, proj_id: projid, rid: rid }, function (data) {
        //alert(data);
        $('#ops_exp_uptable').html(data);

    });
}
function view_allattachments(pname, packname, projid, packid, plan, exp) {
    $('#exampleModal2').modal('show');
    $('#proj').html(pname);
    $('#pack1').html(packname);
    $('#projid').val($.trim(projid));
    $('#projid1').html(projid);
    $('#packid').val($.trim(packid));
    $('#planned_date').html(plan);
    $('#exp_date').html(exp);
    fetch_exp_uploaddocument_view(projid, packid);
    fetch_om_uploaddocument_view(projid, packid);
    fetch_ops_exp_uploaddocument_view(projid, packid);

}
function downloadallv1(type) {

    var projid = $("#projid").val();
    var packid = $("#packid").val();
    var projname = $("#proj").html();
    var packname = $("#pack1").html();
    console.log(packid,projid);

    if (typeof projname === 'undefined') {
        projname = $("#project").html();
    }
    if (typeof packname === 'undefined') {
        packname = $("#pack").html();
    }

    if (typeof projid === 'undefined') {
        projid = $("#projectid").val();
    }
    if (typeof packid === 'undefined') {
        packid = $("#packageid").val();
    }
    console.log(packid,projid);
    
    console.log(packname,projname);
    window.location.href = 'downloadzipv1.php?key=' + $.trim(packid) + '&proj_id=' + $.trim(projid) + '&packname=' + packname + '&projname=' + projname + '&type=' + type;

}
function downloadall(type) {

    var projid = $("#projid").val();
    var packid = $("#packid").val();
    var projname = $("#proj").html();
    var packname = $("#pack1").html();
    console.log(packid,projid);

    if (typeof projname === 'undefined') {
        projname = $("#project").html();
    }
    if (typeof packname === 'undefined') {
        packname = $("#pack").html();
    }

    if (typeof projid === 'undefined') {
        projid = $("#projectid").val();
    }
    if (typeof packid === 'undefined') {
        packid = $("#packageid").val();
    }
    console.log(packid,projid);
    
    console.log(packname,projname);
    window.location.href = 'downloadzip.php?key=' + $.trim(packid) + '&proj_id=' + $.trim(projid) + '&packname=' + packname + '&projname=' + projname + '&type=' + type;

}

function filter_hpc(val) {
    var proj_id = $('#proj_Filter').val();

    $.post("code/filter_hpc.php", { key: val, proj_id: proj_id }, function (data) {
        // alert(data);
        $('#loi_datas').html(data);

    });
}

function ordercopy_filesuplod() {

    var pack_id = $('#packageid').val();
    var projid = $('#projectid').val();
    var doc_name = $('#doc_name').val();
    var mdid = $('#mdid').val();
    var sendback = $('#sendback').val();

    var file_name = $('#inputGroupFile01').val();
    var file_data = $('#inputGroupFile01').prop('files')[0];


    $('#progress-wrp').show();


    var form_data = new FormData();
    form_data.append('file', file_data);
    form_data.append('projid', projid);
    form_data.append('pack_id', pack_id);
    form_data.append('doc_name', doc_name);
    form_data.append('mdid', mdid);
    form_data.append('sendback', sendback);
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
        url: 'code/ordercopy_upload.php', // point to server-side PHP script 
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
                order_uploaded_doc(projid, pack_id, mdid);
            }
            $('#progress-wrp').hide();

        }
    });

}

function order_uploaded_doc(projid, pack_id, mdid) {

    $('#dist_uptable').html('<center><img src="images/loading.gif" alt=""/></center>');

    $.post("code/fetch_ordercopy_doc_view.php", { key: pack_id, proj_id: projid, mdid: mdid }, function (data) {
        $('#dist_uptable').html(data);

    });
}
function remove_orderupload(id, projid, pack_id, mdid) {

    $.post("code/remove_orderupload.php", { key: id }, function (data) {

        if ($.trim(data) === '1') {
            order_uploaded_doc(projid, pack_id, mdid);
        } else {
            swal('Something went wrong');
        }


    });

}
$('#dt_doctype').keypress(function (e) {
    var regex = new RegExp("^[a-zA-Z]+$");
    var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
    if (regex.test(str)) {

        return true;
    } else
    {
        e.preventDefault();
        alert('Only alphabhates are allowed');
        return false;
    }
});
function view_docmst(id) {
//    alert(id);
    $.post("code/fetch_doctype.php", {key: id}, function (data) {
//        alert(data);
        var dt_doctype = JSON.parse(data).dt_doctype;
        var dt_docname = JSON.parse(data).dt_docname;
        $('#package_create').show();
        $('#dt_id').val(id);
        $('#dt_create').hide();
        $('#dt_update').show();
        $('#dt_doctype').val(dt_doctype);
        $('#dt_docname').val(dt_docname);
    });
}
function delete_docmst(id) {

    var r = confirm("Are you sure you want to delete?");
    if (r == true) {
        window.location.href = 'functions/documentsetting?id=' + id;
    }
}
// Team code part

$('#tc_teamcode').keypress(function (e) {
    var regex = new RegExp("^[a-zA-Z]+$");
    var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
    if (regex.test(str)) {

        return true;
    } else
    {
        e.preventDefault();
        alert('Only alphabhates are allowed');
        return false;
    }
});

function view_teammst(id) {
//    alert(id);
    $.post("code/fetch_teamcode.php", {key: id}, function (data) {
//        alert(data);
        var tc_teamcode = JSON.parse(data).tc_teamcode;
        var tc_teamname = JSON.parse(data).tc_teamname;
        $('#package_create').show();
        $('#tc_id').val(id);
        $('#tc_create').hide();
        $('#tc_update').show();
        $('#tc_teamcode').val(tc_teamcode);
        $('#tc_teamname').val(tc_teamname);
    });
}
function delete_teammst(id) {

    var r = confirm("Are you sure you want to delete?");
    if (r == true) {
        window.location.href = 'functions/documentsetting?tcid=' + id;
    }
}

// document set code
$('#dc_setcode').keypress(function (e) {
    var regex = new RegExp("^[a-zA-Z]+$");
    var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
    if (regex.test(str)) {

        return true;
    } else
    {
        e.preventDefault();
        alert('Only alphabhates are allowed');
        return false;
    }
});
function view_docsetmst(id) {
//    alert(id);
    $.post("code/fetch_docset.php", {key: id}, function (data) {
//        alert(data);
        var dc_setcode = JSON.parse(data).dc_setcode;
        var dc_setname = JSON.parse(data).dc_setname;
        $('#package_create').show();
        $('#dc_id').val(id);
        $('#dc_create').hide();
        $('#dc_update').show();
        $('#dc_setcode').val(dc_setcode);
        $('#dc_setname').val(dc_setname);
    });
}
function delete_docsetmst(id) {

    var r = confirm("Are you sure you want to delete?");
    if (r == true) {
        window.location.href = 'functions/documentsetting?dcid=' + id;
    }
}

//system code
function isNumberKey(evt, obj) {
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode != 46)
        return false;
    else {
        var len = obj.value.length;
        var index = obj.value.indexOf('.');

        if (index > 0 && charCode == 46) {
            return false;
        }
        if (index > 0) {
            var CharAfterdot = (len + 1) - index;
            if (CharAfterdot > 3) {
                return false;
            }
        }

    }
    return true;
}
function view_scmst(id) {
//    alert(id);
    $.post("code/fetch_sccode.php", {key: id}, function (data) {
//        alert(data);
        var sc_code = JSON.parse(data).sc_code;
        var sc_name = JSON.parse(data).sc_name;
        $('#package_create').show();
        $('#sc_id').val(id);
        $('#sc_create').hide();
        $('#sc_update').show();
        $('#sc_code').val(sc_code);
        $('#sc_name').val(sc_name);
    });
}
function delete_scmst(id) {
    var r = confirm("Are you sure you want to delete?");
    if (r == true) {
        window.location.href = 'functions/documentsetting?scid=' + id;
    }
}
function gen_doc_number() {

    var jobcode = $('#jbcode').val();
    var doc_type = $('#doc_type').val();
    var team_code = $('#team_code').val();
    var setcode = $('#setcode').val();
    var syscode = $('#syscode').val();
    var packid = $('#packageid').val();
    if (jobcode == "") {
        alert('Job Code not created yet. Please contact admin.');
    } else if (doc_type == "") {
        alert('Please select document type.');
    } else if (team_code == "") {
        alert('Please select Team Code.');
    } else if (setcode == "") {
        alert('Please select document set Code.');
    } else if (syscode == "") {
        alert('Please select System Code.');
    } else {
        var docno = doc_type + '-' + jobcode + '-' + team_code + '-' + setcode + '-' + syscode;
//        alert(docno);
        $('#doc_name').val(docno);
        viewing_checklist(packid);



    }

}

function viewing_checklist(packid) {
    if(packid == 0){
        packid =  $('#packageid').val();
    }
    $.post("code/view_checklists.php", {key: packid}, function (data) {
         
        $('#checklistmodal').modal('show');
        $('#checklisttable').html(data);

    });
}
//function save_checklist(packid, uid) {
//    var remarks = new Array();
//    var IDs = new Array();
//    IDs = $(".idscheck:checked").map(function () {
//        return this.value;
//    }).toArray();
//    for (var m = 0; m < IDs.length; m++) {
//        remarks[m] = $('#remarks' + IDs[m]).text().replace(/,/g, "");
//    }
//   alert(IDs);
//}

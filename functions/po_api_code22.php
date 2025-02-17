<?php
include_once("../config/inc_function.php");

ini_set('post_max_size', '0');
$pack_id = mssql_escape($_POST['pack_id']);
$po_number = mssql_escape($_POST['key']);
$projid = mssql_escape($_POST['projid']);
$result = $cls_comm->select_projects($projid);
$res = json_decode($result, true);
//$job_code = $res[0] ['proj_jobcode'];
$page = mssql_escape($_POST['page']);
$pack_name = $cls_user->get_packdetails($pack_id);
//$job_code ='LE200239';
//$po_number='EK755PO1000001';
$job_code ='LE21MA54';
//$po_number = 'LE/LE21MA54/POD/21/000001';
$po_uploadcheck = $cls_comm->check_pouploaded($pack_id);

 $url = "http://tenv.swc.ltts.com/api/po_api_code.php?StrJobCode=$job_code&StrPONumber=$po_number";
//$url = "http://localhost/inventory/functions/po_api_code.php?StrJobCode=$job_code&StrPONumber=$po_number";
$log = file_get_contents($url);

//echo $url;

$newarr = json_decode($log);
$header = $newarr[0];
//print_r($header);
$mat_details = $header->invPOItemDetails;

$invPOItemDetails = $header->invPOItemDetails;
if ($page == 0) {
?>
    <div class="modal-header">
        <h4 class="modal-title" id="myLargeModalLabel">PO Details Entry</h4>
        <h3 style=" margin-left:35%; font-size: 16px; text-transform: uppercase; "><?php echo $pack_name['proj_name']; ?></h3>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    </div>
    <div class="row " style=" border: 1px solid black; border-radius: 0.5%; padding: 2%; margin: 0%;">

        <div class="col-md-6">
            <div class="form-group">
                <div class="row">
                    <div class=" col-md-4"><span class=" badge badge-primary ">PO Number</span></div>
                    <div class=" col-md-1" style=" color:black;"> : </div>
                    <div class=" col-md-7" style=" color:black;"><label> <?php echo $header->poNumber; ?></label></div>
                </div>

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <div class="row">
                    <div class=" col-md-4"><span class=" badge badge-primary ">PO Date</span></div>
                    <div class=" col-md-1" style=" color:black;"> : </div>
                    <div class=" col-md-7" style=" color:black;"><label> <?php echo formatDate($header->poDate, 'd-m-Y'); ?></label></div>
                </div>

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <div class="row">
                    <div class=" col-md-4"><span class=" badge badge-primary ">PO Start Date</span></div>
                    <div class=" col-md-1" style=" color:black;"> : </div>
                    <div class=" col-md-7" style=" color:black;"><label> <?php echo formatDate($header->poStartDate, 'd-m-Y'); ?></label></div>
                </div>

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <div class="row">
                    <div class=" col-md-4"><span class=" badge badge-primary ">PO End Date</span></div>
                    <div class=" col-md-1" style=" color:black;"> : </div>
                    <div class=" col-md-7" style=" color:black;"><label> <?php echo formatDate($header->poEndDate, 'd-m-Y'); ?></label></div>
                </div>

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <div class="row">
                    <div class=" col-md-4"><span class=" badge badge-primary ">Job Code </span></div>
                    <div class=" col-md-1" style=" color:black;"> : </div>
                    <div class=" col-md-7" style=" color:black;"><label> <?php echo $header->jobCode; ?></label></div>
                </div>


            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <div class="row">
                    <div class=" col-md-4"><span class=" badge badge-primary ">Supplier Code & Name</span></div>
                    <div class=" col-md-1" style=" color:black;"> : </div>
                    <div class=" col-md-7" style=" color:black;"><label> <?php echo $header->supplierID . '-' . $header->supplierName; ?></label></div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <div class="row">
                    <div class=" col-md-4"><span class=" badge badge-primary ">Warehouse & Name</span></div>
                    <div class=" col-md-1" style=" color:black;"> : </div>
                    <div class=" col-md-7" style=" color:black;"><label> <?php echo $header->warehouseCode . '-' . $header->warehouseDesc; ?></label></div>
                </div>

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <div class="row">
                    <div class=" col-md-4"><span class=" badge badge-primary ">Currency code & Desc</span></div>
                    <div class=" col-md-1" style=" color:black;"> : </div>
                    <div class=" col-md-7" style=" color:black;"><label> <?php echo $header->currencyCode . '-' . $header->currencyDesc; ?></label></div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <div class="row">
                    <div class=" col-md-4"><span class=" badge badge-primary ">Amendment Status</span></div>
                    <div class=" col-md-1" style=" color:black;"> : </div>
                    <div class=" col-md-7" style=" color:black;"><label> <?php echo $header->amendmentSatus; ?></label></div>
                </div>

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <div class="row">
                    <div class=" col-md-4"><span class=" badge badge-primary ">Amendment No</span></div>
                    <div class=" col-md-1" style=" color:black;"> : </div>
                    <div class=" col-md-7" style=" color:black;"><label> <?php echo $header->amendmentNumber; ?></label></div>
                </div>

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <div class="row">
                    <div class=" col-md-4"><span class=" badge badge-primary ">Po Tag</span></div>
                    <div class=" col-md-1" style=" color:black;"> : </div>
                    <div class=" col-md-7" style=" color:black;"><label> <?php echo $header->poTag; ?></label></div>
                </div>

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <div class="row">
                    <div class=" col-md-4"><span class=" badge badge-primary ">Po Type</span></div>
                    <div class=" col-md-1" style=" color:black;"> : </div>
                    <div class=" col-md-7" style=" color:black;"><label> <?php echo $header->poType; ?></label></div>
                </div>


            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <div class="row">
                    <div class=" col-md-4"><span class=" badge badge-primary ">Po Status</span></div>
                    <div class=" col-md-1" style=" color:black;"> : </div>
                    <div class=" col-md-7" style=" color:black;"><label> <?php echo $header->poStatus; ?></label></div>
                </div>


            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <div class="row">
                    <div class=" col-md-4"><span class=" badge badge-primary ">Stock Type Code Desc</span></div>
                    <div class=" col-md-1" style=" color:black;"> : </div>
                    <div class=" col-md-7" style=" color:black;"><label> <?php echo $header->stockTypeCodeDesc; ?></label></div>
                </div>


            </div>
        </div>

    </div>

    <hr>
    <table id="default_order" class="table1 table-bordered display compact" style="width:100%;">
        <thead style="background-color: #5F76E8 !important;">
            <tr>

                <!--<th>PoNumber</th>-->
                <th>Matrial Code</th>
                <th>Material Desc</th>
                <th>Uom Code</th>
                <th>Uom Desc</th>
                <th>Scope Qty</th>
                <th>Revised Qty</th>
                <th>HSN Code</th>
                <th>CPS Code</th>
                <th>WPS Code</th>

            </tr>
        </thead>
        <tbody id="po_details">
            <?php
            $key = 1;
            foreach ($invPOItemDetails as $value) {
            ?>
                <tr>
                    <!--<td><?php // echo $value->poNumber;       
                            ?></td>-->
                    <td><?php echo $value->materialCode; ?></td>
                    <!--<td><?php // echo $value->materialDesc;      
                            ?></td>-->
                    <td>
                        <?php if (strlen($value->materialDesc) < 30) { ?>
                            <span class="font-14" id="po_mat_desc"><?php echo wordwrap($value->materialDesc, 30, "<br>\n"); ?></span>
                        <?php } else { ?>
                            <span id="less<?php echo $key . 'pm'; ?>" class="  font-14 lessshow" style=" cursor: pointer;"><span style="font-weight: bolder"> </span> <?php echo substr(wordwrap($value->materialDesc, 20, "<br>\n"), 0, 40) . '....'; ?></span>
                            <span id="moreew<?php echo $key . 'pm'; ?>" class=" font-14 allshow" style=" cursor: pointer; display: none"><span style="font-weight: bolder"></span> <?php echo wordwrap($value->materialDesc, 40, "<br>\n"); ?></span>
                            <span id="rmore<?php echo $key . 'pm'; ?>" class="allshow1" style="color: #007bff;  cursor: pointer;" onclick="readmore('<?php echo $key . 'pm'; ?>')">Read more</span>
                            <span id="rless<?php echo $key . 'pm'; ?>" class="lessshow1" style="color: #007bff; cursor: pointer; display: none;" onclick="readless('<?php echo $key . 'pm'; ?>')">Read Less</span>

                        <?php } ?>

                    </td>
                    <td><?php echo $value->uom; ?></td>
                    <td><?php echo $value->uomDesc; ?></td>
                    <td><?php echo $value->scopeQty; ?></td>
                    <td><?php echo $value->revisedQty; ?></td>
                    <td><?php echo $value->hsN_Code; ?></td>
                    <td><?php echo $value->cpscode; ?></td>
                    <td><?php echo $value->wbscode; ?></td>
                </tr>
            <?php
                $key++;
            }
            ?>
        </tbody>
    </table>
    <br>
    <div class="text-right">
        <?php if ($po_uploadcheck != 1) { ?>
            <button type="button" name="save_deatils" id="save_deatils" onclick="save_deatils('1')" class="btn btn-info">Save</button>
            <button type="button" class="btn btn-primary dnone" id="saving"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Saving Please wait ... </button>
        <?php } ?>
    </div>
    <!-- <div class="modal-footer">
        <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Close</button>
    </div> -->
<?php
} else {

    $po_projid = $projid;
    //PoHeader Insert

    $sqlH = "select * from poHeaderApi where poNumber='" . $header->poNumber . "'";
    $queryH = mssql_query($sqlH);
    $num_rowsH = mssql_num_rows($queryH);
    if ($num_rowsH > 0) {
    } else {
        $sqlH_id = "SELECT ISNULL(MAX(poHid+1), 1) AS id FROM poHeaderApi";
        $id_queryH = mssql_query($sqlH_id);
        $id_rowH = mssql_fetch_array($id_queryH);
        $poHid = $id_rowH['id'];


        $sqlH_insert = "insert into poHeaderApi (poHid,poNumber,poDate,poStartDate,poEndDate,jobCode,supplierID,supplierName,warehouseCode,
                        warehouseDesc,currencyCode,currencyDesc,amendmentSatus,amendmentNumber,poTag,poType,
                        poStatus,stockTypeCodeDesc) values('" . $poHid . "','" . $header->poNumber . "','" . formatDate($header->poDate, 'Y-m-d') . "','" . formatDate($header->poStartDate, 'Y-m-d') . "','" . formatDate($header->poEndDate, 'Y-m-d') . "',
                        '" . $header->jobCode . "','" . $header->supplierID . "','" . $header->supplierName . "','" . $header->warehouseCode . "','" . $header->warehouseDesc . "',
                        '" . $header->currencyCode . "','" . $header->currencyDesc . "','" . $header->amendmentSatus . "','" . $header->amendmentNumber . "','" . $header->poTag . "','" . $header->poType . "',
                        '" . $header->poStatus . "','" . $header->stockTypeCodeDesc . "')";

        $qH = mssql_query($sqlH_insert);
    }

    foreach ($invPOItemDetails as $value) {
        $sql = "select * from po_master where po_number='" . $value->poNumber . "' and po_mat_code ='" . $value->materialCode . "' and po_projid='" . $po_projid . "' ";
        $query = mssql_query($sql);
        $num_rows = mssql_num_rows($query);
        if ($num_rows > 0) {
        } else {
        }
        $po_number = $value->poNumber;
        $matcode = $value->materialCode;
        $mat_desc = $value->materialDesc;
        $currency = strtoupper($header->currencyDesc);
        $revisedQty = $value->revisedQty;
        $hsnCode = $value->hsN_Code;
        $cpsCode = $value->cpscode;
        $wpsCode = $value->wbscode;

        if (strtoupper($header->currencyDesc) == "INR") {
            $forex = 1;
        } else {
            $forex = '';
        }

        $uom = $value->uomDesc;
        $qty = $value->scopeQty;

        $sql = "INSERT INTO swift_po_master(po_id,po_number,po_sup_id,po_mat_code,po_mat_desc,
            po_uom,po_rate,po_scope_qty,po_create_date,po_projid,po_currency,revisedQty,hsnCode,cpsCode,wpsCode,po_pack_id)
                VALUES((SELECT ISNULL(MAX(po_id+1), 1) AS id FROM swift_po_master),'" . $po_number . "','" . $header->supplierID . "',
                '" . $matcode . "','" . $mat_desc . "','" . $uom . "','" . $revisedQty . "','" . $qty . "',GETDATE(),'" . $po_projid . "','" . $currency  . "',
                '" . $revisedQty . "','" . $hsnCode . "','" . $cpsCode . "','" . $wpsCode . "','" . $pack_id . "')";

        $insert_query = mssql_query($sql);
    }
    if ($insert_query) {
        echo 1;
    } else {
        echo 0;
    }
}
?>
<?php ?>
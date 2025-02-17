<?php
include 'config/inc.php';
//$generate_token = generate_token();
// echo "uma"; exit();
if (isset($_POST['mat'])) {
    $Did = $_POST['id'];
    $mat = $_POST['mat'];

    $stages = array();
    $lead = $_POST['lead'];
    $matreq = formatDate(str_replace('/', '-', $mat), 'Y-m-d');
    // $matreq = date('Y-m-d', strtotime(str_replace('/', '-', $mat)));
    $userlist = " select * from usermst where usertype =(SELECT b.usertype FROM swift_workflow_details  as a
    inner join swift_stage_master as b on a.stage_id=b.stage_id
    WHERE a.mst_id = $Did ORDER BY a.Did OFFSET 2 ROWS FETCH NEXT 1 ROW ONLY)";
    $user_query = mssql_query($userlist);
    // $urows = mssql_fetch_array($user_query);
    $select = '<select class="custom-select" name="user_filter" id="user_filter" required="">
       <option value="">--Select User--</option>';
    while ($urows = mssql_fetch_array($user_query)) {
        $name = $urows['name'];
        $uid = $urows['uid'];
        $select .= '<option value="' . $uid . '">' . $name . '</option>';
    }
    $select .= '</select>';
    $select_html = $select;
    $Workstagecount = "SELECT sum(target_day) as  row_count from swift_workflow_details WHERE mst_id = '$Did' AND active=1 and stage_id!=1";
    $scount_query = mssql_query($Workstagecount);
    $rows = mssql_fetch_array($scount_query);
    $scount = $rows['row_count'];

    $diff = ($scount - 1);
    // echo $Workstagecount;
    // $diff = 15; 
    $WorkDetailSql = "SELECT * FROM swift_workflow_details WHERE mst_id = '$Did' AND active=1 and stage_id!=1";
    $querywf = mssql_query($WorkDetailSql);
    $previous = '';
    $i = 0;
    $num_rows = mssql_num_rows($querywf);
    while ($row_wf = mssql_fetch_array($querywf)) {
        $Days = $row_wf['target_day'];

        // echo $Days;echo "<br>";
        $stage_ids = $row_wf['stage_id'];
        if ($i == 0) {
            //$stages[1] = date('d-M-y', strtotime(formatDate($org, 'Y-m-d') . (int)$diff . 'days'));
            $stages[$stage_ids] = date('Y-m-d', strtotime(formatDate($mat, 'Y-m-d') . '-' . (int)$diff . 'days'));
            // }elseif ($i == $num_rows ) {
            //     $stages[$stage_ids] = $matreq;
        } else {
            $stages[$stage_ids] = date('Y-m-d', strtotime(formatDate($previous, 'Y-m-d') . (int)$Days . 'days'));
        }
        $previous = $stages[$stage_ids];

        $i++;
    }
    $html = '<table id="table"  class="table table-bordered border scrolldiv">
                <thead>
                    <tr>
                       <th>slno</th>
                       <th>Stage Name</th>
                       <th>Date</th>
                    </tr>
                </thead>
                <tbody id="clear_data">';
    $counts = 1;
    $result1 = $cls_comm->WorkFlowStage_master($Did);
    $res1 = json_decode($result1, true);
    foreach ($res1 as $key => $value1) {

        $stage_id = $value1['stage_id'];
        $stagename = $value1['stage_name'];

        if ($counts <= 24) {
            $data = formatDate($stages[$stage_id], 'd-M-y');
            $status = 'checked';
        } else {
            unset($data);
            $status = '';
        }
        $html .= '<tr>
                                <td id="sum">' . $counts . '</td>
                                <td>' . $stagename . '</td>
                                <td><input style="border: 0px none;"  readonly value="' . $data . '" name="dates[]" id="result' . $counts . '"type="text" > <input style="border: 0px none;"  readonly value="' . $stage_id . '" name="stages[]" id="resultstage' . $counts . '"type="hidden" ></td>
                            </tr>';
        $counts = $counts + 1;
    }
    $html .= '</tbody>
            </table>';
    // echo $html;
    $table_html = $html;

    echo '<div class="form-row"> 
            <div class="col-md-3 mb-3 id="table-table-responsive">' . $select_html . '</div>';
    echo '<div  class="col-md-12 mb-3  id="userfilter">' . $table_html . '</div>
    </div>';
}

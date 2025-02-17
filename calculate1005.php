<?php
include 'config/inc.php';
//$generate_token = generate_token();

if (isset($_POST['mat'])) {
    $Did = $_POST['id'];
    $mat = $_POST['mat'];
    
    $stages = array();
    $lead = $_POST['lead'];
    $matreq = formatDate(str_replace('/', '-', $mat), 'Y-m-d');

    $Workstagecount = "SELECT sum(target_day) as row_count from swift_workflow_details WHERE mst_id = '$Did' AND active=1 ";
    $scount_query = mssql_query($Workstagecount);
    $rows = mssql_fetch_array($scount_query);
    $scount = $rows['row_count'];

    $diff = ($scount-1); 
    // $diff = ($scount+$lead); 
    $WorkDetailSql = "SELECT * FROM swift_workflow_details WHERE mst_id = '$Did' AND active=1 ";
    $querywf = mssql_query($WorkDetailSql);
    $previous = '';
    $i = 0;
    $num_rows = mssql_num_rows($querywf);
    while ($row_wf = mssql_fetch_array($querywf)) {
        $Days      = $row_wf['target_day'];
        //echo $Days;echo "<br>";
        $stage_ids = $row_wf['stage_id'];
        if ($i == 0) {
            //$stages[1] = date('d-M-y', strtotime(formatDate($org . '-', 'Y-m-d') . $diff . 'days'));
            // echo $diff;
            $stages[$stage_ids] = date('d-M-y', strtotime(formatDate($mat . '-', 'Y-m-d') . $diff . 'days')); 
        // }elseif ($i == $num_rows ) {
        //     $stages[$stage_ids] = $matreq;
        }else{
            $stages[$stage_ids] = date('d-M-y', strtotime(formatDate($previous, 'Y-m-d') . $Days . 'days'));
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
            echo $html;
}

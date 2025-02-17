<?php

if(isset($_POST['mat'])&& isset($_POST['lead'])){
	$i=$_POST['id'];
	$mat=$_POST['mat'];
	 $stages = array();
		$lead=$_POST['lead'];
	 $matreq = formatDate(str_replace('/', '-', $mat), 'Y-m-d');
      // $orgs = formatDate(str_replace('/', '-', $org), 'Y-m-d');
	    $diff = ($lead + 54); //15-23-6-15
            $stages[1] = date('d-M-y', strtotime(formatDate($matreq . '-', 'Y-m-d') . $diff . 'days')); //1Contracts to Ops    
            $stages[2] = formatDate($stages[1] . '+1 days', 'Y-m-d'); //2Ops to Engineering SPOC
            $stages[3] = formatDate($stages[1] . '+1 days', 'Y-m-d'); //3$SPOC_to_Tech_Expert
            $stages[4] = formatDate($stages[3] . '+5 days', 'Y-m-d'); //4$Tech_Expert_Clerance - Expert to Reviewer
            $stages[5] = formatDate($stages[3] . '+6 days', 'Y-m-d'); //5$Tech_Expert_to_CTO_for_approval - Reviewer to CTO Approval
            $stages[6] = formatDate($stages[5] . '+2 days', 'Y-m-d'); //6$CTO_Approval
            $stages[7] = formatDate($stages[5] . '+2 days', 'Y-m-d'); //7$Tech_SPOC_toOps
            $stages[8] = formatDate($stages[5] . '+2 days', 'Y-m-d'); //8$OpstoOM
            $stages[9] = formatDate($stages[8] . '+3 days', 'Y-m-d'); //9$OMApproval
            $stages[10] = formatDate($stages[8] . '+3 days', 'Y-m-d'); //10$OMtoOps 
            $stages[11] = formatDate($stages[10] . '+1 days', 'Y-m-d'); //11$OpshandingovertoSCM
            $stages[12] = formatDate($stages[10] . '+1 days', 'Y-m-d'); //12$AcutalOpshandingovertoSCM
            $stages[13] = formatDate($stages[12] . '+1 days', 'Y-m-d'); //13$FileAcceptancefromOpsDate
            $stages[14] = formatDate($stages[12] . '+1 days', 'Y-m-d'); //14$FileReceivedDateRevised
            $stages[15] = formatDate($stages[14] . '+12 days', 'Y-m-d'); //15$ExpectedDateofOrderClosing
            $stages[16] = formatDate($stages[14] . '+12 days', 'Y-m-d'); //16$PackageSentDate
            $stages[17] = formatDate($stages[16] . '+4 days', 'Y-m-d'); //17$PackageApprovedDate
            $stages[18] = formatDate($stages[17] . '+2 days', 'Y-m-d'); //18$LOIdate
            $stages[19] = formatDate($stages[18] . '+2 days', 'Y-m-d'); //19$EMRdate
            $stages[20] = formatDate($stages[19] . '+3 days', 'Y-m-d'); //20$PODate
            $stages[21] = formatDate($stages[20] . '+2 days', 'Y-m-d'); //21$POApprovedDate
            $stages[22] = formatDate($stages[18] . '+3 days', 'Y-m-d'); //22$WODate
            $stages[23] = formatDate($stages[22] . '+2 days', 'Y-m-d'); //23$WOApprovedDate
			  $stages[24] = formatDate($stages[21] . '+7 days', 'Y-m-d'); //24$LCDate
			   $stages[25] = formatDate($stages[21] . '+3 days', 'Y-m-d'); //25$VendortoOpsDrawingSamplePOCSubmission
              $stages[26] = formatDate($stages[25] . '+1 days', 'Y-m-d'); //26$OpstoEngineeringVendor Drawing/POC
              $stages[27] = formatDate($stages[26] . '+2 days', 'Y-m-d'); //27$EngineeringtoOpsforVendorDesignApproval
              $stages[28] = formatDate($stages[27] . '+1 days', 'Y-m-d'); //28$OpstoVendorApprovedDrawing
              $stages[29] = formatDate($stages[28] . '+2 days', 'Y-m-d'); //29$ManufacturingClearance
               $inf = ($lead + 2);
               $stages[30] = date('d-M-y', strtotime(formatDate($stages[29] . '+', 'Y-m-d') . $inf . 'days')); //30$Inspection
              $stages[31] = formatDate($stages[30] . '+2 days', 'Y-m-d'); //31$MDCC 
              $stages[32] = formatDate($stages[31] . '+15 days', 'Y-m-d'); //32$CustomClearanceDate
              $stages[33] = formatDate($stages[31] . '+3 days', 'Y-m-d'); //33$Mtlsreceivedatsite
              $stages[34] = formatDate($stages[33] . '+2 days', 'Y-m-d'); //34$MRN


	
	echo json_encode(array('date'=>date('d-M-y',strtotime($stages[$i]))));
	
	
	
	
	
}




?>
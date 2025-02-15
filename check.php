<?php

if(isset($_POST['mat'])&& isset($_POST['lead'])){
	$i=$_POST['id'];
	$mat=$_POST['mat'];
	 $stages = array();
		$lead=$_POST['lead'];
	 $matreq = date('Y-m-d', strtotime(str_replace('/', '-', $mat)));
      // $orgs = date('Y-m-d', strtotime(str_replace('/', '-', $org)));
	    $diff = ($lead + 54); //15-23-6-15
            $stages[1] = date('Y-m-d', strtotime($matreq . '-' . $diff . 'days')); //1Contracts to Ops    
            $stages[2] = date('Y-m-d', strtotime($stages[1] . '+1 days')); //2Ops to Engineering SPOC
            $stages[3] = date('Y-m-d', strtotime($stages[1] . '+1 days')); //3$SPOC_to_Tech_Expert
            $stages[4] = date('Y-m-d', strtotime($stages[3] . '+5 days')); //4$Tech_Expert_Clerance - Expert to Reviewer
            $stages[5] = date('Y-m-d', strtotime($stages[3] . '+6 days')); //5$Tech_Expert_to_CTO_for_approval - Reviewer to CTO Approval
            $stages[6] = date('Y-m-d', strtotime($stages[5] . '+2 days')); //6$CTO_Approval
            $stages[7] = date('Y-m-d', strtotime($stages[5] . '+2 days')); //7$Tech_SPOC_toOps
            $stages[8] = date('Y-m-d', strtotime($stages[5] . '+2 days')); //8$OpstoOM
            $stages[9] = date('Y-m-d', strtotime($stages[8] . '+3 days')); //9$OMApproval
            $stages[10] = date('Y-m-d', strtotime($stages[8] . '+3 days')); //10$OMtoOps 
            $stages[11] = date('Y-m-d', strtotime($stages[10] . '+1 days')); //11$OpshandingovertoSCM
            $stages[12] = date('Y-m-d', strtotime($stages[10] . '+1 days')); //12$AcutalOpshandingovertoSCM
            $stages[13] = date('Y-m-d', strtotime($stages[12] . '+1 days')); //13$FileAcceptancefromOpsDate
            $stages[14] = date('Y-m-d', strtotime($stages[12] . '+1 days')); //14$FileReceivedDateRevised
            $stages[15] = date('Y-m-d', strtotime($stages[14] . '+12 days')); //15$ExpectedDateofOrderClosing
            $stages[16] = date('Y-m-d', strtotime($stages[14] . '+12 days')); //16$PackageSentDate
            $stages[17] = date('Y-m-d', strtotime($stages[16] . '+4 days')); //17$PackageApprovedDate
            $stages[18] = date('Y-m-d', strtotime($stages[17] . '+2 days')); //18$LOIdate
            $stages[19] = date('Y-m-d', strtotime($stages[18] . '+2 days')); //19$EMRdate
            $stages[20] = date('Y-m-d', strtotime($stages[19] . '+3 days')); //20$PODate
            $stages[21] = date('Y-m-d', strtotime($stages[20] . '+2 days')); //21$POApprovedDate
            $stages[22] = date('Y-m-d', strtotime($stages[18] . '+3 days')); //22$WODate
            $stages[23] = date('Y-m-d', strtotime($stages[22] . '+2 days')); //23$WOApprovedDate
			  $stages[24] = date('Y-m-d', strtotime($stages[21] . '+7 days')); //24$LCDate
			   $stages[25] = date('Y-m-d', strtotime($stages[21] . '+3 days')); //25$VendortoOpsDrawingSamplePOCSubmission
              $stages[26] = date('Y-m-d', strtotime($stages[25] . '+1 days')); //26$OpstoEngineeringVendor Drawing/POC
              $stages[27] = date('Y-m-d', strtotime($stages[26] . '+2 days')); //27$EngineeringtoOpsforVendorDesignApproval
              $stages[28] = date('Y-m-d', strtotime($stages[27] . '+1 days')); //28$OpstoVendorApprovedDrawing
              $stages[29] = date('Y-m-d', strtotime($stages[28] . '+2 days')); //29$ManufacturingClearance
               $inf = ($lead + 2);
               $stages[30] = date('Y-m-d', strtotime($stages[29] . '+' . $inf . 'days')); //30$Inspection
              $stages[31] = date('Y-m-d', strtotime($stages[30] . '+2 days')); //31$MDCC 
              $stages[32] = date('Y-m-d', strtotime($stages[31] . '+15 days')); //32$CustomClearanceDate
              $stages[33] = date('Y-m-d', strtotime($stages[31] . '+3 days')); //33$Mtlsreceivedatsite
              $stages[34] = date('Y-m-d', strtotime($stages[33] . '+2 days')); //34$MRN


	
	echo json_encode(array('date'=>date('d-M-y',strtotime($stages[$i]))));
	
	
	
	
	
}




?>
<!-- ============================================================== -->
<!-- Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->
<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <?php if ($_SESSION['usertype'] == 2 || $_SESSION['usertype'] == 20) { ?>
                    <li class="sidebar-item">
                        <a href="buyer_dash" class="sidebar-link">
                            <i class="mdi mdi-av-timer"></i>
                            <span class="hide-menu">Action Board</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="CommanDashboard" class="sidebar-link">
                            <i class="mdi mdi-av-timer"></i>
                            <span class="hide-menu">OverAll</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="dash_version1" class="sidebar-link">
                            <i class="mdi mdi-av-timer"></i>
                            <span class="hide-menu">Version-1 Reports</span>
                        </a>
                    </li>
                    <?php if ($_SESSION['report_access'] == 'checked') { ?>
                        <li class="sidebar-item">
                            <a href="dashboard" class="sidebar-link">
                                <i class="mdi mdi-export"></i>
                                <span class="hide-menu">Report Dashboard</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="procurement_tracker" class="sidebar-link">
                                <i class="mdi mdi-export"></i>
                                <span class="hide-menu">Procurement Tracker</span>
                            </a>
                        </li>
                    <?php }
                    ?>

                    <!-- <li class="sidebar-item">
                        <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                            <i class="mdi mdi-apps"></i>
                            <span class="hide-menu">Main Menu</span>
                        </a>
                        <ul aria-expanded="false" class="collapse first-level">
                            <li class="sidebar-item">
                                <a href="buyer_workflow" class="sidebar-link">
                                    <i class="mdi mdi-comment-processing-outline"></i>
                                    <span class="hide-menu">Work Flow</span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a href="buyer_repository" class="sidebar-link">
                                    <i class="mdi mdi-comment-processing-outline"></i>
                                    <span class="hide-menu">Repository</span>
                                </a>
                            </li>
                        </ul>
                    </li> -->
                    <div class="devider"></div>
                <?php } ?>
                <?php if ($_SESSION['usertype'] == 3) { ?>
                    <li class="sidebar-item">
                        <a href="dashboard" class="sidebar-link">
                            <i class="mdi mdi-av-timer"></i>
                            <span class="hide-menu">Dashboard</span>
                        </a>
                    </li>

                    <div class="devider"></div>
                <?php } ?>

                <?php if ($_SESSION['usertype'] == 5) { ?>
                    <li class="sidebar-item">
                        <a href="ops_dashboard" class="sidebar-link">
                            <i class="mdi mdi-av-timer"></i>
                            <span class="hide-menu">Action Board</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="dash_version1" class="sidebar-link">
                            <i class="mdi mdi-av-timer"></i>
                            <span class="hide-menu">Version-1 Reports</span>
                        </a>
                    </li>
                    <?php if ($_SESSION['report_access'] == 'checked') { ?>
                        <li class="sidebar-item">
                            <a href="dashboard" class="sidebar-link">
                                <i class="mdi mdi-export"></i>
                                <span class="hide-menu">Report Dashboard</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="procurement_tracker" class="sidebar-link">
                                <i class="mdi mdi-export"></i>
                                <span class="hide-menu">Procurement Tracker</span>
                            </a>
                        </li>
                    <?php }
                    ?>

                    <!--                    <li class="sidebar-item">
                                            <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                                                <i class="mdi mdi-apps"></i>
                                                <span class="hide-menu">Approval</span>
                                            </a>
                                            <ul aria-expanded="false" class="collapse first-level">
                                                <li class="sidebar-item">
                                                    <a href="files_from_contract" class="sidebar-link">
                                                        <i class="mdi mdi-menu"></i>
                                                        <span class="hide-menu">Files From Contractor</span>
                                                    </a>
                                                </li>
                                                <li class="sidebar-item">
                                                    <a href="files_for_techspoc" class="sidebar-link">
                                                        <i class="mdi mdi-menu"></i>
                                                        <span class="hide-menu">Files For Tech. Spoc</span>
                                                    </a>
                                                </li>
                                                <li class="sidebar-item">
                                                    <a href="files_from_CTO" class="sidebar-link">
                                                        <i class="mdi mdi-menu"></i>
                                                        <span class="hide-menu">Files From CTO</span>
                                                    </a>
                                                </li>
                                                <li class="sidebar-item">
                                                    <a href="files_from_OM" class="sidebar-link">
                                                        <i class="mdi mdi-menu"></i>
                                                        <span class="hide-menu">Files From O & M</span>
                                                    </a>
                                                </li>
                                                <li class="sidebar-item">
                                                    <a href="files_from_SCM" class="sidebar-link">
                                                        <i class="mdi mdi-menu"></i>
                                                        <span class="hide-menu">Files From SCM</span>
                                                    </a>
                                                </li>
                                                <li class="sidebar-item">
                                                    <a href="files_for_techapproval" class="sidebar-link">
                                                        <i class="mdi mdi-menu"></i>
                                                        <span class="hide-menu">Files Expert/Workflow</span>
                                                    </a>
                                                </li>
                                                <li class="sidebar-item">
                                                    <a href="files_from_smartsignoff" class="sidebar-link">
                                                        <i class="mdi mdi-file-video"></i>
                                                        <span class="hide-menu">Files for PO Entry</span>
                                                    </a>
                                                </li>                          
                                            </ul>
                                        </li>
                    -->
                    <li class="sidebar-item">
                        <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                            <i class="mdi mdi-book-plus"></i>
                            <span class="hide-menu">Packages</span>
                        </a>
                        <ul aria-expanded="false" class="collapse first-level">

                            <li class="sidebar-item">
                                <a href="package_master" class="sidebar-link">
                                    <i class="mdi mdi-bowling"></i>
                                    <span class="hide-menu">Package Master</span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a href="package_category_master" class="sidebar-link">
                                    <i class="mdi mdi-bowling"></i>
                                    <span class="hide-menu">Package Category Master</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <div class="devider"></div>
                <?php } ?>

                <?php if ($_SESSION['usertype'] == 6) { ?>
                    <li class="sidebar-item">
                        <a href="dashboard" class="sidebar-link">
                            <i class="mdi mdi-av-timer"></i>
                            <span class="hide-menu">Dashboard</span>
                        </a>
                    </li>
                    <?php if ($_SESSION['report_access'] == 'checked') { ?>
                        <li class="sidebar-item">
                            <a href="dashboard" class="sidebar-link">
                                <i class="mdi mdi-export"></i>
                                <span class="hide-menu">Report Dashboard</span>
                            </a>
                        </li>
                    <?php }
                    ?>

                    <li class="sidebar-item none">
                        <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                            <i class="mdi mdi-apps"></i>
                            <span class="hide-menu">Create Project</span>
                        </a>
                        <ul aria-expanded="false" class="collapse first-level">
                            <li class="sidebar-item">
                                <a href="files_from_contract" class="sidebar-link">
                                    <i class="mdi mdi-receipt"></i>
                                    <span class="hide-menu">Files From Contracts</span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a href="package_master" class="sidebar-link">
                                    <i class="mdi mdi-creation"></i>
                                    <span class="hide-menu">Package Master</span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a href="ops_coordinator_workflow" class="sidebar-link">
                                    <i class="mdi mdi-menu"></i>
                                    <span class="hide-menu">Work Flow</span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a href="ops_coordinator_repository" class="sidebar-link">
                                    <i class="mdi mdi-file-document-box"></i>
                                    <span class="hide-menu">Repository</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <div class="devider"></div>
                <?php } ?>

                <?php if ($_SESSION['usertype'] == 7) { ?>
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link">
                            <i class="mdi mdi-av-timer"></i>
                            <span class="hide-menu">Action Board</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="dash_version1" class="sidebar-link">
                            <i class="mdi mdi-av-timer"></i>
                            <span class="hide-menu">Version-1 Reports</span>
                        </a>
                    </li>
                    <?php if ($_SESSION['report_access'] == 'checked') { ?>
                        <li class="sidebar-item">
                            <a href="dashboard" class="sidebar-link">
                                <i class="mdi mdi-export"></i>
                                <span class="hide-menu">Report Dashboard</span>
                            </a>
                        </li>
                    <?php }
                    ?>

                    <li class="sidebar-item">
                        <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                            <i class="mdi mdi-apps"></i>
                            <span class="hide-menu">Main Menu</span>
                        </a>
                        <ul aria-expanded="false" class="collapse first-level">
                            <li class="sidebar-item">
                                <a href="scm_workflow" class="sidebar-link">
                                    <i class="mdi mdi-comment-processing-outline"></i>
                                    <span class="hide-menu">Work Flow</span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a href="scm_repository" class="sidebar-link">
                                    <i class="mdi mdi-comment-processing-outline"></i>
                                    <span class="hide-menu">Repository</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <div class="devider"></div>
                <?php } ?>

                <?php if ($_SESSION['usertype'] == 8) { ?>
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link">
                            <i class="mdi mdi-av-timer"></i>
                            <span class="hide-menu">Action board</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="dash_version1" class="sidebar-link">
                            <i class="mdi mdi-av-timer"></i>
                            <span class="hide-menu">Version-1 Reports</span>
                        </a>
                    </li>
                    <?php if ($_SESSION['report_access'] == 'checked') { ?>
                        <li class="sidebar-item">
                            <a href="dashboard" class="sidebar-link">
                                <i class="mdi mdi-export"></i>
                                <span class="hide-menu">Report Dashboard</span>
                            </a>
                        </li>
                    <?php }
                    ?>

                    <li class="sidebar-item">
                        <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                            <i class="mdi mdi-apps"></i>
                            <span class="hide-menu">Create Project</span>
                        </a>
                        <ul aria-expanded="false" class="collapse first-level">
                            <li class="sidebar-item">
                                <a href="project_master" class="sidebar-link">
                                    <i class="mdi mdi-comment-processing-outline"></i>
                                    <span class="hide-menu">Project Master</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <div class="devider"></div>
                <?php } ?>

                <?php if ($_SESSION['usertype'] == 9) { ?>
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link">
                            <i class="mdi mdi-av-timer"></i>
                            <span class="hide-menu">Action board</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="dash_version1" class="sidebar-link">
                            <i class="mdi mdi-av-timer"></i>
                            <span class="hide-menu">Version-1 Reports</span>
                        </a>
                    </li>
                    <?php if ($_SESSION['report_access'] == 'checked') { ?>
                        <li class="sidebar-item">
                            <a href="dashboard" class="sidebar-link">
                                <i class="mdi mdi-export"></i>
                                <span class="hide-menu">Report Dashboard</span>
                            </a>
                        </li>
                    <?php }
                    ?>

                    <li class="sidebar-item">
                        <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                            <i class="mdi mdi-apps"></i>
                            <span class="hide-menu">Create Project</span>
                        </a>
                        <ul aria-expanded="false" class="collapse first-level">
                            <li class="sidebar-item">
                                <a href="project_master" class="sidebar-link">
                                    <i class="mdi mdi-comment-processing-outline"></i>
                                    <span class="hide-menu">Project Master</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <div class="devider"></div>
                <?php } ?>
                <?php if ($_SESSION['usertype'] == 10) { ?>
                    <li class="sidebar-item">
                        <a href="CommanDashboard" class="sidebar-link">
                            <i class="mdi mdi-av-timer"></i>
                            <span class="hide-menu">OverAll</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="dash_version1" class="sidebar-link">
                            <i class="mdi mdi-av-timer"></i>
                            <span class="hide-menu">Version-1 Reports</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <!-- <a href="tech_spoc" class="sidebar-link">
                            <i class="mdi mdi-av-timer"></i>
                            <span class="hide-menu">Action Board</span>
                        </a> -->
                        <a href="swift_workflow" class="sidebar-link">
                            <i class="mdi mdi-av-timer"></i>
                            <span class="hide-menu">Action Board</span>
                        </a>
                    </li>
                    <!-- <li class="sidebar-item">
                        <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                            <i class="mdi mdi-apps"></i>
                            <span class="hide-menu">Document Name Setting</span>
                        </a>
                        <ul aria-expanded="false" class="collapse first-level">
                            <li class="sidebar-item">
                                <a href="doctype" class="sidebar-link">
                                    <i class="mdi mdi-comment-processing-outline"></i>
                                    <span class="hide-menu">Doc Type Bid/Internal </span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a href="teamcode" class="sidebar-link">
                                    <i class="mdi mdi-comment-processing-outline"></i>
                                    <span class="hide-menu">Team Code </span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a href="setcode" class="sidebar-link">
                                    <i class="mdi mdi-comment-processing-outline"></i>
                                    <span class="hide-menu">Document Set Code </span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a href="systemcode" class="sidebar-link">
                                    <i class="mdi mdi-comment-processing-outline"></i>
                                    <span class="hide-menu">System Code </span>
                                </a>
                            </li>
                        </ul>
                    </li> -->
                    <?php if ($_SESSION['report_access'] == 'checked') { ?>
                        <li class="sidebar-item">
                            <a href="dashboard" class="sidebar-link">
                                <i class="mdi mdi-export"></i>
                                <span class="hide-menu">Report Dashboard</span>
                            </a>
                        </li>
                    <?php }
                    ?>

                    <!--                   <li class="sidebar-item">
                                            <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                                                <i class="mdi mdi-apps"></i>
                                                <span class="hide-menu">Main Menu</span>
                                            </a>
                                            <ul aria-expanded="false" class="collapse first-level">
                                                <li class="sidebar-item">
                                                    <a href="tech_spoc_workflow" class="sidebar-link">
                                                        <i class="mdi mdi-comment-processing-outline"></i>
                                                        <span class="hide-menu">Work Flow</span>
                                                    </a>
                                                </li>
                                                <li class="sidebar-item">
                                                    <a href="tech_spoc_repository" class="sidebar-link">
                                                        <i class="mdi mdi-comment-processing-outline"></i>
                                                        <span class="hide-menu">Repository</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>  -->
                    <div class="devider"></div>
                <?php } ?>

                <?php if ($_SESSION['usertype'] == 11) { ?>
                    <li class="sidebar-item">
                        <a href="CommanDashboard" class="sidebar-link">
                            <i class="mdi mdi-av-timer"></i>
                            <span class="hide-menu">OverAll</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="dash_version1" class="sidebar-link">
                            <i class="mdi mdi-av-timer"></i>
                            <span class="hide-menu">Version-1 Reports</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="swift_workflow" class="sidebar-link">
                            <i class="mdi mdi-av-timer"></i>
                            <span class="hide-menu">Action Board</span>
                        </a>
                    </li>
                    <!-- <li class="sidebar-item">
                        <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                            <i class="mdi mdi-apps"></i>
                            <span class="hide-menu">Document Name Setting</span>
                        </a>
                        <ul aria-expanded="false" class="collapse first-level">
                            <li class="sidebar-item">
                                <a href="doctype" class="sidebar-link">
                                    <i class="mdi mdi-comment-processing-outline"></i>
                                    <span class="hide-menu">Doc Type Bid/Internal </span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a href="teamcode" class="sidebar-link">
                                    <i class="mdi mdi-comment-processing-outline"></i>
                                    <span class="hide-menu">Team Code </span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a href="setcode" class="sidebar-link">
                                    <i class="mdi mdi-comment-processing-outline"></i>
                                    <span class="hide-menu">Document Set Code </span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a href="systemcode" class="sidebar-link">
                                    <i class="mdi mdi-comment-processing-outline"></i>
                                    <span class="hide-menu">System Code </span>
                                </a>
                            </li>
                        </ul>
                    </li> -->
                    <?php if ($_SESSION['report_access'] == 'checked') { ?>
                        <li class="sidebar-item">
                            <a href="dashboard" class="sidebar-link">
                                <i class="mdi mdi-export"></i>
                                <span class="hide-menu">Report Dashboard</span>
                            </a>
                        </li>
                    <?php }
                    ?>

                    <!--                    <li class="sidebar-item">
                                            <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                                                <i class="mdi mdi-apps"></i>
                                                <span class="hide-menu">Main Menu</span>
                                            </a>
                                            <ul aria-expanded="false" class="collapse first-level">
                                                <li class="sidebar-item">
                                                    <a href="tech_expert_workflow" class="sidebar-link">
                                                        <i class="mdi mdi-comment-processing-outline"></i>
                                                        <span class="hide-menu">Files From SPOC</span>
                                                    </a>
                                                </li>
                                                <li class="sidebar-item">
                                                    <a href="files_for_technical_approval" class="sidebar-link">
                                                        <i class="mdi mdi-comment-processing-outline"></i>
                                                        <span class="hide-menu">Files For Tech Approval</span>
                                                    </a>
                                                </li>
                                                <li class="sidebar-item">
                                                    <a href="tech_expert_repository" class="sidebar-link">
                                                        <i class="mdi mdi-comment-processing-outline"></i>
                                                        <span class="hide-menu">Repository</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>-->
                    <div class="devider"></div>
                <?php } ?>

                <?php if ($_SESSION['usertype'] == 12) { ?>
                    <li class="sidebar-item">
                        <a href="CommanDashboard" class="sidebar-link">
                            <i class="mdi mdi-av-timer"></i>
                            <span class="hide-menu">OverAll</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="dash_version1" class="sidebar-link">
                            <i class="mdi mdi-av-timer"></i>
                            <span class="hide-menu">Version-1 Reports</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="swift_workflow" class="sidebar-link">
                            <i class="mdi mdi-av-timer"></i>
                            <span class="hide-menu">Action Board</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="dash_version1" class="sidebar-link">
                            <i class="mdi mdi-av-timer"></i>
                            <span class="hide-menu">Version-1 Reports</span>
                        </a>
                    </li>
                    <!--                    <li class="sidebar-item">
                        <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                            <i class="mdi mdi-apps"></i>
                            <span class="hide-menu">Document Name Setting</span>
                        </a>
                        <ul aria-expanded="false" class="collapse first-level">
                            <li class="sidebar-item">
                                <a href="doctype" class="sidebar-link">
                                    <i class="mdi mdi-comment-processing-outline"></i>
                                    <span class="hide-menu">Doc Type Bid/Internal </span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a href="teamcode" class="sidebar-link">
                                    <i class="mdi mdi-comment-processing-outline"></i>
                                    <span class="hide-menu">Team Code </span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a href="setcode" class="sidebar-link">
                                    <i class="mdi mdi-comment-processing-outline"></i>
                                    <span class="hide-menu">Document Set Code </span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a href="systemcode" class="sidebar-link">
                                    <i class="mdi mdi-comment-processing-outline"></i>
                                    <span class="hide-menu">System Code </span>
                                </a>
                            </li>
                        </ul>
                    </li>-->
                    <?php if ($_SESSION['report_access'] == 'checked') { ?>
                        <li class="sidebar-item">
                            <a href="dashboard" class="sidebar-link">
                                <i class="mdi mdi-export"></i>
                                <span class="hide-menu">Report Dashboard</span>
                            </a>
                        </li>
                    <?php }
                    ?>

                    <!--                    <li class="sidebar-item">
                                            <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                                                <i class="mdi mdi-apps"></i>
                                                <span class="hide-menu">Main Menu</span>
                                            </a>
                                            <ul aria-expanded="false" class="collapse first-level">
                                                <li class="sidebar-item">
                                                    <a href="tech_cto_workflow" class="sidebar-link">
                                                        <i class="mdi mdi-comment-processing-outline"></i>
                                                        <span class="hide-menu">Work Flow</span>
                                                    </a>
                                                </li>
                                                <li class="sidebar-item">
                                                    <a href="tech_cto_repository" class="sidebar-link">
                                                        <i class="mdi mdi-comment-processing-outline"></i>
                                                        <span class="hide-menu">Repository</span>
                                                    </a>
                                                </li>   
                                            </ul>
                                        </li>-->
                    <div class="devider"></div>
                <?php } ?>

                <?php if ($_SESSION['usertype'] == 13) { ?>
                    <li class="sidebar-item">
                        <a href="finance" class="sidebar-link">
                            <i class="mdi mdi-av-timer"></i>
                            <span class="hide-menu">Action Board</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="dash_version1" class="sidebar-link">
                            <i class="mdi mdi-av-timer"></i>
                            <span class="hide-menu">Version-1 Reports</span>
                        </a>
                    </li>
                    <?php if ($_SESSION['report_access'] == 'checked') { ?>
                        <li class="sidebar-item">
                            <a href="dashboard" class="sidebar-link">
                                <i class="mdi mdi-export"></i>
                                <span class="hide-menu">Report Dashboard</span>
                            </a>
                        </li>
                    <?php }
                    ?>

                    <li class="sidebar-item">
                        <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                            <i class="mdi mdi-apps"></i>
                            <span class="hide-menu">LC Master</span>
                        </a>
                        <ul aria-expanded="false" class="collapse first-level">
                            <li class="sidebar-item">
                                <a href="bank_master" class="sidebar-link">
                                    <i class="mdi mdi-comment-processing-outline"></i>
                                    <span class="hide-menu">Bank Master</span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a href="cp_master" class="sidebar-link">
                                    <i class="mdi mdi-comment-processing-outline"></i>
                                    <span class="hide-menu">Credit Period Master</span>
                                </a>
                            </li>

                        </ul>
                    </li>
                    <div class="devider"></div>
                    <li class="sidebar-item">
                        <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                            <i class="mdi mdi-application"></i>
                            <span class="hide-menu">Transactions </span>
                        </a>
                        <ul aria-expanded="false" class="collapse first-level">

                            <li class="sidebar-item">
                                <a href="lc_creation" class="sidebar-link">
                                    <i class="mdi mdi-comment-processing-outline"></i>
                                    <span class="hide-menu">LC Creation / Extension</span>
                                </a>
                            </li>

                            <li class="sidebar-item">
                                <a href="lc_supply" class="sidebar-link">
                                    <i class="mdi mdi-comment-processing-outline"></i>
                                    <span class="hide-menu">LC Supply Updation</span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a href="lc_payment" class="sidebar-link">
                                    <i class="mdi mdi-comment-processing-outline"></i>
                                    <span class="hide-menu">LC Payment Updation</span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a href="lc_extension" class="sidebar-link">
                                    <i class="mdi mdi-comment-processing-outline"></i>
                                    <span class="hide-menu">LC Extension</span>
                                </a>
                            </li>

                        </ul>
                    </li>
                    <div class="devider"></div>
                    <li class="sidebar-item">
                        <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                            <i class="mdi mdi-file-document-box"></i>
                            <span class="hide-menu">LC Reports</span>
                        </a>
                        <ul aria-expanded="false" class="collapse first-level">

                            <li class="sidebar-item">
                                <a href="lc_report" class="sidebar-link">
                                    <i class="mdi mdi-comment-processing-outline"></i>
                                    <span class="hide-menu">LC Report</span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a href="supply_payment_report" class="sidebar-link">
                                    <i class="mdi mdi-comment-processing-outline"></i>
                                    <span class="hide-menu">Supply & Payment Report</span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a href="lc_payment_log" class="sidebar-link">
                                    <i class="mdi mdi-comment-processing-outline"></i>
                                    <span class="hide-menu">Payment Log</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <div class="devider"></div>
                <?php } ?>

                <?php if ($_SESSION['usertype'] == 14) { ?>
                    <li class="sidebar-item">
                        <a href="swift_workflow" class="sidebar-link">
                            <i class="mdi mdi-av-timer"></i>
                            <span class="hide-menu">Action Board</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="CommanDashboard" class="sidebar-link">
                            <i class="mdi mdi-av-timer"></i>
                            <span class="hide-menu">OverAll</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="dash_version1" class="sidebar-link">
                            <i class="mdi mdi-av-timer"></i>
                            <span class="hide-menu">Version-1 Reports</span>
                        </a>
                    </li>
                    <?php if ($_SESSION['report_access'] == 'checked') { ?>
                        <li class="sidebar-item">
                            <a href="dashboard" class="sidebar-link">
                                <i class="mdi mdi-export"></i>
                                <span class="hide-menu">Report Dashboard</span>
                            </a>
                        </li>
                    <?php }
                    ?>

                    <li class="sidebar-item">
                        <a href="package_category_master_edit" class="sidebar-link">
                            <i class="mdi mdi-bowling"></i>
                            <span class="hide-menu">Package Category Master</span>
                        </a>
                    </li>

                    <div class="devider"></div>
                <?php } ?>

                <?php if ($_SESSION['usertype'] == 15) { ?>
                    <li class="sidebar-item">
                        <a href="CommanDashboard" class="sidebar-link">
                            <i class="mdi mdi-av-timer"></i>
                            <span class="hide-menu">OverAll</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="dash_version1" class="sidebar-link">
                            <i class="mdi mdi-av-timer"></i>
                            <span class="hide-menu">Version-1 Reports</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="swift_workflow" class="sidebar-link">
                            <i class="mdi mdi-av-timer"></i>
                            <span class="hide-menu">Action Board</span>
                        </a>
                    </li>
                    <?php if ($_SESSION['report_access'] == 'checked') { ?>
                        <li class="sidebar-item">
                            <a href="dashboard" class="sidebar-link">
                                <i class="mdi mdi-export"></i>
                                <span class="hide-menu">Report Dashboard</span>
                            </a>
                        </li>
                    <?php }
                    ?>

                    <!--                    <li class="sidebar-item">
                                            <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                                                <i class="mdi mdi-apps"></i>
                                                <span class="hide-menu">Main Menu</span>
                                            </a>
                                            <ul aria-expanded="false" class="collapse first-level">
                                                <li class="sidebar-item">
                                                    <a href="om_workflow" class="sidebar-link">
                                                        <i class="mdi mdi-comment-processing-outline"></i>
                                                        <span class="hide-menu">Work Flow</span>
                                                    </a>
                                                </li>
                                                <li class="sidebar-item">
                                                    <a href="om_repository" class="sidebar-link">
                                                        <i class="mdi mdi-comment-processing-outline"></i>
                                                        <span class="hide-menu">Repository</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>-->
                    <div class="devider"></div>
                <?php } ?>
                <?php if ($_SESSION['usertype'] == 18) { ?>
                    <li class="sidebar-item">
                        <a href="CommanDashboard" class="sidebar-link">
                            <i class="mdi mdi-av-timer"></i>
                            <span class="hide-menu">OverAll</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="dash_version1" class="sidebar-link">
                            <i class="mdi mdi-av-timer"></i>
                            <span class="hide-menu">Version-1 Reports</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="swift_workflow" class="sidebar-link">
                            <i class="mdi mdi-av-timer"></i>
                            <span class="hide-menu">Action Board</span>
                        </a>
                    </li>
                <?php } ?>
                <?php if ($_SESSION['usertype'] == 0) { ?>

                    <li class="sidebar-item">
                        <a href="dashboard" class="sidebar-link">
                            <i class="mdi mdi-av-timer"></i>
                            <span class="hide-menu">OverAll</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="dash_version1" class="sidebar-link">
                            <i class="mdi mdi-av-timer"></i>
                            <span class="hide-menu">Version-1 Reports</span>
                        </a>
                    </li>
                    <!-- <li class="sidebar-item">
                        <a href="package_category_master_edit" class="sidebar-link">
                            <i class="mdi mdi-bowling"></i>
                            <span class="hide-menu">Package Category Master</span>
                        </a>
                    </li> -->
                    <li class="sidebar-item">
                        <a href="admin" class="sidebar-link">
                            <i class="mdi mdi-av-timer"></i>
                            <span class="hide-menu">Calender</span>
                        </a>
                    </li>

                    <li class="sidebar-item">
                        <a href="stage_master" class="sidebar-link">
                            <i class="mdi mdi-comment-processing-outline"></i>
                            <span class="hide-menu">Stage Master</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="workflowmaster" class="sidebar-link">
                            <i class="mdi mdi-bowling"></i>
                            <span class="hide-menu">Work Flow Master</span>
                        </a>
                    </li>
                    <!-- <li class="sidebar-item">
                        <a href="master_email_setting" class="sidebar-link">
                            <i class="mdi mdi-inbox"></i>
                            <span class="hide-menu">SMTP Email Setting</span>
                        </a>
                    </li> -->
                    <li class="sidebar-item">
                        <a href="ops_email_setting" class="sidebar-link">
                            <i class="mdi mdi-settings"></i>
                            <span class="hide-menu">OPS Email Setting</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                            <i class="mdi mdi-apps"></i>
                            <span class="hide-menu">Document Name Setting</span>
                        </a>
                        <ul aria-expanded="false" class="collapse first-level">
                            <li class="sidebar-item">
                                <a href="doctype" class="sidebar-link">
                                    <i class="mdi mdi-comment-processing-outline"></i>
                                    <span class="hide-menu">Doc Type Bid/Internal </span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a href="teamcode" class="sidebar-link">
                                    <i class="mdi mdi-comment-processing-outline"></i>
                                    <span class="hide-menu">Team Code </span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a href="setcode" class="sidebar-link">
                                    <i class="mdi mdi-comment-processing-outline"></i>
                                    <span class="hide-menu">Document Set Code </span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a href="systemcode" class="sidebar-link">
                                    <i class="mdi mdi-comment-processing-outline"></i>
                                    <span class="hide-menu">System Code </span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <div class="devider"></div>
                <?php } ?>
                <?php if ($_SESSION['usertype'] == 21) { ?>
                   
                    <li class="sidebar-item">
                        <a href="site_ops_dash" class="sidebar-link">
                            <i class="mdi mdi-av-timer"></i>
                            <span class="hide-menu">Action Board</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="dash_version1" class="sidebar-link">
                            <i class="mdi mdi-av-timer"></i>
                            <span class="hide-menu">Version-1 Reports</span>
                        </a>
                    </li>

                    <div class="devider"></div>
                <?php } ?>

            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
<!-- ============================================================== -->
<!-- End Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->

<!-- sample modal content -->
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-xl">
        <div class="modal-content" id="reports_content" style=" width: 117%; margin-left: -10%; margin-top: 0%;">

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<!-- sample modal content -->

<!-- /.modal -->

<!-- sample modal content -->
<div class="modal fade" id="exampleModal_vendetail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
    <div class="modal-dialog" role="document">
        <div class="modal-content" id="ven_details" style=" width: 150%; margin-left: -8.5%; margin-top: -1%;">









        </div>

    </div>
</div>
<!-- /.modal -->

<!-- sample modal content -->
<div class="modal fade" id="delaymodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style=" width: 120%;" id="delaytable">


        </div>

    </div>
</div>
<div class="modal fade" id="checklistmodal" style=" z-index: 99999" aria-labelledby="exampleModalLabel1">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style=" width: 180%;  margin-left: -190px;" id="checklisttable">


        </div>

    </div>
</div>
<!-- /.modal -->
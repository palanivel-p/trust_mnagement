<?php
//Include("connection.php");
//$api_key = $_COOKIE['panel_api_key'];


?>

    <div class="nav-header" style="background-color: #e5f0f3">
    <!-- <h1>#e5f0f3;</h1> -->
        <a href="../dashboard/" class="brand-logo">
<!--            <img class="logo-abbr" src="../images/Logo_new.png" alt="">-->
            <img class="logo-abbr" src="../images/favicon.png" alt="">
            <img class="logo-compact" src="../images/Logo_new.png" alt="">
            <img class="brand-title" src="../images/Logo_new.png" alt="">
<!--           <strong><h5 style ="text-align: center; justify-content: center;">TRUST SOFTWARE</h5></strong>-->
        </a>
        <div class="nav-control">
            <div class="hamburger">
                <span class="line"></span><span class="line"></span><span class="line"></span>
            </div>
        </div>
    </div>


    <div class="header">
        <div class="header-content">
            <nav class="navbar navbar-expand">
                <div class="collapse navbar-collapse justify-content-between">
                    <div class="header-left">
                        <div class="dashboard_bar">

                            <?php echo  $header_name; ?>
                        </div>
                    </div>
                    <div>
                        <a class="btn btn-primary" href="../transaction/" role="button" style= "margin-left: 40px;">Transaction</a>
<!--                        <button type="button" class="btn btn-primary mb-2" style = "color:white;"><a href="../transaction/"></a>Transaction</button>-->
<!--                        <a href="../transaction/"><button type="button" class="btn btn-primary mb-2"></button>Transaction</a>-->
<!--                       <a href="../transaction/" style= "margin-left: 330px;font-size: 50px; color: #1336b1;'">-->
<!--						<i class="fa-solid fa-print fa-beat"></i></a>-->
						
						<!-- <a href="../transaction/"><span class="material-symbols-outlined"></span></a>-->
                        
                    </div>
               
                    <ul class="navbar-nav header-right">
                        <li class="nav-item">

                        </li>
                        <li class="nav-item dropdown notification_dropdown">

                        </li>
                        <li class="nav-item dropdown notification_dropdown">


                        </li>
                        <li class="nav-item dropdown header-profile">
                            <a class="nav-link" href="javascript:void(0)" role="button" data-toggle="dropdown">
                                <img src="../img/avatar.jpg" width="20" alt="">
                                <div class="header-info">

                                    <span class="text-black" style ="text-transform:capitalize;"><?php echo $_COOKIE['role']; ?></span>
                                    <span class="text-black" style ="text-transform:capitalize;"><?php echo $_COOKIE['name']; ?></span>
                                    <span class="text-black" style ="text-transform:capitalize;"><?php echo $_COOKIE['branch']; ?></span>
                                    <p class="fs-12 mb-0">
                                        <?php

                                        date_default_timezone_set("Asia/Calcutta");

                                        if (date("H") < 12) {

                                            echo "Good Morning !";

                                        } elseif (date("H") > 11 && date("H") < 17) {

                                            echo "Good Afternoon !";

                                        } elseif (date("H") > 16) {

                                            echo "Good Evening !";

                                        }

                                        ?>
                                    </p>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item ai-icon">
                                    <svg id="icon-user1" xmlns="http://www.w3.org/2000/svg" class="text-primary"
                                         width="18" height="18" viewbox="0 0 24 24" fill="none" stroke="currentColor"
                                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </svg>
                                    <span class="ml-2"><?php  echo $_COOKIE['role'];?></span>
                                </a>

                                <a href="../login?logout=1" class="dropdown-item ai-icon">
                                    <svg id="icon-logout" xmlns="http://www.w3.org/2000/svg" class="text-danger"
                                         width="18" height="18" viewbox="0 0 24 24" fill="none" stroke="currentColor"
                                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                        <polyline points="16 17 21 12 16 7"></polyline>
                                        <line x1="21" y1="12" x2="9" y2="12"></line>
                                    </svg>
                                    <span class="ml-2">Logout </span>
                                </a>
                            </div>

                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>

<div class="dlabnav">
    <div class="dlabnav-scroll">
<!--        <div class="dlabnav-scroll" style="background: #0f0f3f; ">-->
        <ul class="metismenu" id="menu">
            <?php
//            if($_COOKIE['role'] == "owner")
//            {
                ?>
            <li><a class="ai-icon" href="../dashboard/" aria-expanded="false">
                    <i class="flaticon-381-television"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>

            <?php
                      if($_COOKIE['role'] != "Staff") {
                          if($_COOKIE['role'] != "Admin") {


                              ?>
                              <li><a class="ai-icon" href="../branch_profile/" aria-expanded="false">
                                      <i class="flaticon-381-list"></i>
                                      <span class="nav-text">Branch Profile</span>
                                  </a>
                              </li>
                              <?php

                          }
                              ?>
                          <li><a class="ai-icon" href="../staff_profile/" aria-expanded="false">
                                  <i class="flaticon-381-user-4"></i>
                                  <span class="nav-text">Staff Profile</span>
                              </a>
                          </li>
                          <?php
                      }
            ?>
            <?php
            if($_COOKIE['role'] != "Staff") {

                ?>
            <li><a class="ai-icon" href="../doner_profile/" aria-expanded="false">
                    <i class="flaticon-381-id-card-1"></i>
                    <span class="nav-text">Doner Profile</span>
                </a>
            </li>

            <li><a class="ai-icon" href="../batch_profile/" aria-expanded="false">
                    <i class="flaticon-381-clock-1"></i>
                    <span class="nav-text">Batch Profile</span>
                </a>
            </li>
                <?php
            }
            ?>
            <li><a class="ai-icon" href="../transaction/" aria-expanded="false">
                    <i class="flaticon-381-send"></i>
                    <span class="nav-text">Transaction</span>
                </a>
            </li>
            <?php
            if($_COOKIE['role'] != "Staff") {

                ?>
            <li><a class="ai-icon" href="../report/" aria-expanded="false">
                    <i class="flaticon-381-search-3"></i>
                    <span class="nav-text">Report</span>
                </a>
            </li>
            <?php
                      }
            ?>
            <li><a class="ai-icon" href="../receipt/" aria-expanded="false">
                    <i class="flaticon-381-print"></i>
                    <span class="nav-text">Receipt</span>
                </a>
            </li>

            <?php
//            }
//            elseif ($_COOKIE['cookie_value_2'] == "admin") {
                ?>

                <?php
//            }


            ?>
        </ul>

        <div class="copyright">
            <p><strong>Trust  Admin Dashboard</strong> © <?php echo date('Y')?> All Rights Reserved</p>
<!--            <p>Made with <span class="heart"></span> by <a href="https://www.gbtechcorp.co.in/" target="_blank">GB TECH CORP</a></p>-->
        </div>
    </div>
</div>










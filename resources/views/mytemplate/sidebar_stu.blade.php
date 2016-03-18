
  <!-- Left side column. contains the sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <h4>|</h4>
        </div>
        <div class="pull-left info">
          <p>Hello,<?php  $user = (Auth::check() ? Auth::user()->lastname : "guest").' !'; echo ' '.$user ?></p>
        </div>
      </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li id="list_1" class="">
                <a href="/student/dashboard">
                    <i class="fa fa-home"></i> <span>Dashboard</span>
                </a>
            </li>
            <!-- <li id="sidebar_list_2" class="treeview">
                <a href="">
                    <i class="fa fa-list-ul"></i>
                    <span>Transcript</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li id="sidebar_list_2_1"><a href="/teacher/transcript"><i class="fa fa-angle-double-right"></i>Transcript Manage</a></li>
                    <li id="sidebar_list_2_2"><a href="/teacher/view_transcript"><i class="fa fa-angle-double-right"></i>View Transcript</a></li>
                </ul>
            </li> -->
            <li id="sidebar_transcript">
                <a href="/student/transcript">
                    <i class="fa fa-book"></i> <span>Transcript</span>
                </a>
            </li>
            <li id="sidebar_mailbox">
                <a href="/student/mailbox">
                    <i class="fa fa-envelope-o"></i> <span>Mail Box</span>
                </a>
            </li>
            <li>
                <a href="/auth/logout">
                    <i class="glyphicon glyphicon-log-out"></i> <span>Logout</span>
                </a>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
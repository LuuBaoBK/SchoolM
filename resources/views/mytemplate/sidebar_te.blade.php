<!-- =============================================== -->

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
                <a href="/teacher/dashboard">
                    <i class="fa fa-home"></i> <span>Profile</span>
                </a>
            </li>
            <li id="sidebar_schedule" class="">
                <a href="/teacher/schedule">
                    <i class="fa fa-calendar"></i> <span>Schedule</span>
                </a>
            </li>
            <li id="sidebar_noticeboard" class="">
                <a href="/teacher/noticeboard">
                    <i class="fa fa-newspaper-o"></i> <span>Notice Board</span>
                </a>
            </li>
            <li id="sidebar_list_2" class="treeview">
                <a href="">
                    <i class="fa fa-list-ul"></i>
                    <span>Transcript</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li id="sidebar_list_2_1"><a href="/teacher/transcript"><i class="fa fa-angle-double-right"></i>Transcript Manage</a></li>
                    <li id="sidebar_list_2_2"><a href="/teacher/view_transcript"><i class="fa fa-angle-double-right"></i>View Transcript</a></li>
                </ul>
            </li>
            <li id="list_manage_class" class="">
                <a href="/teacher/manage-class">
                    <i class="fa fa-file-text"></i> <span>Manage Class</span>
                </a>
            </li>
            <li id="list_student_list" class="">
                <a href="/teacher/student-list">
                    <i class="fa fa-search"></i> <span>Student List</span>
                </a>
            </li>
            <li id="sidebar_mailbox">
                <a href="/teacher/mailbox">
                    <i class="fa fa-envelope-o"></i> <span>Mail Box</span><span id="mail_count" class="label label-primary pull-right" style="font-size: 14px">{{$mail_count}}</span>
                </a>
            </li>
            <li id="list_4">
                <a href="/auth/logout">
                    <i class="glyphicon glyphicon-log-out"></i> <span>Logout</span>
                </a>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
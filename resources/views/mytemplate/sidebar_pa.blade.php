
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
                <a href="/parents/dashboard">
                    <i class="fa fa-home"></i> <span>Profile</span>
                </a>
            </li>
            <li id="sidebar_tkb" class="">
                <a href="/parents/schedule">
                    <i class="fa fa-calendar"></i> <span>Schedule</span>
                </a>
            </li>
            <li id="sidebar_teacher_list" class="">
                <a href="/parents/teacher_list">
                    <i class="fa fa-search"></i> <span>Teacher List</span>
                </a>
            </li>
            <li id="sidebar_transcript">
                <a href="/parents/transcript">
                    <i class="fa fa-list-ul"></i> <span>Transcript</span>
                </a>
            </li>
            <li id="sidebar_notice" class="">
                <a href="/parents/notice_board">
                    <i class="fa fa-calendar"></i> <span>Notice Board</span>
                </a>
            </li>
            <li id="sidebar_mailbox">
                <a href="/parents/mailbox">
                    <i class="fa fa-envelope-o"></i> <span>Mail Box</span><span id="mail_count" class="label label-primary pull-right" style="font-size: 14px">{{$mail_count}}</span>
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
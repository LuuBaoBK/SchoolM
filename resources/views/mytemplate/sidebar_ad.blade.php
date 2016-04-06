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
            <li id="sidebar_list_1" class="">
                <a href="/admin/dashboard">
                    <i class="fa fa-home"></i> <span>Dashboard</span>
                </a>
            </li>
            <li id="sidebar_list_2" class="treeview">
                <a href="">
                    <i class="fa fa-users"></i>
                    <span>User Manage</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li id="sidebar_list_2_1"><a href="/admin/manage-user/admin"><i class="fa fa-angle-double-right"></i>Admin</a></li>
                    <li id="sidebar_list_2_2"><a href="/admin/manage-user/teacher"><i class="fa fa-angle-double-right"></i>Teacher</a></li>
                    <li id="sidebar_list_2_3"><a href="/admin/manage-user/student"><i class="fa fa-angle-double-right"></i>Student</a></li>
                    <li id="sidebar_list_2_4"><a href="/admin/manage-user/parent"><i class="fa fa-angle-double-right"></i>Parent</a></li>
                </ul>
            </li>
            <li id="sidebar_list_3" class="treeview">
                <a href="">
                    <i class="fa fa-th"></i>
                    <span>Class</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li id="sidebar_list_3_1"><a href="/admin/class/classinfo"><i class="fa fa-angle-double-right"></i>Class Info</a></li>
                    <li id="sidebar_list_3_2"><a href="/admin/class/studentclassinfo"><i class="fa fa-angle-double-right"></i>Student List</a></li>
                </ul>
            </li>
            <li id="sidebar_list_4" class="treeview">
                <a href="">
                    <i class="fa fa-th-list"></i>
                    <span>Catalog Manage</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li id="sidebar_list_4_1"><a href="/admin/addsubject"><i class="fa fa-book"></i> <span>Subject Manager</span></a></li>
                    <li id="sidebar_list_4_2"><a href="/admin/position"><i class="fa fa-file-text-o"></i> <span>Position Manager</span></a></li>
                </ul>
            </li>
            <li id="sidebar_list_5" class="treeview">
                <a href="">
                    <i class="fa fa-th-list"></i>
                    <span>Transcript Manage</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li id="sidebar_list_5_1"><a href="/admin/transcript/general"><i class="fa fa-file-text-o"></i> <span>General Setting</span></a></li>
                </ul>
            </li>
            <li id="sidebar_list_7">
                <a href="/admin/menuschedule">
                    <i class="fa fa-calendar"></i> <span>Schedule Manager</span>
                </a>
            </li>
            <li id="sidebar_mailbox">
                <a href="/admin/mailbox">
                    <i class="fa fa-envelope-o"></i> <span>Mail Box</span>
                </a>
            </li>
            <li>
                <a href="/admin/homepage_edit">
                    <i class="glyphicon glyphicon-edit"></i> <span>Home Page Edit</span>
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

  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
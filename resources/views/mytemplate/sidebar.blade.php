<!-- Left side column. contains the logo and sidebar -->
<aside class="left-side sidebar-offcanvas">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left info">
                <p>Hello,<?php  $user = (Auth::check() ? Auth::user()->fullname : "guest").' !'; echo ' '.$user ?></p>
            </div>
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="active">
                <a href="/admin/dashboard">
                    <i class="fa fa-home"></i> <span>Dashboard</span>
                </a>
            </li>
            <li class="treeview">
                <a href="">
                    <i class="fa fa-th"></i>
                    <span>User Manage</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="/admin/manage-user/admin"><i class="fa fa-angle-double-right"></i>Admin</a></li>
                    <li><a href="/admin/manage-user/teacher"><i class="fa fa-angle-double-right"></i>Teacher</a></li>
                    <li><a href="/admin/manage-user/student"><i class="fa fa-angle-double-right"></i>Student</a></li>
                    <li><a href="/admin/manage-user/parent"><i class="fa fa-angle-double-right"></i>Parent</a></li>
                    <li><a href="/admin/manage-user/userlist"><i class="fa fa-angle-double-right"></i>User List</a></li>
                </ul>
            </li>
            <li>
                <a href="/admin/addsubject">
                    <i class="fa fa-book"></i> <span>Subject Manager</span>
                </a>
            </li>
            <li>
                <a href="schedule">
                    <i class="fa fa-calendar"></i> <span>Schedule Manager</span>
                </a>
            </li>
            <li>
                <a href="transcript">
                    <i class="fa fa-file-text-o"></i> <span>Transcript Manager</span>
                </a>
            </li>
            <li class="treeview">
                <a href="">
                    <i class="fa fa-th"></i>
                    <span>Class</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="/admin/classinfo"><i class="fa fa-angle-double-right"></i>Class Info</a></li>
                    <li><a href="#!"><i class="fa fa-angle-double-right"></i>Student List</a></li>
                    <li><a href="#!"><i class="fa fa-angle-double-right"></i>???</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="">
                    <i class="fa fa-th"></i>
                    <span>Student In Class</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="/schoolm/public/admin/studentclassinfo"><i class="fa fa-angle-double-right"></i>Class Info</a></li>
                    <li><a href="#!"><i class="fa fa-angle-double-right"></i>Student List</a></li>
                    <li><a href="#!"><i class="fa fa-angle-double-right"></i>???</a></li>
                </ul>
            </li>
            <li>
                <a href="/auth/logout">
                    <i class="glyphicon glyphicon-log-out"></i> <span>Logout</span>
                </a>
            </li>
        </ul>
    </section>
</aside>
    <!-- /.sidebar -->
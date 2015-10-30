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
                <a href="dashboard">
                    <i class="fa fa-home"></i> <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="adduser">
                    <i class="fa fa-male"></i> <span>User Register</span>
                </a>
            </li>
            <li class="treeview">
                <a href="">
                    <i class="fa fa-th"></i>
                    <span>Class</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="#!"><i class="fa fa-angle-double-right"></i>Class Info</a></li>
                    <li><a href="#!"><i class="fa fa-angle-double-right"></i>Student List</a></li>
                    <li><a href="#!"><i class="fa fa-angle-double-right"></i>???</a></li>
                </ul>
            </li>
            <li>
                <a href="../auth/logout">
                    <i class="glyphicon glyphicon-log-out"></i> <span>Logout</span>
                </a>
            </li>
        </ul>
    </section>
</aside>
    <!-- /.sidebar -->
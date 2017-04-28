<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin Panel | Business Directory</title>

    {!! HTML::style('css/bootstrap.min.css') !!}
    {!! HTML::style('css/bootstrap-select.min.css') !!}
    {!! HTML::style('css/sb-admin.css') !!}
    {!! HTML::style('css/font-awesome.min.css') !!}

    @yield('styles')


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{{ URL::to('admin') }}}">Business Directory - Admin Panel</a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">

                <li><a href="{{{ URL::to('') }}}">View website</a></li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> {{{ Auth::User()->email }}} <b class="caret"></b></a>
                    <ul class="dropdown-menu">

                        <li><a href="{{{ URL::to('logout') }}}"><i class="fa fa-fw fa-power-off"></i> Logout</a></li>


                    </ul>
                </li>
            </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li class="{{ Request::is('admin') ? 'active' : ''}}"><a href="{{{ URL::to('admin') }}}"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a></li>
                    <li class="{{ Request::is('admin/listings') ? 'active' : ''}}"><a href="{{{ URL::to('admin/listings') }}}"><i class="fa fa-fw fa-folder"></i> Listings</a></li>
                    <li class="{{ Request::is('admin/categories') ? 'active' : ''}}"><a href="{{{ URL::to('admin/categories') }}}"><i class="fa fa-fw fa-book"></i> Categories</a></li>
                    <li class="{{ Request::is('admin/users') ? 'active' : ''}}"><a href="{{{ URL::to('admin/users') }}}"><i class="fa fa-fw fa-users"></i> Users</a></li>
                    <li class="{{ Request::is('admin/news') ? 'active' : ''}}"><a href="{{{ URL::to('admin/news') }}}"><i class="fa fa-fw fa-newspaper-o"></i> News</a></li>
                    <li class="{{ Request::is('admin/roles') ? 'active' : ''}} disabled"><a href="{{{ URL::to('admin/roles') }}}"><i class="fa fa-fw fa-circle-o "></i> Roles</a></li>
                    <li class="{{ Request::is('admin/permissions') ? 'active' : ''}} disabled"><a href="{{{ URL::to('admin/permissions') }}}"><i class="fa fa-fw fa-lock"></i> Permissions</a></li>
                    <li class="{{ Request::is('admin/claims') ? 'active' : ''}}"><a href="{{{ URL::to('admin/claims') }}}"><i class="fa fa-fw fa-check-square-o"></i> Claims</a></li>
                    <li class="{{ Request::is('admin/approve-listings') ? 'active' : ''}}"><a href="{{{ URL::to('admin/approve-listings') }}}"><i class="fa fa-fw fa-check-square-o"></i> Approve Listings</a></li>
                    <li class="{{ Request::is('admin/verify-listings') ? 'active' : ''}}"><a href="{{{ URL::to('admin/verify-listings') }}}"><i class="fa fa-fw fa-check-square-o"></i> Verify Listings</a></li>
                    <li class="{{ Request::is('admin/settings') ? 'active' : ''}}"><a href="{{{ URL::to('admin/settings') }}}"><i class="fa fa-fw fa-cog"></i> Settings</a></li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">

            <div class="container-fluid">

            @if (Session::has('flash_notification.message'))
              <div style="margin-top:10px;">
              @include('flash::message')
              </div>
            @endif

            <!-- Content -->
            @yield('content')

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->


    <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    Do you really want to delete this?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-danger btn-ok">Delete</a>
                </div>
            </div>
        </div>
    </div>


    {!! HTML::script('js/jquery-1.11.3.min.js') !!}
    {!! HTML::script('js/bootstrap.min.js') !!}
    {!! HTML::script('js/bootstrap-select.min.js') !!}

    <script>
    $('#confirm-delete').on('show.bs.modal', function(e) {
        $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
    });
    </script>

    @yield('scripts')


</body>

</html>

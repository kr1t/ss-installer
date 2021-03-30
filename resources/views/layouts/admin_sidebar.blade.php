<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('admin') }}" class="brand-link">

        <span class="brand-text font-weight-light text-center">{{ config('app.name', 'Laravel') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">

            <div class="info">
                <a href="#" class="d-block">{{ Auth::user()->name }}

                    <hr>
                    <div aria-labelledby="navbarDropdown">
                        <a class="btn btn-outline-light" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                                                                 document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </a>
            </div>
        </div>


        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">


                <li class="nav-header">Menu</li>
                <li class="nav-item">
                    <a href="{{ url('/admin/installer/export') }}" class="nav-link">
                        <i class="fas fa-file-export"></i>
                        <p>
                            Export Installer Lists
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/admin/installer/import') }}" class="nav-link">
                        <i class="fas fa-file-upload"></i>
                        <p>
                            Import Installer Lists
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('/admin/point/import') }}" class="nav-link">
                        <i class="fas fa-star"></i>
                        <p>
                            Import Point Lists
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('/admin/installer/multicast/tel') }}" class="nav-link">
                        <i class="fas fa-phone-square"></i>
                        <p>
                            Muticast By Tel No.
                        </p>
                    </a>
                </li>


            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>

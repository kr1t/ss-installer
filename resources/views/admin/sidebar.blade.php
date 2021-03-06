<div class="col-md-3 mb-4">
    <div class="card">
        <div class="card-header">
            Menu
        </div>

        <div class="card-body">

            <nav class="nav flex-column">
                <a class="nav-link" href="{{ url('/admin/installer/export') }}">
                    Export Installer Lists (Register)
                </a>
                <a class="nav-link" href="{{ url('/admin/installer/import') }}">
                    Import Installer Lists (SWAT id)
                </a>
                <a class="nav-link" href="{{ url('/admin/point/import') }}">
                    Import Point Lists
                </a>
                <a class="nav-link" href="{{ url('/admin/permission/silver-import') }}">
                    Import Silver Permission Lists
                </a>
                <a class="nav-link" href="{{ url('/admin/permission/gold-import') }}">
                    Import Gold Permission Lists
                </a>

                <a class="nav-link" href="{{ url('/admin/') }}">
                    Muticast By Tel No.
                </a>

            </nav>

        </div>
    </div>
</div>

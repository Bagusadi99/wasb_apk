<div id="sidebar">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header position-relative">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center justify-content-center mb-4">
                    <a href="index.html"><img src="{{ asset('template/dist/assets/compiled/png/logotransjatim.png') }}"
                        alt="Logo" style="width: 65px; height: 65px !important;"></a>
                    <div class="ms-4 text-justify">
                        <h6 class="mb-0 text-success">WASB</h6>
                        <h6 class="text-success" style="font-size: 12px">Pengawasan Kebersihan</h6>
                    </div>
                </div> 
                <div class="sidebar-toggler  x">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle" style="color: #4A8939;"></i></a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu mt-3">
                <li class="sidebar-item {{ Request::is('admin/dashadmin') ? 'active' : '' }}">
                    <a href="{{ route('admin.dashadmin') }}" class='sidebar-link'>
                        <i class="bi bi-grid-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="sidebar-item {{ Request::is('pengawas') ? 'active' : '' }}">
                    <a href="{{ route('admin.pengawas.list_pengawas') }}" class='sidebar-link'>
                        <i class="bi bi-person-standing"></i>
                        <span>Pengawas</span>
                    </a>
                </li>
                <li class="sidebar-item {{ Request::is('shift') ? 'active' : '' }}">
                    <a href="{{ route('admin.shift.list_shift') }}" class='sidebar-link'>
                        <i class="bi bi-alarm-fill"></i>
                        <span>Shift</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    <a href="#" class='sidebar-link'
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="bi bi-door-closed-fill"></i>
                        <span>Keluar.</span>
                    </a>
                </li>

            </ul>
        </div>
    </div>
</div>

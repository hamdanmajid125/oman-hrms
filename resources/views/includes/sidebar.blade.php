<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" data-key="t-menu">Menu</li>

                <li>
                    <a href="{{ route('dashboard') }}">
                        <i class="mdi mdi-home"></i>
                        <span data-key="t-dashboard">Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i class="fas fa-users"></i>
                        <span data-key="t-apps">Users</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li>
                            <a href="{{ route('roles.index') }}">
                                <span data-key="t-calendar">Roles</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('permissions.index') }}">
                                <span data-key="t-calendar">Permissions</span>
                            </a>
                        </li>


                        <li>
                            <a href="{{ route('users.index') }}">
                                <span data-key="t-user">Employees</span>
                            </a>
                        </li>

                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i class="mdi mdi-clock-edit-outline"></i>
                        <span data-key="t-apps">Shifts</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li>
                            <a href="{{ route('shifts.create') }}">
                                <span data-key="t-calendar">Create Shift</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('shifts.index') }}">
                                <span data-key="t-calendar">Shift List</span>
                            </a>
                        </li>
                </li>    



            </ul>

            <div class="card sidebar-alert border-0 text-center mx-4 mb-0 mt-5">
                <div class="card-body">
                    <img src="assets/images/giftbox.png" alt="">
                    <div class="mt-4">
                        <h5 class="alertcard-title font-size-16">Unlimited Access</h5>
                        <p class="font-size-13">Upgrade your plan from a Free trial, to select ‘Business Plan’.</p>
                        <a href="#!" class="btn btn-primary mt-2">Upgrade Now</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Sidebar -->
    </div>
</div>

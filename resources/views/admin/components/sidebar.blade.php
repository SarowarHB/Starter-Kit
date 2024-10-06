@php
    use App\Library\Helper;
@endphp
<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.home.dashboard') }}">
                <i class="icon-grid menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>

        @if( Helper::hasAuthRolePermission('notification_index') )
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.notification.index') }}">
                <i class="icon-bell menu-icon"></i>
                <span class="menu-title">Notifications</span>
            </a>
        </li>
        @endif

        @if( Helper::hasAuthRolePermission('employee_index') )
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.employee.index') }}">
                <i class="fas fa-user-shield menu-icon"></i>
                <span class="menu-title">Employees</span>
            </a>
        </li>
        @endif

        @if( Helper::hasAuthRolePermission('member_index') )
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.member.index') }}">
                <i class="fas fa-user-tie menu-icon"></i>
                <span class="menu-title">Members</span>
            </a>
        </li>
        @endif

        @if( Helper::hasAuthRolePermission('menu_website') )
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#website" aria-expanded="false" aria-controls="tables">
            <i class="fa-solid fa-globe menu-icon"></i>
                <span class="menu-title">Website</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="website">
                <ul class="nav flex-column sub-menu">
                    @if( Helper::hasAuthRolePermission('blog_index') )
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.website.blog.index') }}">Blog</a>
                    </li>
                    @endif

                    @if( Helper::hasAuthRolePermission('event_index') )
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.website.event.index') }}">Event</a>
                    </li>
                    @endif

                    @if( Helper::hasAuthRolePermission('faq_index') )
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.website.faq.index') }}">FAQ</a>
                    </li>
                    @endif

                </ul>
            </div>
        </li>
        @endif

        @if( Helper::hasAuthRolePermission('menu_asset') )
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#asset" aria-expanded="false" aria-controls="tables">
                <i class="fas fa-computer menu-icon"></i>
                <span class="menu-title">Asset</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="asset">
                <ul class="nav flex-column sub-menu">
                    @if( Helper::hasAuthRolePermission('asset_index') )
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.asset.index') }}">Asset</a>
                    </li>
                    @endif

                    @if( Helper::hasAuthRolePermission('asset_sale_index') )
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.asset.sale.index') }}">Asset Sold</a>
                    </li>
                    @endif

                </ul>
            </div>
        </li>
        @endif

        @if( Helper::hasAuthRolePermission('category_type_index') || 
        Helper::hasAuthRolePermission('category_index') || 
        Helper::hasAuthRolePermission('supplier_index') || 
        Helper::hasAuthRolePermission('product_index' ||
        Helper::hasAuthRolePermission('room_index') ||
        Helper::hasAuthRolePermission('stock_index') ||
        Helper::hasAuthRolePermission('stock_assign_index') ||
        Helper::hasAuthRolePermission('stock_transfer_index') ||
        Helper::hasAuthRolePermission('stock_testing_index')))
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ams" aria-expanded="false" aria-controls="tables">
                <i class="fas fa-computer menu-icon"></i>
                <span class="menu-title">AMS</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ams">
                <ul class="nav flex-column sub-menu">
                    @if( Helper::hasAuthRolePermission('category_type_index') )
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.ams.category_type.index') }}">Category Type</a>
                    </li>
                    @endif

                    @if( Helper::hasAuthRolePermission('category_index') )
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.ams.category.index') }}">Category</a>
                    </li>
                    @endif

                    @if( Helper::hasAuthRolePermission('supplier_index'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.ams.supplier.index') }}">Supplier</a>
                    </li>
                    @endif

                    @if( Helper::hasAuthRolePermission('product_index') )
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.ams.product.index') }}">Product</a>
                    </li>
                    @endif

                    @if( Helper::hasAuthRolePermission('room_index') )
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.ams.room.index') }}"> Room </a>
                    </li>
                    @endif

                    @if( Helper::hasAuthRolePermission('stock_index') )
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.ams.stock.index') }}">Stocks</a>
                    </li>
                    @endif

                    @if( Helper::hasAuthRolePermission('stock_assign_index') )
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.ams.stock_assign.index') }}">Stock Assign</a>
                    </li>
                    @endif

                    @if( Helper::hasAuthRolePermission('stock_transfer_index') )
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.ams.stock_transfer.index') }}">Stock Transfer</a>
                    </li>
                    @endif

                    @if( Helper::hasAuthRolePermission('stock_testing_index') )
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.ams.stock_testing.index') }}">Stock Testing</a>
                    </li>
                    @endif
                </ul>
            </div>
        </li>

        @endif

        @if( Helper::hasAuthRolePermission('menu_account') )
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#accounts" aria-expanded="false" aria-controls="tables">
            <i class="fas fa-money-bill-1 menu-icon"></i>
                <span class="menu-title">Accounts</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="accounts">
                <ul class="nav flex-column sub-menu">
                    @if( Helper::hasAuthRolePermission('general_expense_index') )
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.expense.general.index') }}">General Expense</a>
                    </li>
                    @endif

                    @if( Helper::hasAuthRolePermission('salary_expense_index') )
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.expense.salary.index') }}">Employee Salary</a>
                    </li>
                    @endif

                </ul>
            </div>
        </li>
        @endif

        @if( Helper::hasAuthRolePermission('ticket_index') )
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.ticket.index') }}">
                <i class="far fa-envelope menu-icon"></i>
                <span class="menu-title">Tickets</span>
            </a>
        </li>
        @endif

        @if( Helper::hasAuthRolePermission('log_footprint_menu') )
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#footprints" aria-expanded="false" aria-controls="footprints">
                <i class="fas fa-shoe-prints menu-icon"></i>
                <span class="menu-title">Foot Print</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="footprints">
                <ul class="nav flex-column sub-menu">
                    @if( Helper::hasAuthRolePermission('log_login_index') )
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.log.login.index') }}">Login History</a>
                        </li>
                    @endif

                    @if( Helper::hasAuthRolePermission('log_activity_index') )
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.log.activity.index') }}">Activity Logs</a>
                        </li>
                    @endif

                    @if( Helper::hasAuthRolePermission('log_email_index') )
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.log.email.index') }}">Email History</a>
                        </li>
                    @endif
                </ul>
            </div>
        </li>
        @endif

        @if( Helper::hasAuthRolePermission('config_dropdown_menu') )
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#settings" aria-expanded="false" aria-controls="settings">
                <i class="fas fa-cogs menu-icon"></i>
                <span class="menu-title">Configuration</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="settings">
                <ul class="nav flex-column sub-menu">
                    @if( Helper::hasAuthRolePermission('config_genaral_settings_show') )
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.config.general.settings') }}">General Settings</a>
                    </li>
                    @endif

                    @if( Helper::hasAuthRolePermission('role_index') )
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.config.role.index') }}"> Manage Roles </a>
                    </li>
                    @endif

                    @if( Helper::hasAuthRolePermission('config_dropdown_index') )
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.config.dropdown.menu') }}"> Dropdown List</a>
                    </li>
                    @endif

                    @if( Helper::hasAuthRolePermission('config_email_settings_show') )
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.config.email.settings') }}">Email Settings</a>
                    </li>
                    @endif

                    @if( Helper::hasAuthRolePermission('config_email_template_index') )
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.config.email_template.index') }}"> Email Templates </a>
                    </li>
                    @endif

                    @if( Helper::hasAuthRolePermission('config_email_signature_index') )
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.config.email_signature.index') }}"> Email Signature </a>
                    </li>
                    @endif

                    @if( Helper::hasAuthRolePermission('config_social_link_show') )
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.config.social.link') }}">Social Link</a>
                    </li>
                    @endif
                </ul>
            </div>
        </li>
        @endif

        @if( Helper::hasAuthRolePermission('profile_index') )
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.profile.index') }}">
                <i class="fas fa-user-circle menu-icon"></i>
                <span class="menu-title">Profile</span>
            </a>
        </li>
        @endif

        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt menu-icon"></i>
                <span class="menu-title">Logout</span>
            </a>
        </li>

    </ul>
</nav>


<form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
    @csrf
</form>

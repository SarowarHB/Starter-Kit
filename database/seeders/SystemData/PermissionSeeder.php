<?php

namespace Database\Seeders\SystemData;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    const GROUP_USER                = 'user';
    const GROUP_NOTIFICATION        = 'notification';
    const GROUP_EMP                 = 'employee';
    const GROUP_MEMBER              = 'member';
    const GROUP_TICKET              = 'ticket';
    const GROUP_LOG                 = 'log';
    const GROUP_ROLE                = 'role';
    const GROUP_CONFIG              = 'config';
    const GROUP_PROFILE             = 'profile';
    const GROUP_ASSET               = 'asset';
    const GROUP_ASSET_SALE          = 'asset_sale';
    const GROUP_EMERGENCY_CONTACT   = 'emergency_contact';
    const GROUP_GENERAL_EXPENSE     = 'general_expense';
    const GROUP_SALARY_EXPENSE      = 'salary_expense';
    const GROUP_BLOG                = 'blog';
    const GROUP_FAQ                 = 'faq';
    const GROUP_EVENT               = 'event';
    const GROUP_CATEGORY_TYPE       = 'category_type';
    const GROUP_CATEGORY            = 'category';
    const GROUP_SUPPLIER            = 'supplier';
    const GROUP_PRODUCT             = 'product';
    const GROUP_STOCK_ASSIGN        = 'stock_assign';
    const GROUP_STOCK_TRANSFER      = 'stock_transfer';
    const GROUP_STOCK_TESTING       = 'stock_testing';
    const GROUP_ROOM                = 'room';

    const GROUP_MENU_LIST           = 'menu';

    const GROUP_AMS_STOCK           = 'stock';


    public function run()
    {
        Permission::whereNotNull('id')->delete();

        $admin_role = Role::where('slug', 'admin')->first();
        $admin_user = User::where('email', env('ADMIN_EMAIL'))->first();

        foreach($this->permissions() as $p)
        {
            $permission = new Permission();
            $permission->name = $p['name'];
            $permission->slug = $p['slug'];
            $permission->group = $p['group'];
            $permission->save();

            if($admin_role)
            {
                $admin_role->permissions()->attach($permission);
            }

            if($admin_user)
            {
                $admin_user->permissions()->attach($permission);
            }
        }
    }


    private function permissions()
    {
        return array(

                    // Common permission for User (Employee/Member)
                    [
                        'name' => 'Update Status',
                        'slug' => self::GROUP_USER . '_update_status',
                        'group' => self::GROUP_USER
                    ],
                    [
                        'name' => 'Update Password',
                        'slug' => self::GROUP_USER . '_update_password',
                        'group' => self::GROUP_USER
                    ],
                    [
                        'name' => 'Delete',
                        'slug' => self::GROUP_USER . '_delete',
                        'group' => self::GROUP_USER
                    ],
                    [
                        'name' => 'Restore',
                        'slug' => self::GROUP_USER . '_restore',
                        'group' => self::GROUP_USER
                    ],

                    //notification
                    [
                        'name' => 'List',
                        'slug' => self::GROUP_NOTIFICATION . '_index',
                        'group' => self::GROUP_NOTIFICATION
                    ],
                    [
                        'name' => 'Create',
                        'slug' => self::GROUP_NOTIFICATION . '_create',
                        'group' => self::GROUP_NOTIFICATION
                    ],
                    [
                        'name' => 'Delete',
                        'slug' => self::GROUP_NOTIFICATION . '_delete',
                        'group' => self::GROUP_NOTIFICATION
                    ],

                    //Employee
                    [
                        'name' => 'List',
                        'slug' => self::GROUP_EMP . '_index',
                        'group' => self::GROUP_EMP
                    ],
                    [
                        'name' => 'Create',
                        'slug' => self::GROUP_EMP . '_create',
                        'group' => self::GROUP_EMP
                    ],
                    [
                        'name' => 'Update',
                        'slug' => self::GROUP_EMP . '_update',
                        'group' => self::GROUP_EMP
                    ],
                    [
                        'name' => 'Show',
                        'slug' => self::GROUP_EMP . '_show',
                        'group' => self::GROUP_EMP
                    ],

                    // Member
                    [
                        'name' => 'List',
                        'slug' => self::GROUP_MEMBER . '_index',
                        'group' => self::GROUP_MEMBER
                    ],
                    [
                        'name' => 'Create',
                        'slug' => self::GROUP_MEMBER . '_create',
                        'group' => self::GROUP_MEMBER
                    ],
                    [
                        'name' => 'Update',
                        'slug' => self::GROUP_MEMBER . '_update',
                        'group' => self::GROUP_MEMBER
                    ],
                    [
                        'name' => 'Show',
                        'slug' => self::GROUP_MEMBER . '_show',
                        'group' => self::GROUP_MEMBER
                    ],

                    //Ticket
                    [
                        'name' => 'List',
                        'slug' => self::GROUP_TICKET . '_index',
                        'group' => self::GROUP_TICKET
                    ],
                    [
                        'name' => 'Create',
                        'slug' => self::GROUP_TICKET . '_create',
                        'group' => self::GROUP_TICKET
                    ],
                    [
                        'name' => 'Show',
                        'slug' => self::GROUP_TICKET . '_show',
                        'group' => self::GROUP_TICKET
                    ],
                    [
                        'name' => 'Reply',
                        'slug' => self::GROUP_TICKET . '_reply',
                        'group' => self::GROUP_TICKET
                    ],
                    [
                        'name' => 'Assignee',
                        'slug' => self::GROUP_TICKET . '_assignee',
                        'group' => self::GROUP_TICKET
                    ],
                    [
                        'name' => 'Change Status',
                        'slug' => self::GROUP_TICKET . '_change_status',
                        'group' => self::GROUP_TICKET
                    ],
                    [
                        'name' => 'Re-Open',
                        'slug' => self::GROUP_TICKET . '_reopen',
                        'group' => self::GROUP_TICKET
                    ],

                    //Log
                    [
                        'name' => 'Footprint Menu',
                        'slug' => self::GROUP_LOG . '_footprint_menu',
                        'group' => self::GROUP_LOG
                    ],
                    [
                        'name' => 'Login List',
                        'slug' => self::GROUP_LOG . '_login_index',
                        'group' => self::GROUP_LOG
                    ],
                    [
                        'name' => 'Login Delete',
                        'slug' => self::GROUP_LOG . '_delete_login',
                        'group' => self::GROUP_LOG
                    ],
                    [
                        'name' => 'Activity List',
                        'slug' => self::GROUP_LOG . '_activity_index',
                        'group' => self::GROUP_LOG
                    ],
                    [
                        'name' => 'Activity Show',
                        'slug' => self::GROUP_LOG . '_activity_show',
                        'group' => self::GROUP_LOG
                    ],
                    [
                        'name' => 'Activity Delete',
                        'slug' => self::GROUP_LOG . '_activity_delete',
                        'group' => self::GROUP_LOG
                    ],
                    [
                        'name' => 'Email List',
                        'slug' => self::GROUP_LOG . '_email_index',
                        'group' => self::GROUP_LOG
                    ],
                    [
                        'name' => 'Email Show',
                        'slug' => self::GROUP_LOG . '_email_show',
                        'group' => self::GROUP_LOG
                    ],
                    [
                        'name' => 'Email Delete',
                        'slug' => self::GROUP_LOG . '_email_delete',
                        'group' => self::GROUP_LOG
                    ],

                    // Config Group Start
                    // Role Permissions
                    [
                        'name' => 'List',
                        'slug' => self::GROUP_ROLE . '_index',
                        'group' => self::GROUP_ROLE
                    ],
                    [
                        'name' => 'Create',
                        'slug' => self::GROUP_ROLE . '_create',
                        'group' => self::GROUP_ROLE
                    ],
                    [
                        'name' => 'Show',
                        'slug' => self::GROUP_ROLE . '_show',
                        'group' => self::GROUP_ROLE
                    ],
                    [
                        'name' => 'Update',
                        'slug' => self::GROUP_ROLE . '_update',
                        'group' => self::GROUP_ROLE
                    ],
                    [
                        'name' => 'Delete',
                        'slug' => self::GROUP_ROLE . '_delete',
                        'group' => self::GROUP_ROLE
                    ],
                    [
                        'name' => 'Permission',
                        'slug' => self::GROUP_ROLE . '_permission',
                        'group' => self::GROUP_ROLE
                    ],
                    [
                        'name' => 'Permission Update',
                        'slug' => self::GROUP_ROLE . '_permission_update',
                        'group' => self::GROUP_ROLE
                    ],

                    // Dropdown
                    [
                        'name' => 'Menu List',
                        'slug' => self::GROUP_CONFIG .'_dropdown_menu',
                        'group' => self::GROUP_CONFIG
                    ],
                    [
                        'name' => 'Dropdown List',
                        'slug' => self::GROUP_CONFIG .'_dropdown_index',
                        'group' => self::GROUP_CONFIG
                    ],
                    [
                        'name' => 'Create Dropdown',
                        'slug' => self::GROUP_CONFIG .'_dropdown_create',
                        'group' => self::GROUP_CONFIG
                    ],
                    [
                        'name' => 'Update Dropdown',
                        'slug' => self::GROUP_CONFIG .'_dropdown_update',
                        'group' => self::GROUP_CONFIG
                    ],
                    [
                        'name' => 'Delete Dropdown',
                        'slug' => self::GROUP_CONFIG .'_dropdown_delete',
                        'group' => self::GROUP_CONFIG
                    ],
                    [
                        'name' => 'Genaral Settings Show',
                        'slug' => self::GROUP_CONFIG .'_genaral_settings_show',
                        'group' => self::GROUP_CONFIG
                    ],
                    [
                        'name' => 'Genaral Settings Update',
                        'slug' => self::GROUP_CONFIG .'_genaral_settings_update',
                        'group' => self::GROUP_CONFIG
                    ],
                    [
                        'name' => 'Email Settings Show',
                        'slug' => self::GROUP_CONFIG .'_email_settings_show',
                        'group' => self::GROUP_CONFIG
                    ],
                    [
                        'name' => 'Email Settings Update',
                        'slug' => self::GROUP_CONFIG .'_email_settings_update',
                        'group' => self::GROUP_CONFIG
                    ],
                    [
                        'name' => 'Email Template List',
                        'slug' => self::GROUP_CONFIG .'_email_template_index',
                        'group' => self::GROUP_CONFIG
                    ],
                    [
                        'name' => 'Email Template Show',
                        'slug' => self::GROUP_CONFIG .'_email_template_show',
                        'group' => self::GROUP_CONFIG
                    ],
                    [
                        'name' => 'Email Template Update',
                        'slug' => self::GROUP_CONFIG .'_email_templete_update',
                        'group' => self::GROUP_CONFIG
                    ],
                    //Email Signature
                    [
                        'name' => 'Email Signature List',
                        'slug' => self::GROUP_CONFIG .'_email_signature_index',
                        'group' => self::GROUP_CONFIG
                    ],
                    [
                        'name' => 'Email Signature Create',
                        'slug' => self::GROUP_CONFIG .'_email_signature_create',
                        'group' => self::GROUP_CONFIG
                    ],
                    [
                        'name' => 'Email Signature Show',
                        'slug' => self::GROUP_CONFIG .'_email_signature_show',
                        'group' => self::GROUP_CONFIG
                    ],
                    [
                        'name' => 'Email Signature Update',
                        'slug' => self::GROUP_CONFIG .'_email_signature_update',
                        'group' => self::GROUP_CONFIG
                    ],
                    //End
                    [
                        'name' => 'Social Link Show',
                        'slug' => self::GROUP_CONFIG .'_social_link_show',
                        'group' => self::GROUP_CONFIG
                    ],
                    [
                        'name' => 'Social Link Update',
                        'slug' => self::GROUP_CONFIG .'_social_link_update',
                        'group' => self::GROUP_CONFIG
                    ],

                    // Email Templates


                // Config Group End

                    //Profile
                    [
                        'name' => 'Show',
                        'slug' => self::GROUP_PROFILE . '_index',
                        'group' => self::GROUP_PROFILE
                    ],
                    [
                        'name' => 'Update',
                        'slug' => self::GROUP_PROFILE . '_update',
                        'group' => self::GROUP_PROFILE
                    ],
                    [
                        'name' => 'Update Password',
                        'slug' => self::GROUP_PROFILE . '_update_password',
                        'group' => self::GROUP_PROFILE
                    ],
                    [
                        'name' => 'All Notification',
                        'slug' => self::GROUP_PROFILE . '_all_notification',
                        'group' => self::GROUP_PROFILE
                    ],

                     //Asset
                     [
                        'name' => 'List',
                        'slug' => self::GROUP_ASSET . '_index',
                        'group' => self::GROUP_ASSET
                    ],
                    [
                        'name' => 'Create',
                        'slug' => self::GROUP_ASSET . '_create',
                        'group' => self::GROUP_ASSET
                    ],
                    [
                        'name' => 'Show',
                        'slug' => self::GROUP_ASSET . '_show',
                        'group' => self::GROUP_ASSET
                    ],
                    [
                        'name' => 'Update',
                        'slug' => self::GROUP_ASSET . '_update',
                        'group' => self::GROUP_ASSET
                    ],
                    [
                        'name' => 'Delete',
                        'slug' => self::GROUP_ASSET . '_delete',
                        'group' => self::GROUP_ASSET
                    ],
                    [
                        'name' => 'Change Status',
                        'slug' => self::GROUP_ASSET . '_change_status',
                        'group' => self::GROUP_ASSET
                    ],

                    // Asset Sale
                    [
                        'name' => 'List',
                        'slug' => self::GROUP_ASSET_SALE . '_index',
                        'group' => self::GROUP_ASSET_SALE
                    ],
                    [
                        'name' => 'Create',
                        'slug' => self::GROUP_ASSET_SALE . '_create',
                        'group' => self::GROUP_ASSET_SALE
                    ],
                    [
                        'name' => 'Update',
                        'slug' => self::GROUP_ASSET_SALE . '_update',
                        'group' => self::GROUP_ASSET_SALE
                    ],
                    [
                        'name' => 'Delete',
                        'slug' => self::GROUP_ASSET_SALE . '_delete',
                        'group' => self::GROUP_ASSET_SALE
                    ],
                    [
                        'name' => 'Show',
                        'slug' => self::GROUP_ASSET_SALE . '_show',
                        'group' => self::GROUP_ASSET_SALE
                    ],

                     //Emergency Contact
                     [
                        'name' => 'List',
                        'slug' => self::GROUP_EMERGENCY_CONTACT . '_index',
                        'group' => self::GROUP_EMERGENCY_CONTACT
                    ],
                    [
                        'name' => 'Create',
                        'slug' => self::GROUP_EMERGENCY_CONTACT . '_create',
                        'group' => self::GROUP_EMERGENCY_CONTACT
                    ],
                    [
                        'name' => 'Update',
                        'slug' => self::GROUP_EMERGENCY_CONTACT . '_update',
                        'group' => self::GROUP_EMERGENCY_CONTACT
                    ],
                    [
                        'name' => 'Show',
                        'slug' => self::GROUP_EMERGENCY_CONTACT . '_show',
                        'group' => self::GROUP_EMERGENCY_CONTACT
                    ],
                    [
                        'name' => 'Delete',
                        'slug' => self::GROUP_EMERGENCY_CONTACT . '_delete',
                        'group' => self::GROUP_EMERGENCY_CONTACT
                    ],

                    //General Expense
                    [
                        'name' => 'List',
                        'slug' => self::GROUP_GENERAL_EXPENSE . '_index',
                        'group' => self::GROUP_GENERAL_EXPENSE
                    ],
                    [
                        'name' => 'Create',
                        'slug' => self::GROUP_GENERAL_EXPENSE . '_create',
                        'group' => self::GROUP_GENERAL_EXPENSE
                    ],
                    [
                        'name' => 'Show',
                        'slug' => self::GROUP_GENERAL_EXPENSE . '_show',
                        'group' => self::GROUP_GENERAL_EXPENSE
                    ],
                    [
                        'name' => 'Update',
                        'slug' => self::GROUP_GENERAL_EXPENSE . '_update',
                        'group' => self::GROUP_GENERAL_EXPENSE
                    ],
                    [
                        'name' => 'Delete',
                        'slug' => self::GROUP_GENERAL_EXPENSE . '_delete',
                        'group' => self::GROUP_GENERAL_EXPENSE
                    ],

                    //Salary Expense
                    [
                        'name' => 'List',
                        'slug' => self::GROUP_SALARY_EXPENSE . '_index',
                        'group' => self::GROUP_SALARY_EXPENSE
                    ],
                    [
                        'name' => 'Create',
                        'slug' => self::GROUP_SALARY_EXPENSE . '_create',
                        'group' => self::GROUP_SALARY_EXPENSE
                    ],
                    [
                        'name' => 'Show',
                        'slug' => self::GROUP_SALARY_EXPENSE . '_show',
                        'group' => self::GROUP_SALARY_EXPENSE
                    ],
                    [
                        'name' => 'Update',
                        'slug' => self::GROUP_SALARY_EXPENSE . '_update',
                        'group' => self::GROUP_SALARY_EXPENSE
                    ],
                    [
                        'name' => 'Delete',
                        'slug' => self::GROUP_SALARY_EXPENSE . '_delete',
                        'group' => self::GROUP_SALARY_EXPENSE
                    ],

                    //===========---Website--===============//
                    // Blog
                    [
                        'name' => 'List',
                        'slug' => self::GROUP_BLOG . '_index',
                        'group' => self::GROUP_BLOG
                    ],
                    [
                        'name' => 'Create',
                        'slug' => self::GROUP_BLOG . '_create',
                        'group' => self::GROUP_BLOG
                    ],
                    [
                        'name' => 'Update',
                        'slug' => self::GROUP_BLOG . '_update',
                        'group' => self::GROUP_BLOG
                    ],
                    [
                        'name' => 'Delete',
                        'slug' => self::GROUP_BLOG . '_delete',
                        'group' => self::GROUP_BLOG
                    ],
                    [
                        'name' => 'Update Status',
                        'slug' => self::GROUP_BLOG . '_update_status',
                        'group' => self::GROUP_BLOG
                    ],
                    [
                        'name' => 'Show',
                        'slug' => self::GROUP_BLOG . '_show',
                        'group' => self::GROUP_BLOG
                    ],

                    // Event
                    [
                        'name' => 'List',
                        'slug' => self::GROUP_EVENT . '_index',
                        'group' => self::GROUP_EVENT
                    ],
                    [
                        'name' => 'Create',
                        'slug' => self::GROUP_EVENT . '_create',
                        'group' => self::GROUP_EVENT
                    ],
                    [
                        'name' => 'Update',
                        'slug' => self::GROUP_EVENT . '_update',
                        'group' => self::GROUP_EVENT
                    ],
                    [
                        'name' => 'Delete',
                        'slug' => self::GROUP_EVENT . '_delete',
                        'group' => self::GROUP_EVENT
                    ],
                    [
                        'name' => 'Show',
                        'slug' => self::GROUP_EVENT . '_show',
                        'group' => self::GROUP_EVENT
                    ],

                    [
                        'name' => 'Status Update',
                        'slug' => self::GROUP_EVENT . '_status',
                        'group' => self::GROUP_EVENT
                    ],

                    // FAQ
                    [
                        'name' => 'List',
                        'slug' => self::GROUP_FAQ . '_index',
                        'group' => self::GROUP_FAQ
                    ],
                    [
                        'name' => 'Create',
                        'slug' => self::GROUP_FAQ . '_create',
                        'group' => self::GROUP_FAQ
                    ],
                    [
                        'name' => 'Update',
                        'slug' => self::GROUP_FAQ . '_update',
                        'group' => self::GROUP_FAQ
                    ],
                    [
                        'name' => 'Delete',
                        'slug' => self::GROUP_FAQ . '_delete',
                        'group' => self::GROUP_FAQ
                    ],
                    [
                        'name' => 'Show',
                        'slug' => self::GROUP_FAQ . '_show',
                        'group' => self::GROUP_FAQ
                    ],

                    [
                        'name' => 'Status Update',
                        'slug' => self::GROUP_FAQ . '_status',
                        'group' => self::GROUP_FAQ
                    ],
                    //============ End Website ============//

                    //============ Menue List ==============//
                    [
                        'name' => 'Website',
                        'slug' => self::GROUP_MENU_LIST . '_website',
                        'group' => self::GROUP_MENU_LIST
                    ],
                    [
                        'name' => 'Asset',
                        'slug' => self::GROUP_MENU_LIST . '_asset',
                        'group' => self::GROUP_MENU_LIST
                    ],
                    [
                        'name' => 'Account',
                        'slug' => self::GROUP_MENU_LIST . '_account',
                        'group' => self::GROUP_MENU_LIST
                    ],
                    //============ End Menu List =============//

                    // AMS
                    // Category Type
                    [
                        'name' => 'List',
                        'slug' => self::GROUP_CATEGORY_TYPE . '_index',
                        'group' => self::GROUP_CATEGORY_TYPE
                    ],
                    [
                        'name' => 'Create',
                        'slug' => self::GROUP_CATEGORY_TYPE . '_create',
                        'group' => self::GROUP_CATEGORY_TYPE
                    ],
                    [
                        'name' => 'Update',
                        'slug' => self::GROUP_CATEGORY_TYPE . '_update',
                        'group' => self::GROUP_CATEGORY_TYPE
                    ],
                    [
                        'name' => 'Delete',
                        'slug' => self::GROUP_CATEGORY_TYPE . '_delete',
                        'group' => self::GROUP_CATEGORY_TYPE
                    ],
                    [
                        'name' => 'Status Update',
                        'slug' => self::GROUP_CATEGORY_TYPE . '_status',
                        'group' => self::GROUP_CATEGORY_TYPE
                    ],

                    // Category
                    [
                        'name' => 'List',
                        'slug' => self::GROUP_CATEGORY . '_index',
                        'group' => self::GROUP_CATEGORY
                    ],
                    [
                        'name' => 'Create',
                        'slug' => self::GROUP_CATEGORY . '_create',
                        'group' => self::GROUP_CATEGORY
                    ],
                    [
                        'name' => 'Update',
                        'slug' => self::GROUP_CATEGORY . '_update',
                        'group' => self::GROUP_CATEGORY
                    ],
                    [
                        'name' => 'Delete',
                        'slug' => self::GROUP_CATEGORY . '_delete',
                        'group' => self::GROUP_CATEGORY
                    ],
                    [
                        'name' => 'Status Update',
                        'slug' => self::GROUP_CATEGORY . '_status',
                        'group' => self::GROUP_CATEGORY
                    ],

                    // Stock
                    [
                        'name' => 'List',
                        'slug' => self::GROUP_AMS_STOCK . '_index',
                        'group' => self::GROUP_AMS_STOCK
                    ],
                    [
                        'name' => 'Create',
                        'slug' => self::GROUP_AMS_STOCK . '_create',
                        'group' => self::GROUP_AMS_STOCK
                    ],
                    [
                        'name' => 'Update',
                        'slug' => self::GROUP_AMS_STOCK . '_update',
                        'group' => self::GROUP_AMS_STOCK
                    ],
                    [
                        'name' => 'Delete',
                        'slug' => self::GROUP_AMS_STOCK . '_delete',
                        'group' => self::GROUP_AMS_STOCK
                    ],
                    [
                        'name' => 'Show',
                        'slug' => self::GROUP_AMS_STOCK . '_show',
                        'group' => self::GROUP_AMS_STOCK
                    ],
                    [
                        'name' => 'Change Status',
                        'slug' => self::GROUP_AMS_STOCK . '_change_status',
                        'group' => self::GROUP_AMS_STOCK
                    ],

                    // Supplier
                    [
                        'name' => 'List',
                        'slug' => self::GROUP_SUPPLIER . '_index',
                        'group' => self::GROUP_SUPPLIER
                    ],
                    [
                        'name' => 'Create',
                        'slug' => self::GROUP_SUPPLIER . '_create',
                        'group' => self::GROUP_SUPPLIER
                    ],
                    [
                        'name' => 'Update',
                        'slug' => self::GROUP_SUPPLIER . '_update',
                        'group' => self::GROUP_SUPPLIER
                    ],
                    [
                        'name' => 'Delete',
                        'slug' => self::GROUP_SUPPLIER . '_delete',
                        'group' => self::GROUP_SUPPLIER
                    ],
                    [
                        'name' => 'Status Update',
                        'slug' => self::GROUP_SUPPLIER . '_status',
                        'group' => self::GROUP_SUPPLIER
                    ],

                    // Product
                    [
                        'name' => 'List',
                        'slug' => self::GROUP_PRODUCT . '_index',
                        'group' => self::GROUP_PRODUCT
                    ],
                    [
                        'name' => 'Create',
                        'slug' => self::GROUP_PRODUCT . '_create',
                        'group' => self::GROUP_PRODUCT
                    ],
                    [
                        'name' => 'Update',
                        'slug' => self::GROUP_PRODUCT . '_update',
                        'group' => self::GROUP_PRODUCT
                    ],
                    [
                        'name' => 'Delete',
                        'slug' => self::GROUP_PRODUCT . '_delete',
                        'group' => self::GROUP_PRODUCT
                    ],
                    [
                        'name' => 'Status Update',
                        'slug' => self::GROUP_PRODUCT . '_status',
                        'group' => self::GROUP_PRODUCT
                    ],
                    [
                        'name' => 'Show',
                        'slug' => self::GROUP_PRODUCT . '_show',
                        'group' => self::GROUP_PRODUCT
                    ], 
                    // Stock Assign
                    [
                        'name' => 'List',
                        'slug' => self::GROUP_STOCK_ASSIGN . '_index',
                        'group' => self::GROUP_STOCK_ASSIGN
                    ],
                    [
                        'name' => 'Create',
                        'slug' => self::GROUP_STOCK_ASSIGN . '_create',
                        'group' => self::GROUP_STOCK_ASSIGN
                    ],
                    [
                        'name' => 'Update',
                        'slug' => self::GROUP_STOCK_ASSIGN . '_update',
                        'group' => self::GROUP_STOCK_ASSIGN
                    ],
                    [
                        'name' => 'Delete',
                        'slug' => self::GROUP_STOCK_ASSIGN . '_delete',
                        'group' => self::GROUP_STOCK_ASSIGN
                    ],
                    [
                        'name' => 'Status Update',
                        'slug' => self::GROUP_STOCK_ASSIGN . '_status',
                        'group' => self::GROUP_STOCK_ASSIGN
                    ],
                    
                    // Stock Transfer
                    [
                        'name' => 'List',
                        'slug' => self::GROUP_STOCK_TRANSFER . '_index',
                        'group' => self::GROUP_STOCK_TRANSFER
                    ],
                    [
                        'name' => 'Create',
                        'slug' => self::GROUP_STOCK_TRANSFER . '_create',
                        'group' => self::GROUP_STOCK_TRANSFER
                    ],
                    [
                        'name' => 'Update',
                        'slug' => self::GROUP_STOCK_TRANSFER . '_update',
                        'group' => self::GROUP_STOCK_TRANSFER
                    ],
                    [
                        'name' => 'Delete',
                        'slug' => self::GROUP_STOCK_TRANSFER . '_delete',
                        'group' => self::GROUP_STOCK_TRANSFER
                    ],
                    [
                        'name' => 'Status Update',
                        'slug' => self::GROUP_STOCK_TRANSFER . '_status',
                        'group' => self::GROUP_STOCK_TRANSFER
                    ],

                     // Stock Testing
                     [
                        'name' => 'List',
                        'slug' => self::GROUP_STOCK_TESTING . '_index',
                        'group' => self::GROUP_STOCK_TESTING
                    ],
                    [
                        'name' => 'Test Stock',
                        'slug' => self::GROUP_STOCK_TESTING . '_test',
                        'group' => self::GROUP_STOCK_TESTING
                    ],
                    [
                        'name' => 'Show',
                        'slug' => self::GROUP_STOCK_TESTING . '_show',
                        'group' => self::GROUP_STOCK_TESTING
                    ],

                    // Room
                    [
                        'name' => 'List',
                        'slug' => self::GROUP_ROOM . '_index',
                        'group' => self::GROUP_ROOM
                    ],
                    [
                        'name' => 'Create',
                        'slug' => self::GROUP_ROOM . '_create',
                        'group' => self::GROUP_ROOM
                    ],
                    [
                        'name' => 'Update',
                        'slug' => self::GROUP_ROOM . '_update',
                        'group' => self::GROUP_ROOM
                    ],
                    [
                        'name' => 'Delete',
                        'slug' => self::GROUP_ROOM . '_delete',
                        'group' => self::GROUP_ROOM
                    ],
                    [
                        'name' => 'Status Update',
                        'slug' => self::GROUP_ROOM . '_status',
                        'group' => self::GROUP_ROOM
                    ],

                );
    }

}

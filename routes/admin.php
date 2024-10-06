<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\LogController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AssetController;
use App\Http\Controllers\Admin\CacheController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\StockController;
use App\Http\Controllers\Admin\ConfigController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\TicketController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\StockAssignController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\SalaryExpenseController;
use App\Http\Controllers\Admin\GeneralExpenseController;
use App\Http\Controllers\Admin\EmergencyContactController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\StockTransferController;
use App\Http\Controllers\Admin\StockTestingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::group(['middleware' => 'role:admin'], function () {

    Route::get('/', function (){
      return redirect()->route('admin.login');
    });

    Route::get('/dashboard', 'HomeController@dashboard')->name('home.dashboard');
    //cache
    Route::get('/cache/clear/fd', [CacheController::class, 'clear'])->name('clear.cache');

    // Users
    Route::group(['prefix' => 'users', 'as' => 'user.', 'controller' => UserController::class], function () {

        Route::post('/{user}/update-status-api', 'updateStatusApi')->name('update_status.api')->middleware('permission:user_update_status');
        Route::post('/{user}/update-password-api', 'updatePasswordApi')->name('update_password.api')->middleware('permission:user_update_password');
        Route::post('/{user}/delete-api', 'deleteApi')->name('delete.api')->middleware('permission:user_delete');
        Route::post('/{id}/restore-api', 'restoreApi')->name('restore.api')->middleware('permission:user_restore');
        Route::get('/{user}', 'show');

    });

    // Members
    Route::group(['prefix' => 'members', 'as' => 'member.', 'controller' => MemberController::class], function () {

        Route::get('/', 'index')->name('index')->middleware('permission:member_index');
        Route::get('/create', 'showCreateForm')->name('create')->middleware('permission:member_create');
        Route::post('/create', 'create')->middleware('permission:member_create');
        Route::get('/{member}/update', 'showUpdateForm')->name('update')->middleware('permission:member_update');
        Route::post('/{member}/update', 'update')->middleware('permission:member_update');
        Route::get('/{member}/show', 'show')->name('show')->middleware('permission:member_show');
        Route::post('/{assign}/stock/accept', 'acceptStock')->name('accept_stock')->middleware('permission:member_show');
        Route::post('/stock/status/change', 'stockStatusChange')->name('stock_status_change')->middleware('permission:member_show');

    });

    // Employees
    Route::group(['prefix' => 'employees', 'as' => 'employee.', 'controller' => EmployeeController::class], function () {

        Route::get('/', 'index')->name('index')->middleware('permission:employee_index');
        Route::get('/create', 'showCreateForm')->name('create')->middleware('permission:employee_create');
        Route::post('/create', 'create')->middleware('permission:employee_create');
        Route::get('/{employee}/update', 'showUpdateForm')->name('update')->middleware('permission:employee_update');
        Route::post('/{employee}/update', 'update')->middleware('permission:employee_update');
        Route::get('/{employee}/show', 'show')->name('show')->middleware('permission:employee_show');

    });

    // Employees
    Route::group(['prefix' => 'emergency', 'as' => 'emergency.', 'controller' => EmergencyContactController::class], function () {

        Route::get('/{user}/create', 'showCreateForm')->name('create')->middleware('permission:emergency_contact_create');
        Route::post('/{user}/create', 'create')->middleware('permission:emergency_contact_create');
        Route::get('/{emergency}/update', 'showUpdateForm')->name('update')->middleware('permission:emergency_contact_update');
        Route::post('/{emergency}/update', 'update')->middleware('permission:emergency_contact_update');
        Route::post('/{emergency}/delete-api', 'deleteApi')->name('delete.api')->middleware('permission:emergency_contact_delete');
    });

    // Logins & Activities
    Route::group(['prefix' => 'logs', 'as' => 'log.', 'controller' => LogController::class], function () {

        Route::get('/logins', 'loginIndex')->name('login.index')->middleware('permission:log_login_index');
        Route::post('/{login}/delete-api', 'deleteLoginApi')->name('delete_login.api')->middleware('permission:log_delete_login');

        Route::get('/activity', 'activityIndex')->name('activity.index')->middleware('permission:log_activity_index');
        Route::get('/activity/{activity}/show', 'activityShow')->name('activity.show')->middleware('permission:log_activity_show');
        Route::post('/activity/{activity}/delete', 'deleteActivity')->name('activity.delete')->middleware('permission:log_activity_delete');

        Route::get('/emails', 'emailIndex')->name('email.index')->middleware('permission:log_email_index');
        Route::get('/emails/{email}/show', 'emailShow')->name('email.show')->middleware('permission:log_email_show');
        Route::post('/emails/{email}/delete', 'deleteEmail')->name('email.delete')->middleware('permission:log_email_delete');

    });

    // Profile
    Route::group(['prefix' => 'profile', 'as' => 'profile.', 'controller' => ProfileController::class], function () {

        Route::get('/', 'index')->name('index')->middleware('permission:profile_index');
        Route::get('/update', 'showUpdateForm')->name('update')->middleware('permission:profile_update');
        Route::post('/update', 'update')->middleware('permission:profile_update');
        Route::get('/update-password', 'showUpdatePasswordForm')->name('update_password')->middleware('permission:profile_update_password');
        Route::post('/update-password', 'updatePassword')->middleware('permission:profile_update_password');
        Route::get('/notification/all', 'showAllNotifications')->name('notification')->middleware('permission:profile_all_notification');

    });

    // Tickets
    Route::group(['prefix'=>'tickets', 'as' => 'ticket.', 'controller'=> TicketController::class], function () {

        Route::get('/', 'index')->name('index')->middleware('permission:ticket_index');
        Route::get('/create', 'showCreateForm')->name('create')->middleware('permission:ticket_create');
        Route::post('/create', 'create')->middleware('permission:ticket_create');
         Route::get('/{ticket}/update', 'showUpdateForm')->name('update')->middleware('permission:profile_update');
        Route::post('/{ticket}/update', 'update')->middleware('permission:profile_update');
        Route::get('/{ticket}/show', 'show')->name('show')->middleware('permission:ticket_show');
        Route::post('/{ticket}/reply', 'reply')->name('reply')->middleware('permission:ticket_reply');
        Route::post('/{ticket}/assignee', 'changeAssignee')->name('assignee')->middleware('permission:ticket_assignee');
        Route::post('/{ticket}/change-status', 'changeStatus')->name('change_status')->middleware('permission:ticket_change_status');
        Route::get('/{ticket}/reopen', 'reOpen')->name('reopen')->middleware('permission:ticket_reopen');
    });

     // Config
     Route::group(['prefix' => 'configs', 'as' => 'config.', 'controller' => ConfigController::class], function () {

        // Roles & Permissions
        Route::group(['prefix' => 'roles', 'as' => 'role.', 'controller' => RoleController::class], function () {
            Route::get('/', 'index')->name('index')->middleware('permission:role_index');
            Route::get('/{role}/show-api', 'showApi')->name('show.api')->middleware('permission:role_show');
            Route::post('/create', 'createApi')->name('create.api')->middleware('permission:role_create');
            Route::post('/{role}/update-api', 'updateApi')->name('update.api')->middleware('permission:role_update');
            Route::post('/{role}/delete-api', 'deleteApi')->name('delete.api')->middleware('permission:role_delete');
            Route::get('/{role}/permissions', 'permissions')->name('permission')->middleware('permission:role_permission');
            Route::post('/{role}/permissions/update', 'updatePermissions')->name('permission.update')->middleware('permission:role_permission_update');
        });

        // Dropdowns
        Route::group(['prefix' => 'dropdowns', 'as' => 'dropdown.'], function () {
            Route::get('/', 'dropdownMenu')->name('menu')->middleware('permission:config_dropdown_menu');
            Route::get('/{dropdown}', 'dropdowns')->name('index')->middleware('permission:config_dropdown_index');
            Route::post('/{dropdown}/create-api', 'createDropdownApi')->name('create.api')->middleware('permission:config_dropdown_create');
            Route::post('/{dropdown}/{id}/update-api', 'updateDropdownApi')->name('update.api')->middleware('permission:config_dropdown_update');
            Route::post('/{dropdown}/{id}/delete-api', 'deleteDropdownApi')->name('delete.api')->middleware('permission:config_dropdown_delete');
        });

        // Email templates
        Route::group(['prefix' => 'email-templates', 'as' => 'email_template.'], function () {
            Route::get('/', 'emailTemplates')->name('index')->middleware('permission:config_email_template_index');
            Route::get('/{email_template}/update', 'updateEmailTemplateForm')->name('update')->middleware('permission:config_email_templete_update');
            Route::post('/{email_template}/update', 'updateEmailTemplate')->middleware('permission:config_email_templete_update');
        });

         // Email Signature
        Route::group(['prefix' => 'email-signature', 'as' => 'email_signature.', 'controller' => EmailSignatureController::class], function () {

            Route::get('/', 'index')->name('index')->middleware('permission:config_email_signature_index');
            Route::get('/create', 'showCreateForm')->name('create')->middleware('permission:config_email_signature_create');
            Route::post('/create', 'create')->middleware('permission:config_email_signature_create');
            Route::get('/{emailSignature}/update', 'showUpdateForm')->name('update')->middleware('permission:config_email_signature_update');
            Route::post('/{emailSignature}/update', 'update')->middleware('permission:config_email_signature_update');
            Route::get('/{emailSignature}/show-api', 'show')->name('show')->middleware('permission:config_email_signature_show');
            Route::post('/{emailSignature}/delete-api', 'deleteApi')->name('delete.api')->middleware('permission:blog_delete');

        });

        Route::get('/general_settings', 'general')->name('general.settings')->middleware('permission:config_genaral_settings_show');
        Route::post('/general', 'updateGeneralSettings')->name('general.settings.update')->middleware('permission:config_genaral_settings_update');
        Route::get('/email-settings', 'emailSettings')->name('email.settings')->middleware('permission:config_email_settings_show');
        Route::post('/update-email-settings', 'updateEmailSettings')->name('email.settings.update')->middleware('permission:cnfig_email_settings_update');
        Route::post('/send-test-email', 'sendTestMail')->name('send.test.email')->middleware('permission:config_email_settings_show');
        Route::get('/social-link', 'socialLink')->name('social.link')->middleware('permission:config_social_link_show');
        Route::post('/social-link', 'updateSocialLink')->name('social.link.update')->middleware('permission:config_social_link_update');

    });

    // Notifications
    Route::group(['prefix' => 'notifications', 'as' => 'notification.', 'controller' => NotificationController::class], function () {

        Route::get('/', 'index')->name('index')->middleware('permission:notification_index');
        Route::get('/create', 'showCreateForm')->name('create')->middleware('permission:notification_create');
        Route::post('/create', 'create')->middleware('permission:notification_create');
        Route::post('/{notification}/delete-api', 'deleteApi')->name('delete.api')->middleware('permission:notification_delete');
    });

    // Start Asset Module
    Route::group(['prefix' => 'asset', 'as' => 'asset.', 'controller' => AssetController::class], function () {

        Route::get('/', 'index')->name('index')->middleware('permission:asset_index');
        Route::get('/create', 'showCreateForm')->name('create')->middleware('permission:asset_create');
        Route::post('/create', 'create')->middleware('permission:asset_create');
        Route::get('/{asset}/update', 'showUpdateForm')->name('update')->middleware('permission:asset_update');
        Route::post('/{asset}/update', 'update')->middleware('permission:asset_update');
        Route::get('/{asset}/show', 'show')->name('show')->middleware('permission:asset_show');
        Route::post('/{asset}/change-status-api', 'changeStatusApi')->name('change_status.api')->middleware('permission:asset_change_status');

        // Asset Sale
        Route::get('/sale', 'saleIndex')->name('sale.index')->middleware('permission:asset_sale_index');
        Route::get('/{asset}/sale/create', 'showCreateSaleForm')->name('sale.create')->middleware('permission:asset_sale_create');
        Route::post('/{asset}/sale/create', 'saleCreate')->middleware('permission:asset_sale_create');
        Route::get('/{asset}/sale/{assetSale}/update', 'saleShowUpdateForm')->name('sale.update')->middleware('permission:asset_sale_update');
        Route::post('/{asset}/sale/{assetSale}/update', 'updateAssetSale')->middleware('permission:asset_sale_update');
        Route::get('/{asset}/sale/{assetSale}/show', 'saleShow')->name('sale.show')->middleware('permission:asset_sale_show');

    });
    // End Asset Module

    //Expense
    Route::group(['prefix' => 'expenses', 'as' => 'expense.'], function () {

        // General Expense
        Route::group(['prefix' => 'general_exp', 'as' => 'general.', 'controller' => GeneralExpenseController::class], function () {

            Route::get('/', 'index')->name('index')->middleware('permission:general_expense_index');
            Route::get('/create', 'showCreateForm')->name('create')->middleware('permission:general_expense_create');
            Route::post('/create', 'create')->middleware('permission:general_expense_create');
            Route::get('/{expense}/update', 'showUpdateForm')->name('update')->middleware('permission:general_expense_update');
            Route::post('/{expense}/update', 'update')->middleware('permission:general_expense_update');
            Route::get('/{expense}/show', 'show')->name('show')->middleware('permission:general_expense_show');
            Route::post('/{expense}/delete-api', 'deleteApi')->name('delete.api')->middleware('permission:general_expense_delete');

        });

        // Salary Expense
        Route::group(['prefix' => 'salary', 'as' => 'salary.', 'controller' => SalaryExpenseController::class], function () {

        Route::get('/', 'index')->name('index')->middleware('permission:salary_expense_index');
        Route::get('/create', 'showCreateForm')->name('create')->middleware('permission:salary_expense_create');
        Route::post('/create', 'create')->middleware('permission:salary_expense_create');
        Route::get('/{salary_expense}/update', 'showUpdateForm')->name('update')->middleware('permission:salary_expense_update');
        Route::post('/{salary_expense}/update', 'update')->middleware('permission:salary_expense_update');
        Route::get('/{salary_expense}/show', 'show')->name('show')->middleware('permission:salary_expense_show');
        Route::post('/{salary_expense}/delete-api', 'deleteApi')->name('delete.api')->middleware('permission:salary_expense_delete');

        });
    });

    //=============-------- Website Start----------====================//
    //Expense
    Route::group(['prefix' => 'website', 'as' => 'website.'], function () {

        // Blog Module
        Route::group(['prefix' => 'blogs', 'as' => 'blog.', 'controller' => BlogController::class], function () {

            Route::get('/', 'index')->name('index')->middleware('permission:blog_index');
            Route::get('/create', 'showCreateForm')->name('create')->middleware('permission:blog_create');
            Route::post('/create', 'create')->middleware('permission:blog_create');
            Route::get('/{blog}/update', 'showUpdateForm')->name('update')->middleware('permission:blog_update');
            Route::post('/{blog}/update', 'update')->middleware('permission:blog_update');
            Route::get('/{blog}/show', 'show')->name('show')->middleware('permission:blog_show');
            Route::post('/{blog}/change-status-api', 'changeStatusApi')->name('change_status.api')->middleware('permission:blog_update_status');
            Route::post('/{blog}/delete-api', 'deleteApi')->name('delete.api')->middleware('permission:blog_delete');

        });

        // Event Module
        Route::group(['prefix' => 'events', 'as' => 'event.', 'controller' => EventController::class], function () {

            Route::get('/', 'index')->name('index')->middleware('permission:event_index');
            Route::get('/create', 'showCreateForm')->name('create')->middleware('permission:event_create');
            Route::post('/create', 'create')->middleware('permission:event_create');
            Route::get('/{event}/update', 'showUpdateForm')->name('update')->middleware('permission:event_update');
            Route::post('/{event}/update', 'update')->middleware('permission:event_update');
            Route::get('/{event}/show', 'show')->name('show')->middleware('permission:event_show');
            Route::post('/{event}/change-status-api', 'changeStatusApi')->name('change_status.api')->middleware('permission:event_status');
            Route::post('/{event}/delete-api', 'deleteApi')->name('delete.api')->middleware('permission:event_delete');

        });

        // Faq Module
        Route::group(['prefix' => 'faqs', 'as' => 'faq.', 'controller' => FaqController::class], function () {

            Route::get('/', 'index')->name('index')->middleware('permission:faq_index');
            Route::get('/create', 'showCreateForm')->name('create')->middleware('permission:faq_create');
            Route::post('/create', 'create')->middleware('permission:faq_create');
            Route::get('/{faq}/update', 'showUpdateForm')->name('update')->middleware('permission:faq_update');
            Route::post('/{faq}/update', 'update')->middleware('permission:faq_update');
            Route::get('/{faq}/show', 'show')->name('show')->middleware('permission:faq_show');
            Route::post('/{faq}/change-status-api', 'changeStatusApi')->name('change_status.api')->middleware('permission:faq_status');
            Route::post('/{faq}/delete-api', 'deleteApi')->name('delete.api')->middleware('permission:faq_delete');

        });
    });

    // Start AMS Module
    Route::group(['prefix' => 'ams', 'as' => 'ams.'], function () {
        // Category Type
        Route::group(['prefix' => 'category/type', 'as' => 'category_type.', 'controller' => CategoryTypeController::class], function () {
            Route::get('/', 'index')->name('index')->middleware('permission:category_type_index');
            Route::get('/create', 'create')->name('create')->middleware('permission:category_type_create');
            Route::post('/store', 'store')->name('store')->middleware('permission:category_type_create');
            Route::get('/{category_type}/edit', 'edit')->name('edit')->middleware('permission:category_type_update');
            Route::post('/{category_type}/update', 'update')->name('update')->middleware('permission:category_type_update');
            Route::get('/{category_type}/delete', 'destroy')->name('delete')->middleware('permission:category_type_delete');
            Route::post('/{category_type}/status-change', 'changeStatus')->name('change_status')->middleware('permission:category_type_status');
        });

        // Category
        Route::group(['prefix' => 'category', 'as' => 'category.', 'controller' => CategoryController::class], function () {
            Route::get('/', 'index')->name('index')->middleware('permission:category_index');
            Route::get('/create', 'create')->name('create')->middleware('permission:category_create');
            Route::post('/store', 'store')->name('store')->middleware('permission:category_create');
            Route::get('/{category}/edit', 'edit')->name('edit')->middleware('permission:category_update');
            Route::post('/{category}/update', 'update')->name('update')->middleware('permission:category_update');
            Route::get('/{category}/delete', 'destroy')->name('delete')->middleware('permission:category_delete');
            Route::post('/{category}/status-change', 'changeStatus')->name('change_status')->middleware('permission:category_status');
        });

        // Supplier
        Route::group(['prefix' => 'supplier', 'as' => 'supplier.', 'controller' => SupplierController::class], function () {
            Route::get('/', 'index')->name('index')->middleware('permission:supplier_index');
            Route::get('/create', 'create')->name('create')->middleware('permission:supplier_create');
            Route::post('/store', 'store')->name('store')->middleware('permission:supplier_create');
            Route::get('/{supplier}/edit', 'edit')->name('edit')->middleware('permission:supplier_update');
            Route::post('/{supplier}/update', 'update')->name('update')->middleware('permission:supplier_update');
            Route::get('/{supplier}/delete', 'destroy')->name('delete')->middleware('permission:supplier_delete');
            Route::post('/{supplier}/status-change', 'changeStatus')->name('change_status')->middleware('permission:supplier_status');
        });

        // Product
        Route::group(['prefix' => 'product', 'as' => 'product.', 'controller' => ProductController::class], function () {
            Route::get('/', 'index')->name('index')->middleware('permission:product_index');
            Route::get('/create', 'create')->name('create')->middleware('permission:product_create');
            Route::post('/store', 'store')->name('store')->middleware('permission:product_create');
            Route::get('/{product}/edit', 'edit')->name('edit')->middleware('permission:product_update');
            Route::post('/{product}/update', 'update')->name('update')->middleware('permission:product_update');
            Route::post('/{product}/delete', 'destroy')->name('delete')->middleware('permission:product_delete');
            Route::get('/{product}/show', 'show')->name('show')->middleware('permission:product_show');
            Route::post('/{product}/status-change', 'changeStatus')->name('change_status')->middleware('permission:product_status');
        });

        // Room
        Route::group(['prefix' => 'room', 'as' => 'room.', 'controller' => RoomController::class], function () {
            Route::get('/', 'index')->name('index')->middleware('permission:room_index');
            Route::get('/create', 'create')->name('create')->middleware('permission:room_create');
            Route::post('/store', 'store')->name('store')->middleware('permission:room_create');
            Route::get('/{room}/edit', 'edit')->name('edit')->middleware('permission:room_update');
            Route::post('/{room}/update', 'update')->name('update')->middleware('permission:room_update');
            Route::get('/{room}/delete', 'destroy')->name('delete')->middleware('permission:room_delete');
            Route::post('/{room}/status-change', 'changeStatus')->name('change_status')->middleware('permission:room_status');
        });

        // Stock
        Route::group(['prefix' => 'stocks', 'as' => 'stock.', 'controller' => StockController::class], function () {
            Route::get('/', 'index')->name('index')->middleware('permission:stock_index');
            Route::post('/supplier', 'getSupplier')->name('supplier')->middleware('permission:stock_create');
            Route::get('/create', 'create')->name('create')->middleware('permission:stock_create');
            Route::post('/store', 'store')->name('store')->middleware('permission:stock_create');
            Route::get('/{stock}/edit', 'edit')->name('edit')->middleware('permission:stock_update');
            Route::post('/{stock}/update', 'update')->name('update')->middleware('permission:stock_update');
            Route::post('/{stock}/delete', 'destroy')->name('delete')->middleware('permission:stock_delete');
            Route::get('/{stock}', 'showApi');
            Route::get('/{stock}/show', 'show')->name('show')->middleware('permission:stock_show');
            Route::post('/{stock}/change-status', 'changeStatus')->name('change_status')->middleware('permission:stock_change_status');
            Route::get('/by/{location}', 'getStockByLocation');
        });

        // Product Assign
        Route::group(['prefix' => 'stock/assign', 'as' => 'stock_assign.', 'controller' => StockAssignController::class], function () {
            Route::get('/', 'index')->name('index')->middleware('permission:stock_assign_index');
            Route::get('/create', 'create')->name('create')->middleware('permission:stock_assign_create');
            Route::post('/store', 'store')->name('store')->middleware('permission:stock_assign_create');
            Route::get('/{stock_assign}/edit', 'edit')->name('edit')->middleware('permission:stock_assign_update');
            Route::post('/{stock_assign}/update', 'update')->name('update')->middleware('permission:stock_assign_update');
            Route::get('/{stock_assign}/delete', 'destroy')->name('delete')->middleware('permission:product_delete');
        });

        // Stock Transfer
        Route::group(['prefix' => 'stock/transfer', 'as' => 'stock_transfer.', 'controller' => StockTransferController::class], function () {
            Route::get('/', 'index')->name('index')->middleware('permission:stock_transfer_index');
            Route::get('/create', 'create')->name('create')->middleware('permission:stock_transfer_create');
            Route::post('/store', 'store')->name('store')->middleware('permission:stock_transfer_create');
            Route::get('/{stock_transfer}/edit', 'edit')->name('edit')->middleware('permission:stock_transfer_update');
            Route::post('/{stock_transfer}/update', 'update')->name('update')->middleware('permission:stock_transfer_update');
            Route::get('/{stock_transfer}/delete', 'destroy')->name('delete')->middleware('permission:stock_transfer_delete');
            Route::post('/{stock_transfer}/status-change', 'changeStatus')->name('change_status')->middleware('permission:stock_transfer_status');
            Route::post('/get-stock', 'getStock')->name('get_stock')->middleware('permission:stock_transfer_status');
        });

        // Stock Testing
            Route::group(['prefix' => 'stock/testing', 'as' => 'stock_testing.', 'controller' => StockTestingController::class], function () {
            Route::get('/', 'index')->name('index')->middleware('permission:stock_testing_index');
            Route::get('/{stock}/test', 'showTest')->name('test')->middleware('permission:stock_testing_test');
            Route::post('/test', 'storeTest')->name('store_test')->middleware('permission:stock_testing_test');
            Route::get('/{stock}/view', 'view')->name('view')->middleware('permission:stock_testing_show');
        });
    });
    // End AMS Module
});

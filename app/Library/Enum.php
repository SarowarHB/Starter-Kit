<?php
namespace App\Library;


class Enum
{

    //Vite Resources Path
    public const LOGO_PATH = 'resources/images/logo.png';
    public const NO_AVATAR_PATH = 'resources/images/no_avatar.png';
    public const NO_IMAGE_PATH = 'resources/images/noimage.jpg';


    public const ROLE_ADMIN_SLUG = 'admin';
    public const ORG_LOGO_IMAGE_DIR = 'storage/organization/logo';
    public const ORG_OPERATOR_PROFILE_IMAGE_DIR = 'storage/organization/operator';
    public const CAMPAIGN_IMAGE_DIR = 'storage/campaign/logo';
    public const CAMPAIGN_GALLERY_IMAGE_DIR = 'storage/campaign/gallery';
    public const QRCODE_DIR = 'storage/qrcode/';
    public const MEMBER_PROFILE_IMAGE_DIR = 'storage/member/profile';
    public const CONFIG_IMAGE_DIR = 'storage/config';
    public const MEMBER_NID_IMAGE_DIR = 'storage/member/nid';
    public const AMS_PRODUCT_IMAGE_DIR = 'storage/ams/product';
    public const EMPLOYEE_PROFILE_IMAGE = 'storage/employee/profile';
    public const TICKET_ATTACHMENT_DIR = 'storage/ticket';
    public const TRANSACTION_FILE = 'storage/transaction';
    public const ASSET_DOCUMENTS = 'storage/asset';
    public const BLOG_FEATURE_IMAGE = 'storage/blog';
    public const EVENT_FEATURE_IMAGE = 'storage/event';
    public const EMPLOYEE_CONTACT_PERSION_IMAGE = 'storage/employee/contact';
    public const SUPPLIER_LOGO = 'storage/supplier/logo';

    public const PROJECT_ID_TAG = 'Test';


    //===========------- Email Settings Start ----================//
    public const EMAIL_TICKET_CREATE = 'ticket_create';
    public const EMAIL_TICKET_ASSIGN = 'ticket_assign';
    public const EMAIL_TICKET_REPLY = 'ticket_reply';

    //Campaign Email Settings
    public const EMAIL_CAMPAIGN_APPROVED = 'campaign_approved';
    public const EMAIL_CAMPAIGN_COMPLETE = 'campaign_complete';
    public const EMAIL_CAMPAIGN_CREATE = 'campaign_create';
    public const EMAIL_CAMPAIGN_DECLINED = 'campaign_declined';
    public const EMAIL_CAMPAIGN_SUSPENDED = 'campaign_suspended';
    public const EMAIL_CAMPAIGN_PENDING = 'campaign_pending';
    public const EMAIL_CAMPAIGN_DELETE = 'campaign_delete';

    //Transaction Email Settings
    public const EMAIL_TRANSACTION_COMPLETE = 'transaction_completed';
    public const EMAIL_TRANSACTION_DECLINED = 'transaction_declined';
    public const EMAIL_TRANSACTION_HOLD = 'transaction_hold';
    public const EMAIL_TRANSACTION_PENDING = 'transaction_pending';
    public const EMAIL_TRANSACTION_PROCESSING = 'transaction_processing';

    //Payment Email Settings
    public const EMAIL_PAYMENT_RECEIVE_MONEY = 'payment_receive_money';
    public const EMAIL_PAYMENT_SEND_MONEY = 'payment_send_money';

    public const EMAIL_MEMBER_CREATE = 'member_create';
    public const EMAIL_ORGANIZATION_CREATE = 'organization_create';
    public const EMAIL_EMPLOYEE_CREATE = 'employee_create';

    //===========------- Email Settings End ----================//



    /* ============== USER MODULE ===================*/

    public const USER_TYPE_ADMIN   = 'admin';
    public const USER_TYPE_MEMBER   = 'member';
    public const USER_TYPE_ORG = 'organization';
    public const USER_TYPE_ROOM = 'room';

    public static function getUserType(string $type = null)
    {
        $types =  [
            self::USER_TYPE_ADMIN => 'Administrator',
            self::USER_TYPE_MEMBER => 'MEMBER',
            self::USER_TYPE_ORG => 'Organization',
            self::USER_TYPE_ROOM => 'Room',
        ];
        return $type ? $types[$type] : $types;
    }

    public const USER_STATUS_ACTIVE = 1;
    public const USER_STATUS_INACTIVE = 0;

    public static function getUserStatus(string $type = null)
    {
        $types = [
            self::USER_STATUS_ACTIVE => "Active",
            self::USER_STATUS_INACTIVE => "Inactive"
        ];

        if (isset($type) && $type == 0) {
            return $types[$type];
        }

        return $type ? $types[$type] : $types;
    }

    /* ============== END ===================*/

    /* ============== EMPLOYEE MODULE ===================*/

    public const EMPLOYEE_TYPE_PART_TIME = 'part_time';
    public const EMPLOYEE_TYPE_FULL_TIME = 'full_time';

    public static function getEmployeeType(string $type = null)
    {
        $types = [
            self::EMPLOYEE_TYPE_PART_TIME => "Part Time",
            self::EMPLOYEE_TYPE_FULL_TIME => "Full Time"
        ];
        return $type ? $types[$type] : $types;
    }

    /* ============== END ===================*/

    /* ============== ORGANIZATION MODULE ===================*/

    public const ORG_STATUS_PENDING   = 1;
    public const ORG_STATUS_APPROVED  = 2;
    public const ORG_STATUS_DECLINED  = 3;
    public const ORG_STATUS_SUSPENDED = 4;

    public static function getOrganizationStatus(string $status = null)
    {
        $status_arr =  [
            self::ORG_STATUS_PENDING => 'Pending',
            self::ORG_STATUS_APPROVED => 'Approved',
            self::ORG_STATUS_DECLINED => 'Declined',
            self::ORG_STATUS_SUSPENDED => 'Suspended',
        ];
        return $status ? $status_arr[$status] : $status_arr;
    }

    /* ============== END ===================*/

    /* ============== CAMPAIGNS MODULE ===================*/

    public const CAMP_STATUS_PENDING   = 1;
    public const CAMP_STATUS_APPROVED  = 2;
    public const CAMP_STATUS_DECLINED  = 3;
    public const CAMP_STATUS_SUSPENDED = 4;

    public static function getCampaignStatus(string $status = null)
    {
        $status_arr =  [
            self::CAMP_STATUS_PENDING => 'Pending',
            self::CAMP_STATUS_APPROVED => 'Approved',
            self::CAMP_STATUS_DECLINED => 'Declined',
            self::CAMP_STATUS_SUSPENDED => 'Suspended',
        ];
        return $status ? $status_arr[$status] : $status_arr;
    }

    /* ============== END ===================*/

    /* ============== TICKET MODULE ===================*/

    public const TICKET_STATUS_OPEN = 1;
    public const TICKET_STATUS_HOLD = 2;
    public const TICKET_STATUS_CLOSED = 3;

    public static function getTicketStatus(string $status = null)
    {
        $status_arr =  [
                self::TICKET_STATUS_OPEN => 'Open',
                self::TICKET_STATUS_HOLD => 'Hold',
                self::TICKET_STATUS_CLOSED => 'Closed',
            ];
        return $status ? $status_arr[$status] : $status_arr;
    }

    public const TICKET_PRIORITY_LOW = 1;
    public const TICKET_PRIORITY_MEDIUM = 2;
    public const TICKET_PRIORITY_HIGH = 3;

    public static function getTicketPriority(int $priority = 0)
    {
        $priority_arr = [
                self::TICKET_PRIORITY_LOW => "Low",
                self::TICKET_PRIORITY_MEDIUM => "Medium",
                self::TICKET_PRIORITY_HIGH => 'High'
            ];
        return $priority ? $priority_arr[$priority] : $priority_arr;
    }

    /* ============== END ===================*/

    /* ============== CONFIG MODULE ===================*/

    public const CONFIG_DROPDOWN_EMP_DESIGNATION = 'emp_designation';
    public const CONFIG_DROPDOWN_TICKET_DEPARTMENT = 'ticket_department';
    public const CONFIG_DROPDOWN_NOTIFICATION_TYPE = 'notification_type';
    public const CONFIG_DROPDOWN_ASSET_TYPE = 'asset_type';
    public const CONFIG_DROPDOWN_EXPENSE_TYPE = 'expense_type';
    public const CONFIG_DROPDOWN_BLOG_TYPE = 'blog_type';
    public const CONFIG_DROPDOWN_EVENT_TYPE = 'event_type';
    public const CONFIG_DROPDOWN_TAGS_TYPE = 'tag_type';
    public const CONFIG_DROPDOWN_PAYMENT_TYPE = 'payment_type';
    public const CONFIG_DROPDOWN_AMS_BRAND = 'ams_brand';
    public const CONFIG_DROPDOWN_AMS_LOCATION = 'location';


    public static function getConfigDropdown(string $key = null)
    {
        $dropdowns = [
            self::CONFIG_DROPDOWN_EMP_DESIGNATION => "Employee Designation",
            self::CONFIG_DROPDOWN_TICKET_DEPARTMENT => "Ticket Department",
            self::CONFIG_DROPDOWN_NOTIFICATION_TYPE => "Notification Type",
            self::CONFIG_DROPDOWN_ASSET_TYPE => "Asset Type",
            self::CONFIG_DROPDOWN_EXPENSE_TYPE => "Expense Type",
            self::CONFIG_DROPDOWN_BLOG_TYPE => "Blog Type",
            self::CONFIG_DROPDOWN_EVENT_TYPE => "Event Type",
            self::CONFIG_DROPDOWN_TAGS_TYPE => "Tag Type",
            self::CONFIG_DROPDOWN_PAYMENT_TYPE => "Payment Type",
            self::CONFIG_DROPDOWN_AMS_BRAND => "Brand",
            self::CONFIG_DROPDOWN_AMS_LOCATION => "Location",
        ];
        return $key ? $dropdowns[$key] : $dropdowns;
    }

    /* ============== END ===================*/

    public static function systemShortcodesWithValues()
    {
        return [
            'current_date' => now()->format('Y-m-d'),
            'current_datetime' => '',
            'current_time' => '',
            'system_url' => '',
            'app_name' => ''
        ];
    }

    // Transaction Type
    public const TRANSACTION_TYPE_DEPOSIT  = 'deposit';
    public const TRANSACTION_TYPE_WITHDRAW = 'withdraw';

    public static function getTransactionType(string $type = null)
    {
        $types = [
            self::TRANSACTION_TYPE_DEPOSIT  => "Deposit",
            self::TRANSACTION_TYPE_WITHDRAW => "Withdraw"
        ];
        return $type ? $types[$type] : $types;
    }

    // Payment Method
    public const PAYMENT_METHOD_GATEWAY = 'gateway';
    public const PAYMENT_METHOD_CASH = 'cash';
    public const PAYMENT_METHOD_BANK_TRANSFER = 'bank_transfer';

    public static function getPaymentMethod(string $type = null)
    {
        $types = [
            self::PAYMENT_METHOD_GATEWAY => "Gateway",
            self::PAYMENT_METHOD_CASH => "Cash",
            self::PAYMENT_METHOD_BANK_TRANSFER => "Bank Transfer"
        ];
        return $type ? $types[$type] : $types;
    }

    // Payment Status
    public const PAYMENT_METHOD_PENDING = 1;
    public const PAYMENT_METHOD_PROCESSING = 2;
    public const PAYMENT_METHOD_HOLD = 3;
    public const PAYMENT_METHOD_COMPLETED = 4;
    public const PAYMENT_METHOD_DECLINED = 5;

    public static function getPaymentStatus(string $status = null)
    {
        $status_arr = [
            self::PAYMENT_METHOD_PENDING => "Pending",
            self::PAYMENT_METHOD_PROCESSING => "Processing",
            self::PAYMENT_METHOD_HOLD => "Hold",
            self::PAYMENT_METHOD_COMPLETED => "Completed",
            self::PAYMENT_METHOD_DECLINED => "Declined",
        ];
        return $status ? $status_arr[$status] : $status_arr;
    }

    // Device Type
    public const TRANSACTION_DEVICE_TYPE_WEB = 'web';
    public const TRANSACTION_DEVICE_TYPE_ANDROID = 'android';
    public const TRANSACTION_DEVICE_TYPE_IOS = 'ios';

    public static function getDeviceType(string $type = null)
    {
        $types = [
            self::TRANSACTION_DEVICE_TYPE_WEB => "Web",
            self::TRANSACTION_DEVICE_TYPE_ANDROID => "Android",
            self::TRANSACTION_DEVICE_TYPE_IOS => "IOS"
        ];
        return $type ? $types[$type] : $types;
    }

    // Device Type
    public const PAYMENT_TYPE_WITHDRAW = 'withdraw';
    public const PAYMENT_TYPE_DEPOSIT  = 'deposit';
    public const PAYMENT_TYPE_DONATION = 'donation';
    public const PAYMENT_TYPE_SEND_MONEY = 'send_money';
    public const PAYMENT_TYPE_RECEIVE_MONEY = 'receive_money';

    public static function getPaymentType(string $type = null)
    {
        $types = [
            self::PAYMENT_TYPE_WITHDRAW => "Withdraw",
            self::PAYMENT_TYPE_DEPOSIT  => "Deposit",
            self::PAYMENT_TYPE_DONATION => "Donation",
            self::PAYMENT_TYPE_SEND_MONEY => "Send Money",
            self::PAYMENT_TYPE_RECEIVE_MONEY => "Receive Money"
        ];
        return $type ? $types[$type] : $types;
    }

        // Asset Module Start
        public const ASSET_GOOD = 0;
        public const ASSET_DAMAGE = 1;
        public const ASSET_LOST = 2;

        public static function getAssetStatus(string $type = null)
        {
            $types = [
                self::ASSET_GOOD => "Good",
                self::ASSET_DAMAGE => "Damage",
                self::ASSET_LOST => "Lost",
            ];

            if (isset($type) && $type == 0) {
                return $types[$type];
            }

            return $type ? $types[$type] : $types;
        }

            // Blog Module Start
    public const BLOG_ACTIVE = 1;
    public const BLOG_INACTIVE = 0;

    public static function getBlogStatus(string $type = null)
    {
        $types = [
            self::BLOG_ACTIVE => "Active",
            self::BLOG_INACTIVE => "Inactive",
        ];

        if (isset($type) && $type == 0) {
            return $types[$type];
        }

        return $type ? $types[$type] : $types;
    }
    // Blog Module End

    // Start General Status
    public const STATUS_ACTIVE = 1;
    public const STATUS_INACTIVE = 0;

    public static function getStatus(string $type = null)
    {
        $types = [
            self::STATUS_ACTIVE => "Active",
            self::STATUS_INACTIVE => "Inactive",
        ];

        if (isset($type) && $type == 0) {
            return $types[$type];
        }

        return $type ? $types[$type] : $types;
    }
    // End General Status

    // Categories entry type
    public const CATEGORY_BULK = 0;
    public const CATEGORY_INDIVIDUAL = 1;

    public static function getCategoryEntryType(string $type = null)
    {
        $types = [
            self::CATEGORY_BULK => "Bulk",
            self::CATEGORY_INDIVIDUAL => "Individual",
        ];

        if (isset($type) && $type == 0) {
            return $types[$type];
        }

        return $type ? $types[$type] : $types;
    }

    // Stock status
    public const STOCK_AVAILABLE = 1;
    public const STOCK_ASSIGNED = 2;
    public const STOCK_WARRANTY = 3;
    public const STOCK_DAMAGED = 4;
    public const STOCK_MISSING = 5;
    public const STOCK_EXPIRED = 6;
    public const STOCK_RETURN = 7;
    public const STOCK_OUT = 8;

    public static function getStockStatus(string $type = null)
    {
        $types = [
            self::STOCK_AVAILABLE => "Available",
            self::STOCK_ASSIGNED  => "Assigned",
            self::STOCK_WARRANTY  => "Warranty",
            self::STOCK_DAMAGED   => "Damaged",
            self::STOCK_MISSING   => "Missing",
            self::STOCK_EXPIRED   => "Expired",
            self::STOCK_RETURN    => "Returned",
            self::STOCK_OUT       => "Stock Out",
        ];

        if (isset($type) && $type == 0) {
            return $types[$type];
        }

        return $type ? $types[$type] : $types;
    }
}

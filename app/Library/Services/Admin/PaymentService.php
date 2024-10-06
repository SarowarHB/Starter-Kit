<?php


namespace App\Library\Services\Admin;

use App\Library\Enum;
use App\Library\Helper;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Payment;

class PaymentService extends BaseService
{
    public function dataTable($type)
    {
        $data = Payment::where('type', $type)->orderBy('id', 'DESC')->select('*');
        return DataTables::of($data)
                ->addIndexColumn()

                ->addColumn('created_at', function($row) {
                    return $row->created_at->format('d-m-Y H:i A');
                })

                ->addColumn('amount', function($row){
                    return ''.env('CURRENCY_SIGN').' '.number_format($row->amount, 2).'';
                })
                ->make(true);
    }

    public static function donationByCampId($camp_id)
    {
        return Payment::where('type', Enum::PAYMENT_TYPE_DONATION)->where('camp_id', $camp_id)->get();
    }

    public static function totalDonationByCampId($camp_id)
    {
        return Payment::where('type', Enum::PAYMENT_TYPE_DONATION)->where('camp_id', $camp_id)->sum('amount');
    }
}

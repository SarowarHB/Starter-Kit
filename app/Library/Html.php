<?php


namespace App\Library;


class Html
{

    public static function linkBack(string $route)
    {
        return '<a href="' . $route . '" class="btn btn-sm btn2-secondary btn-back "><i class="fas fa-long-arrow-alt-left"></i> Back</a>';
    }

    public static function linkAdd(string $route, string $label, string $size = 'btn-sm')
    {
        return '<a href="' . $route . '" class="btn btn-sm btn2-secondary ' . $size . '"><i class="fas fa-plus"></i> ' . $label . '</a>';
    }

    public static function btnSubmit($size = '')
    {
        return '<button type="submit" class="btn mr-3 my-3 btn2-secondary '.$size.'"><i class="fas fa-save"></i> Save</button>';
    }

    public static function btnReset()
    {
        return '<button type="reset" class="btn mr-3 my-3 btn2-light-secondary"><i class="fas fa-sync-alt"></i> Reset</button>';
    }

    public static function btnClose()
    {
        return '<button type="button" class="btn btn2-light-secondary mr-3" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>';
    }

    public static function stockStatusBadge( $status )
    {
        if($status == Enum::STOCK_AVAILABLE){
            $badge = '<div class="badge btn2-secondary">' . Enum::getStockStatus(Enum::STOCK_AVAILABLE) . '</div>';
        }
        else if ($status == Enum::STOCK_ASSIGNED){
            $badge = '<div class="badge badge-primary">' . Enum::getStockStatus(Enum::STOCK_ASSIGNED) . '</div>';
        }
        else if ($status == Enum::STOCK_WARRANTY){
            $badge = '<div class="badge badge-secondary">' . Enum::getStockStatus(Enum::STOCK_WARRANTY) . '</div>';
        }
        else if ($status == Enum::STOCK_DAMAGED){
            $badge = '<div class="badge badge-warning">' . Enum::getStockStatus(Enum::STOCK_DAMAGED) . '</div>';
        }
        else if ($status == Enum::STOCK_MISSING){
            $badge = '<div class="badge badge-dark">' . Enum::getStockStatus(Enum::STOCK_MISSING) . '</div>';
        }
        else if ($status == Enum::STOCK_EXPIRED){
            $badge = '<div class="badge badge-danger">' . Enum::getStockStatus(Enum::STOCK_EXPIRED) . '</div>';
        }else{
            $badge = '<div class="badge btn2-secondary">' . Enum::getStockStatus(Enum::STOCK_EXPIRED) . '</div>';
        }

        return $badge;
    }

    public static function AcknoledgementStatus( $status )
    {
        if($status == 1){
            $badge = '<div class="badge btn2-secondary"> Accept </div>';
        }else{
            $badge = '<div class="badge badge-danger">Pending</div>';
        }
        return $badge;
    }

}

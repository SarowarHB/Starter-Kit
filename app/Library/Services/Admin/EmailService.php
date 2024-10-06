<?php


namespace App\Library\Services\Admin;

use Illuminate\Support\Facades\Mail;
use App\Models\EmailHistory;
use App\Mail\DefaultMail;
use Exception;

class EmailService extends BaseService
{
    public static function createHistory(array $data): bool
    {
        try{
            EmailHistory::create($data);
            return true;
        }
        catch (Exception $e){
            return false;
        }
    }

    public static function sendMail(array $data): bool
    {
        try{
            EmailService::createHistory($data);
            Mail::to($data['email'])->send(new DefaultMail($data['subject'], $data['message']));

            return true;
        }
        catch (Exception $e){
            return false;
        }
    }
}

<?php


namespace App\Library\Services\Admin;

use App\Models\Config;
use Exception;

class ConfigService extends BaseService
{
    public function updateConfig(string $key, string $value)
    {
        try{
            $config = Config::firstOrNew(['key' => $key]);
            $config->value = $value;
            $config->save();
            return $this->handleSuccess('Successfully updated');
        }
        catch (Exception $e){
            return $this->handleException($e);
        }
    }

    public static function getByKey(string $key)
    {
        return Config::where('key', $key)->first();
    }

    public static function getDropdowns(string $key)
    {
        $config = self::getByKey($key);
        return $config && $config->value ? json_decode($config->value) : [];
    }


}

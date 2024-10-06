<?php

namespace App\Observers;

use App\Models\Config;
use App\Library\Helper;

class ConfigObserver
{
    /**
     * Handle the Config "created" event.
     *
     * @param  \App\Models\Config  $config
     * @return void
     */
    public function created(Config $config)
    {
        $difference = Helper::getDifference($config, false, true);

        Helper::createActivityLog('Created', 'Configuration', $config->id, $difference, request()->ip(), request()->userAgent());
    }

    /**
     * Handle the Config "updated" event.
     *
     * @param  \App\Models\Config  $config
     * @return void
     */
    public function updated(Config $config)
    {
        $difference = Helper::getDifference($config, true);

        Helper::createActivityLog('Updated', 'Configuration', $config->id, $difference, request()->ip(), request()->userAgent());
    }

    /**
     * Handle the Config "deleted" event.
     *
     * @param  \App\Models\Config  $config
     * @return void
     */
    public function deleted(Config $config)
    {
        $difference = Helper::getDifference($config);

        Helper::createActivityLog('Deleted', 'Configuration', $config->id, $difference, request()->ip(), request()->userAgent());
    }

    /**
     * Handle the Config "restored" event.
     *
     * @param  \App\Models\Config  $config
     * @return void
     */
    public function restored(Config $config)
    {
        $difference = Helper::getDifference($config);

        Helper::createActivityLog('Restored', 'Configuration', $config->id, $difference, request()->ip(), request()->userAgent());
    }

    /**
     * Handle the Config "force deleted" event.
     *
     * @param  \App\Models\Config  $config
     * @return void
     */
    public function forceDeleted(Config $config)
    {
        $difference = Helper::getDifference($config);

        Helper::createActivityLog('Force Deleted', 'Configuration', $config->id, $difference, request()->ip(), request()->userAgent());
    }
}

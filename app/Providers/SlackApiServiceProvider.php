<?php
/**
 * Created by PhpStorm.
 * User: Herminio
 * Date: 06/06/2015
 * Time: 03:13 PM
 */

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Frlnc\Slack\Http\SlackResponseFactory;
use Frlnc\Slack\Http\CurlInteractor;
use Frlnc\Slack\Core\Commander;

class SlackApiServiceProvider extends ServiceProvider{

    /**
     * R4egister the Slack service provider.
     *
     * @return \Frlnc\Slack\Core\Commander
     */
    public function register()
    {
        $this->app->singleton('Frlnc\Slack\Core\Commander',function(){
            return new Commander(env('SLACK_TOKEN'),$this->getInteractor());
        });
    }

    /**
     * Get a Instance of Interactor
     *
     * @return CurlInteractor
     */
    private function getInteractor()
    {
        $interactor = new CurlInteractor();
        $interactor->setResponseFactory(new SlackResponseFactory());

        return $interactor;
    }
}
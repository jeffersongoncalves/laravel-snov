<?php

namespace JeffersonGoncalves\Snov\Facades;

use Illuminate\Support\Facades\Facade;
use JeffersonGoncalves\Snov\Resources\Campaigns;
use JeffersonGoncalves\Snov\Resources\Domains;
use JeffersonGoncalves\Snov\Resources\Emails;
use JeffersonGoncalves\Snov\Resources\Lists;
use JeffersonGoncalves\Snov\Resources\Prospects;
use JeffersonGoncalves\Snov\Resources\Technology;
use JeffersonGoncalves\Snov\SnovClient;

/**
 * @method static Domains domains()
 * @method static Emails emails()
 * @method static Prospects prospects()
 * @method static Lists lists()
 * @method static Technology technology()
 * @method static Campaigns campaigns()
 * @method static string accessToken()
 *
 * @see SnovClient
 */
class Snov extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'snov';
    }
}

<?php

namespace App\Providers;

use App\SAML\CustomSaml2Provider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use SocialiteProviders\Manager\SocialiteWasCalled;
use App\Models\StrategicPlan;
use App\Models\Topic;
use App\Models\Goal;
use App\Models\Objective;
use App\Models\Indicator;
use App\Observers\StrategicPlanObserver;
use App\Observers\TopicObserver;
use App\Observers\GoalObserver;
use App\Observers\ObjectiveObserver;
use App\Observers\IndicatorObserver;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        StrategicPlan::observe(StrategicPlanObserver::class);
        Topic::observe(TopicObserver::class);
        Goal::observe(GoalObserver::class);
        Objective::observe(ObjectiveObserver::class);
        Indicator::observe(IndicatorObserver::class);
        Blade::if('role', function (...$roles) {
            return auth()->check() && in_array(auth()->user()->u_type, $roles);
        });
        Event::listen(function (\SocialiteProviders\Manager\SocialiteWasCalled $event) {
            $event->extendSocialite('saml2', \SocialiteProviders\Saml2\Provider::class);
        });


    }
}

<?php

namespace App\Http\Controllers\Site;

use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;

class Lan extends Controller
{
    public function __invoke(): View
    {
        $teamName = Config::string('team-lan.team_name');
        $logo = Config::string('team-lan.logo');
        $title = '3ème LAN annuelle';

        $announced = Config::boolean('team-lan.next_lan.announced', false);

        /** @var Carbon $startDate */
        $startDate = Config::get('team-lan.next_lan.dates.start');

        /** @var Carbon $endDate */
        $endDate = Config::get('team-lan.next_lan.dates.end');

        $maxAttendees = Config::integer('team-lan.next_lan.attendees.max', 0);
        $currentAttendees = Config::integer('team-lan.next_lan.attendees.current', 0);

        $locationName = Config::string('team-lan.next_lan.location.name', '');
        $locationUrl = Config::string('team-lan.next_lan.location.url', '');

        // Global
        SEOTools::setTitle($title);
        SEOTools::setDescription("Infos à propos de la LAN annuelle organisée par la team $teamName.");

        // JSON-LD
        if ($announced) {
            SEOTools::jsonLdMulti()
                ->addValue('about', array_filter([
                    '@type' => 'SocialEvent',
                    'name' => $title,
                    'description' => $title,
                    'url' => URL::current(),
                    'image' => asset($logo),
                    'eventAttendanceMode' => 'https://schema.org/OfflineEventAttendanceMode',
                    'organizer' => SEOTools::organizationJsonLd(),
                    'startDate' => $startDate->toDateString(),
                    'endDate' => $endDate->toDateString(),
                    'location' => $locationName ? [
                        '@type' => 'City',
                        'name' => $locationName,
                    ] : null,
                    'maximumAttendeeCapacity' => $maxAttendees,
                    'remainingAttendeeCapacity' => $maxAttendees - $currentAttendees,
                ]));
        }

        return site_view('lan', compact('announced', 'startDate', 'endDate', 'maxAttendees',
            'currentAttendees', 'locationName', 'locationUrl'));
    }
}

<?php

namespace App\Enums;

enum SectionEnum: string
{
    const BG = 'bg image section';

    case HOME_BANNER = 'home banner section';
    case HOME_ABOUT_CMC = 'home about CMC section';
    case HOME_DONATE = 'home donate section';

    case WHOWEARE_BANNER = 'who we are banner section';
    case WHOWEARE_COMMITTED = 'who we are committed section';
    case WHOWEARE_COMMITTEDS = 'who we are committeds section';
    case WHOWEARE_DIFFERENCE = 'who we are difference section';
    case WHOWEARE_DIFFERENCES = 'who we are differences section';

    case WHOWEARE_MISSION_VISSION = 'who we are mission vission section';
    case WHOWEARE_MISSION_VISSIONS = 'who we are mission vissions section';

    case WHOWEARE_DISCOVER_VALUES = 'who we are discover values section';
    case WHOWEARE_DISCOVER_VALUESS = 'who we are discover valuess section';

    //Footer
    case FOOTER = 'footer';
    case SOLUTION = "solution";
    
}

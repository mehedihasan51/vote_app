<?php

namespace App\Enums;

enum PageEnum: string
{
    const AUTH           = 'login';
    const REGISTER       = 'register';
    const HOME           = 'home page';
    const WHOWEARE       = 'who we are';
    
    const LEADERS        = 'leaders page';
    const policeS       = 'polices page';
    const NEWS_EVENTS    = 'news & events';
    const NEWS_DETAIL    = 'news detail';
    const EVENT_DETAIL   = 'event detail';
    const SERVAY_SHOW    = 'survey show';
    const CONTACT_US     = 'contact us';
    const DONATE         = 'donate';
    const COMMON         = 'common';
}

<?php
// Best-effort keyword screening, not a substitute for human moderation.
function normalizeText(string $text): string
{
    $text = strtolower($text);
    $text = strtr($text, ['0'=>'o','1'=>'i','!'=>'i','3'=>'e','4'=>'a','@'=>'a','5'=>'s','$'=>'s','7'=>'t','9'=>'g','8'=>'b','|'=>'i']);
    return preg_replace('/[^a-z]/', '', $text);
}

function isBanned(string $text): bool
{
    $keywords = [

        'nigger', 'niggas', 'nigers', 'niggar', 'niggaz', 'niglet', 'coon', 'chinc', 'chincs', 'gook', 'gooks', 'spic', 'spics',
        'kike', 'kikes', 'wetback', 'wetbac', 'zipperhead',  'coloreds', 'darkie', 'darkies', 'slope', 'slopes', 'beaner', 'beaners',

        'fuckingkids', 'fuckinkids', 'fucxingkids', 'fuckingchildren', 'fuckinchildren', 'childabuse', 'minorabuse',
        'pedophile', 'pedo', 'pedos', 'groomer', 'grooming', 'touchkids', 'kidtouch', 'kidssex', 'childsex',

        'childporn', 'kidsporn', 'molest', 'molests', 'molesting',

        'faggot', 'faggots', 'fagget', 'fag', 'fags', 'dyke', 'dykes', 'tranny', 'trannies',
        'lgbtqismentallyill', 'gayismentallyill', 'transismentallyill', 'troon', 'troons', 'sodomite', 'sodomites',

        'jewsrape', 'jewscontrol', 'jewsbad', 'jewishcontrol', 'jewishcabal', 'zionistconspiracy', 'holocaustdenier',  'heeb', 'heebs',

        'massmigrationbad', 'illegals', 'illegalaliens', 'invaders', 'deportthemall',

        '1488', 'hailhitler', 'whitepower', 'whitesupremacy', 'kkk', 'nazis', 'hitlerr',
        'seigheil', 'swastika', 'aryan', 'supremacist',

        'rape', 'raping', 'rapist', 'suicidebomb', 'terrorist', 'genocide', 'murderall', 'killall', 'deathwish', 'violenceagainst',
        'hatecrime', 'bestiality', 'beastiality', 'incest', 'incestuous', 'childmarriage', 'torture', 'mutilate', 'abused', 'abuser',

    ];

    $normalized = normalizeText($text);
    foreach ($keywords as $keyword) {
        $needle = normalizeText($keyword);
        if ($needle !== '' && strpos($normalized, $needle) !== false) {
            return true;
        }
    }
    return false;
}

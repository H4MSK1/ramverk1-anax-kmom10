<?php
/**
 * Supply the basis for the navbar as an array.
 */

$kmomSubMenu = function ($kmom) {
    return [
        "text" => ucfirst($kmom),
        "url" => "redovisning/{$kmom}",
        "title" => "Redovisning för {$kmom}.",
    ];
};

return [
    // Use for styling the menu
    "wrapper" => null,
    "class" => "my-navbar rm-default rm-desktop",
 
    // Here comes the menu items
    "items" => [
        [
            "text" => "Hem",
            "url" => "",
            "title" => "Första sidan, börja här.",
        ],
        [
            "text" => "Redovisning",
            "url" => "redovisning",
            "title" => "Redovisningstexter från kursmomenten.",
            "submenu" => [
                "items" => [
                    $kmomSubMenu("kmom01"),
                    $kmomSubMenu("kmom02"),
                    $kmomSubMenu("kmom03"),
                    $kmomSubMenu("kmom04"),
                    $kmomSubMenu("kmom05"),
                    $kmomSubMenu("kmom06"),
                    $kmomSubMenu("kmom10"),
                ],
            ],
        ],
        [
            "text" => "Om",
            "url" => "om",
            "title" => "Om denna webbplats.",
        ],
        //[
        //    "text" => "Styleväljare",
        //    "url" => "style",
        //    "title" => "Välj stylesheet.",
        //],
        //[
        //    "text" => "Verktyg",
        //    "url" => "verktyg",
        //    "title" => "Verktyg och möjligheter för utveckling.",
        //],
        [
            "text" => "IP Validator",
            "url" => "ipvalidator/default",
            "submenu" => [
                "items" => [
                    [
                        "text" => "Default",
                        "url" => "ipvalidator/default",
                        "title" => "IP Validator",
                    ],
                    [
                        "text" => "REST-API",
                        "url" => "ipvalidator/api",
                        "title" => "IP Validator",
                    ],
                ],
            ],
            "title" => "Validera IP adresser",
        ],
        [
            "text" => "IP Locator",
            "url" => "iplocator/default",
            "submenu" => [
                "items" => [
                    [
                        "text" => "Default",
                        "url" => "iplocator/default",
                        "title" => "IP Locator",
                    ],
                    [
                        "text" => "REST-API",
                        "url" => "iplocator/api",
                        "title" => "IP Locator",
                    ],
                ],
            ],
            "title" => "Lokalisera IP adresser",
        ],
        [
            "text" => "Weather",
            "url" => "weather/default",
            "submenu" => [
                "items" => [
                    [
                        "text" => "Default",
                        "url" => "weather/default",
                        "title" => "Weather",
                    ],
                    [
                        "text" => "REST-API",
                        "url" => "weather/api",
                        "title" => "Weather",
                    ],
                ],
            ],
            "title" => "Weather API",
        ],
        [
            "text" => "Book",
            "url" => "book",
            "title" => "Book CRUD",
        ],
    ],
];

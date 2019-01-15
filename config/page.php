<?php
/**
 * Configuration file for page which can create and put together web pages
 * from a collection of views. Through configuration you can add the
 * standard parts of the page, such as header, navbar, footer, stylesheets,
 * javascripts and more.
 */
return [
    // This layout view is the base for rendering the page, it decides on where
    // all the other views are rendered.
    "layout" => [
        "region" => "layout",
        "template" => "app/layout",
        "data" => [
            "baseTitle" => " | Tech Overflow",
            "bodyClass" => null,
            "favicon" => "favicon.ico",
            "htmlClass" => null,
            "lang" => "sv",
            "stylesheets" => [
                "https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css",
                "css/app.css",
            ],
            "javascripts" => [
                "https://code.jquery.com/jquery-3.3.1.slim.min.js",
                "https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js",
                "https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js",
            ],
        ],
    ],

    // These views are always loaded into the collection of views.
    "views" => [
    ],
];

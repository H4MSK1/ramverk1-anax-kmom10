<?php
/**
 * Configuration file for DI container.
 */
return [

    // Services to add to the container.
    "services" => [
        "curl" => [
            "shared" => true,
            "callback" => function () {
                $config = $this->get("configuration")->load("api.php");
                $apiServices = $config["config"]["services"];

                return new \H4MSK1\Curl\Api($apiServices, $this);
            }
        ],
    ],
];

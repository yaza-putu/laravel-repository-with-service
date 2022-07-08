<?php

return [
    /**
     * The directory for all the repositories
     */
    "repository_directory" => "app/Repositories",

    /**
     * Default repository namespace
     */
    "repository_namespace" => "App\Repositories",

    /**
     * The directory for all the services
     */
    "service_directory" => "app/Services",

    /**
     * Default service namespace
     */
    "service_namespace" => "App\Services",

    /**
     * extend service bind
     * Change resolved interface container to new implement class
     */
    "extend_bind_services" => [
        "app\Services\User\UserService" => "app\Services\Second\SecondServiceImplement"
    ],

    /**
     * extend repository bind
     * Change resolved interface container to new implement class
     */
    "extend_bind_repositories" => [

    ]
];

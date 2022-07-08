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
     * change bind repository on IoC
     */
    "bind_repository" => [
        // "NameOfInterface" => "NameOfImplementClass"
    ],

    /**
     * change bind service on IoC
     */
    "bind_service" => [
        // "NameOfInterface" => "NameOfImplementClass"
        "App\Services\User\UserService" => "App\Services\SecondServiceImplement"
    ],
];

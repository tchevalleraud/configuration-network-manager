<?php
    use OpenApi\Annotations as OA;

    /**
     * @OA\Info(
     *     title="Symfony Docker Project - API",
     *     version="0.1",
     *     description="Symfony Docker Project provides RESTful API service for external and internal applications.",
     *     @OA\Contact(email="thibault.chevalleraud@gmail.com")
     * )
     *
     * @OA\Server(
     *     url="http://localhost/api/v2/",
     *     description="Localhost"
     * )
     *
     * @OA\Schema(
     *     schema="DateTime",
     *     allOf={
     *         @OA\Schema(
     *             @OA\Property(property="date", type="string", format="date-time"),
     *             @OA\Property(property="timezone_type", type="integer", default="3"),
     *             @OA\Property(property="timezone", type="string", default="UTC")
     *         )
     *     }
     * )
     *
     * @OA\Schema(
     *     schema="Response200",
     *     allOf={
     *         @OA\Schema(
     *             @OA\Property(property="code", type="integer", default="200"),
     *             @OA\Property(property="datetime", type="array", @OA\Items(), ref="#/components/schemas/DateTime"),
     *             @OA\Property(property="message", type="string", default="OK")
     *         )
     *     }
     * )
     */
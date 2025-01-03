<?php

declare(strict_types=1);
use Psr\Http\Message\ResponseInterface;
use Reun\TestUtilities\PsrHttp;

describe(PsrHttp::class, function () {
    it("should create and respond to a JSON request", function () {
        $psrHttp = new PsrHttp();
        $request = $psrHttp->createJsonRequest("GET", "/admin/users");
        $response = $psrHttp->handle($request);
        expect($response)->toBeInstanceOf(ResponseInterface::class);
    });
});

<?php

declare(strict_types=1);

namespace Reun\TestUtilities;

use Codeception\Specify;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

/**
 * @internal
 *
 * @group integration
 *
 * @covers \Reun\TestUtilities\PsrHttp
 */
final class PsrHttpTest extends TestCase
{
    use Specify;

    public function testPsrHttp(): void
    {
        $this->it("should create and respond to a JSON request", function () {
            $psrHttp = new PsrHttp();
            $request = $psrHttp->createJsonRequest("GET", "/admin/users");
            $response = $psrHttp->handle($request);
            $this->assertInstanceOf(ResponseInterface::class, $response);
        });
    }
}

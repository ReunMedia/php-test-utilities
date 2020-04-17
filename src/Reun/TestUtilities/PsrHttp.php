<?php

declare(strict_types=1);

namespace Reun\TestUtilities;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Psr7\Factory\ResponseFactory;
use Slim\Psr7\Factory\ServerRequestFactory;

class PsrHttp implements RequestHandlerInterface
{
  private ResponseFactoryInterface $responseFactory;

  private ServerRequestFactoryInterface $serverRequestFactory;

  public function __construct(ResponseFactoryInterface $responseFactory = null, ServerRequestFactoryInterface $serverRequestFactory = null)
  {
    $this->responseFactory = $responseFactory ?? new ResponseFactory();
    $this->serverRequestFactory = $serverRequestFactory ?? new ServerRequestFactory();
  }

  public function createRequest(string $method, string $uri, string $body = "", array $headers = []): ServerRequestInterface
  {
    $request = $this->serverRequestFactory->createServerRequest($method, $uri);
    $request->getBody()->write($body);
    foreach ($headers as $name => $value) {
      $request = $request->withHeader($name, $value);
    }

    return $request;
  }

  public function createJsonRequest(string $method, string $uri, array $data = []): ServerRequestInterface
  {
    return $this->createRequest($method, $uri, \json_encode($data), ["Content-Type" => "application/json"]);
  }

  public function handle(ServerRequestInterface $request): ResponseInterface
  {
    return $this->responseFactory->createResponse();
  }
}

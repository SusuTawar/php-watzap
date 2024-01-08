<?php
namespace PhpWatzap\HttpClient;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response as GuzzleResponse;

class HttpGuzzle implements HttpClient
{
  private $client;

  public function __construct()
  {
    $this->client = new Client();
  }

  public function get(string $url, array $headers, array $queries)
  {
    return $this->client->request('GET', $url, ['headers' => $headers, 'query' => $queries]);
  }

  public function post(string $url, array $headers, array $body, string $formType = 'json')
  {
    return $this->sendData('POST', $url, $headers, $body, $formType);
  }

  public function put(string $url, array $headers, array $body, string $formType = 'json')
  {
    return $this->sendData('PUT', $url, $headers, $body, $formType);
  }

  public function patch(string $url, array $headers, array $body, string $formType = 'json')
  {
    return $this->sendData('PATCH', $url, $headers, $body, $formType);
  }

  public function delete(string $url, array $headers)
  {
    return $this->client->request('DELETE', $url, ['headers' => $headers]);
  }

  private function sendData($method, $url, $headers, $body, $formType)
  {
    $options = ['headers' => $headers];
    $options[$formType] = $body;
    $response = $this->client->request($method, $url, $options);

    return $this->toCustomResponse($response);
  }

  private function toCustomResponse(GuzzleResponse $response)
  {
    $body = '';
    try {
      $body = json_decode($response->getBody()->getContents());
    } catch (Exception $e) {
      $body = $response->getBody()->getContents();
    }
    return new Response(
      $response->getStatusCode(),
      $response->getHeaders(),
      $body,
    );
  }
}

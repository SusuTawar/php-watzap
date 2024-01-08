<?php

namespace PhpWatzap;

use PhpWatzap\HttpClient\HttpClient;
use PhpWatzap\HttpClient\HttpGuzzle;
use PhpWatzap\HttpClient\HttpLaravel;
use PhpWatzap\HttpClient\Response;

class WatZap
{
  private HttpClient $httpClient;
  private string $baseUrl = "https://api.watzap.id/v1";
  private string $apiKey = "";

  public function __construct(string $apiKey, string $baseUrl = "https://api.watzap.id/v1", bool $isLaravel = false)
  {
    $this->baseUrl = $baseUrl;
    $this->apiKey = $apiKey;
    if ($isLaravel) {
      $this->httpClient = new HttpLaravel();
    } else {
      $this->httpClient = new HttpGuzzle();
    }
  }

  private function post(string $url, array $data = []) {
    $data['api_key'] = $this->apiKey;
    return $this->httpClient->post("$this->baseUrl/$url", [], $data);
  }

  /**
   * Check API Status
   *
   * @return Response
   * @see https://api-docs.watzap.id/#25ee45d1-00c9-41ea-ae25-18960ff09176
   */
  public function apiKey(): Response
  {
    return $this->post('checking_key');
  }

  /**
   * Validate WhatsApp Number
   *
   * @param string $numberKey
   * @param string $phone_no
   * @return Response
   * @see https://api-docs.watzap.id/#10765c80-3069-4d11-af16-efe417ef94af
   */
  public function validateNumber(string $numberKey, string $phone_no): Response
  {
    return $this->post('validate_number', ["number_key" => $numberKey, "phone_no" => $phone_no]);
  }

  /**
   * Group Contact Grabber
   *
   * @param string $numberKey
   * @return Response
   * @see https://api-docs.watzap.id/#b58962cc-1344-4cb6-99ad-4e9c977ea04c
   */
  public function groups(string $numberKey): Response
  {
    return $this->post('groups', ["number_key" => $numberKey]);
  }

  /**
   * Send Text Message
   *
   * @param string $numberKey
   * @param string $receiver
   * @param string $message
   * @param string $toGroup flag receiver as group_id instead of phone number
   * @return Response
   * @see https://api-docs.watzap.id/#a74221e6-a33e-499a-b897-20cf9d514d46 phone number
   * @see https://api-docs.watzap.id/#5d60a7d1-b27c-4dab-99b6-1537950e791c group
   */
  public function sendMessage(string $numberKey, string $receiver, string $message, bool $toGroup = false): Response
  {
    $url = $toGroup ? 'send_message_group' : 'send_message';
    $content = [
      "number_key" => $numberKey,
      ($toGroup ? "group_id" : "phone_no") => $receiver,
      "message" => $message,
    ];
    return $this->post($url, $content);
  }

  /**
   * Send Image (Caption)
   *
   * @param string $numberKey
   * @param string $receiver
   * @param string $imageUrl
   * @param string $caption
   * @param boolean $separateCaption
   * @param string $toGroup flag receiver as group_id instead of phone number
   * @return Response
   * @see https://api-docs.watzap.id/#caca089b-ac93-4377-ac85-e647cdfffa76 phone number
   * @see https://api-docs.watzap.id/#364590a5-69aa-434e-a940-8ee060da6e2d group
   */
  public function sendImage(string $numberKey, string $receiver, string $imageUrl, string $caption = "", bool $separateCaption = false, bool $toGroup = false): Response
  {
    $url = $toGroup ? 'send_image_group' : 'send_image_url';
    $content = [
      "number_key" => $numberKey,
      ($toGroup ? "group_id" : "phone_no") => $receiver,
      "url" => $imageUrl,
      "message" => $caption,
      "separate_caption" => $separateCaption ? 1 : 0,
    ];
    return $this->post($url, $content);
  }

  /**
   * Send File
   *
   * @param string $numberKey
   * @param string $receiver
   * @param string $fileUrl
   * @param string $toGroup flag receiver as group_id instead of phone number
   * @return Response
   * @see https://api-docs.watzap.id/#9ffcc6bd-865e-403d-bd89-6a7e8c866b0b phone number
   * @see https://api-docs.watzap.id/#1117fd53-a31b-4244-a274-513eedea5b9a group
   */
  public function sendFile(string $numberKey, string $receiver, string $fileUrl, bool $toGroup = false): Response
  {
    $url = $toGroup ? 'send_file_group' : 'send_file_url';
    $content = [
      "number_key" => $numberKey,
      ($toGroup ? "group_id" : "phone_no") => $receiver,
      "url" => $fileUrl,
    ];
    return $this->post($url, $content);
  }

  /**
   * Set Web Hook
   *
   * @param string $numberKey
   * @param string $endpoint
   * @return Response
   * @see https://api-docs.watzap.id/#c6e59515-f290-44cc-a62f-7644520bd19d
   */
  public function setWebhook(string $numberKey, string $endpoint): Response
  {
    return $this->post('set_webhook', [
      "number_key" => $numberKey,
      "endpoint_url" => $endpoint
    ]);
  }

  /**
   * Get Web Hook
   *
   * @param string $numberKey
   * @return Response
   * @see https://api-docs.watzap.id/#175161f0-9776-4764-964e-c46df2a327e3
   */
  public function getWebhook(string $numberKey): Response
  {
    return $this->post('get_webhook', [
      "number_key" => $numberKey,
    ]);
  }

  /**
   * Unset Web Hook
   *
   * @param string $numberKey
   * @return Response
   * @see https://api-docs.watzap.id/#f2d1953e-4d1e-4768-b7e4-74aec689326b
   */
  public function removeWebhook(string $numberKey): Response
  {
    return $this->post('unset_webhook', [
      "number_key" => $numberKey,
    ]);
  }
}

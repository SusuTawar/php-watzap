<?php

namespace PhpWatzap\Facade;

use Illuminate\Support\Facades\Facade;

/**
 * WatzapFacade
 *
 * @method static \PhpWatzap\HttpClient\Response apiKey()
 * @method static \PhpWatzap\HttpClient\Response validateNumber(string $numberKey, string $phone_no)
 * @method static \PhpWatzap\HttpClient\Response groups(string $numberKey)
 * @method static \PhpWatzap\HttpClient\Response sendMessage(string $numberKey, string $receiver, string $message, bool $toGroup = false)
 * @method static \PhpWatzap\HttpClient\Response sendImage(string $numberKey, string $receiver, string $imageUrl, string $caption = "", bool $separateCaption = false, bool $toGroup = false)
 * @method static \PhpWatzap\HttpClient\Response sendFile(string $numberKey, string $receiver, string $fileUrl, bool $toGroup = false)
 * @method static \PhpWatzap\HttpClient\Response setWebhook(string $numberKey, string $endpoint)
 * @method static \PhpWatzap\HttpClient\Response getWebhook(string $numberKey)
 * @method static \PhpWatzap\HttpClient\Response removeWebhook(string $numberKey)
 */
class Watzap extends Facade {
  protected static function getFacadeAccessor() {
      return 'watzap';
  }
}
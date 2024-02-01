<?php

namespace PhpWatzap\Commands;

use Illuminate\Console\Command;
use PhpWatzap\Facade\Watzap;

class WatzapKeys extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'watzap:keys';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Get registered phone number in of your watzap account';

  /**
   * Execute the console command.
   *
   * @return mixed
   */
  public function handle()
  {
    $request = Watzap::apiKey();
    $accounts = collect($request->body->data->licenses_key);
    $helperKey = "";
    foreach($accounts as $idx => $account) {
      $idx++;
      $this->info(
        "<fg=yellow;options=bold>$idx</>. <fg=white>WA number: +$account->wa_number </>" .
        ($account->is_connected ? "<fg=green>(online)</>" : "<fg=red>(offline)</>") .
        " <fg=cyan>[$account->plan]</>"
      );
      $helperKey .= " / ";
    }
    if ($accounts->isEmpty()) {
      $this->error("No WhatsApp number associated with this account");
      return;
    }
    if ($accounts->count() === 1) {
      $account = $accounts->first();
      $this->info("Key: <fg=black>$account->key</>");
      return;
    }
    $helperKey = rtrim($helperKey, " / ");
    $index = $this->ask("<question>Show key ($helperKey)</>");
    if ($account = $accounts->get($index-1)) {
      $this->info("Key: <fg=black>$account->key</>");
    }
  }
}

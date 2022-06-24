<?php

namespace App\Services;

use App\Jobs\PullWebsiteTitle;
use App\Repositories\Shorten\ShortenRepository;
use Carbon\Carbon;
use Exception;

class ShortenUrlService
{
  public function __construct()
  {
    $this->shortenRepository = new ShortenRepository();
  }

  public function execute(array $input)
  {
    try {
      $timeHash = Carbon::now()->timestamp;
      $hashed = substr(md5($input["url"]), 0, 4);
      $input["shortened_url"] = "{$hashed}{$timeHash}";
      $shortened = $this->shortenRepository->store($input);
      PullWebsiteTitle::dispatchSync($input["url"]);
      return $this->shortenRepository->findById($shortened->id)->format();
    } catch (Exception $e) {
      throw new Exception($e->getMessage());
    }
  }
}

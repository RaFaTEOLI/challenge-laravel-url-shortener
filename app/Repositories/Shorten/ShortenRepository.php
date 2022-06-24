<?php

namespace App\Repositories\Shorten;

use App\Models\Shorten;
use App\Repositories\Abstract\AbstractRepository;
use Exception;

class ShortenRepository extends AbstractRepository
{
  protected $model = Shorten::class;

  public function updateWebsiteTitleByUrl(string $url, string $title)
  {
    try {
      $shortened = Shorten::where("url", $url)->firstOrFail();
      $shortened->update(["website_title" => $title]);
    } catch (Exception $e) {
      throw new Exception($e->getMessage(), 500);
    }
  }

  public function findByHash(string $hash)
  {
    try {
      $shortened = Shorten::where("shortened_url", $hash)->firstOrFail();
      return $shortened->format();
    } catch (Exception $e) {
      throw new Exception($e->getMessage(), 500);
    }
  }

  public function getTop100()
  {
    try {
      return Shorten::orderByDesc('accesses')->limit(100)->get()->map->format();
    } catch (Exception $e) {
      throw new Exception($e->getMessage(), 500);
    }
  }
}

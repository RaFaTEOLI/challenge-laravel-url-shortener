<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShortenRequest;
use App\Repositories\Shorten\ShortenRepository;
use App\Services\ShortenUrlService;
use Exception;
use Illuminate\Support\Facades\Redirect;

class ShortenController extends Controller
{
  public function register(ShortenRequest $request)
  {
    try {
      $input = $request->only(["url"]);
      $shortened = (new ShortenUrlService())->execute($input);
      return response()->json($shortened, 201);
    } catch (Exception $e) {
      return response()->json(["error" => $e->getMessage()]);
    }
  }
  public function show($hash)
  {
    try {
      $shortenedRepository = new ShortenRepository();
      $shortened = $shortenedRepository->findByHash($hash);
      $shortenedRepository->update($shortened->id, ["accesses" => $shortened->accesses + 1]);
      return Redirect::to($shortened->url);
    } catch (Exception $e) {
      return response()->json(["error" => $e->getMessage()]);
    }
  }
  public function index()
  {
    $shortenedRepository = new ShortenRepository();
    $list = $shortenedRepository->getTop100();

    return view("top100", [
      "list" => $list,
    ]);
  }
}

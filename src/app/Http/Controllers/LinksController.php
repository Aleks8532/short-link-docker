<?php

namespace App\Http\Controllers;

use App\Link;
use App\VisitStat;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Storage;

class LinksController extends Controller
{
    const STATS_COOKIE_NAME = 'statistics';

    //
    public function index()
    {
        return view('links.index');
    }

    public function redirect(Request $request)
    {
        $alias = (string)$request->route('path');

        //куки для проверки посетителя на уникальность
        $cookieStat = Cookie::get(self::STATS_COOKIE_NAME);
        $newCookie = null;

        if (empty($cookieStat)) {
            $cookieStat = bin2hex(random_bytes(10));
            $newCookie = Cookie::forever(
                self::STATS_COOKIE_NAME,
                $cookieStat
            );
        }

        $result = Link::where('link_alias', $alias)->first();

        if (empty($result)) {
            return $this->processResponse(
                'Ссылка не существует',
                'render',
                $newCookie,
                404
            );
        }

        if (Carbon::now() > $result->expire_date) {
            return $this->processResponse(
                'Срок жизни ссылки истек',
                'render',
                $newCookie,
                400
            );
        }

        if ($result->is_commercial) {

            $files = Storage::disk('public')->files('images');
            $randomFile = $files[rand(0, count($files) - 1)];

            $data = [
                'image' => Storage::url($randomFile),
                'destination' => $result->link_full
            ];

            $this->addToStat($result->id, $cookieStat, $randomFile);

            return $this->processResponse(
                view('links.commerce_link', $data),
                'render',
                $newCookie
            );
        } else {
            $this->addToStat($result->id, $cookieStat);


            return $this->processResponse(
                $result->link_full,
                'redirect',
                $newCookie
            );
        }

    }

    private function processResponse($content, $type, $cookie = null, $code = null)
    {
        if ($type === 'render') {
            $response = new Response;
            $response->setContent($content);

            if (!empty($code)) {
                $response->setStatusCode($code);
            }
        } elseif ($type === 'redirect') {
            $response = new RedirectResponse($content);

        } else {
            throw new \Exception('Invalid Response type');
        }

        if (!empty($cookie)) {
            $response->withCookie($cookie);
        }

        return $response;
    }

    public function addToStat(int $link_id, string $client_id, string $image_path = null)
    {
        $visitStat = new VisitStat;
        $visitStat->link_id = $link_id;
        $visitStat->client_id = $client_id;
        $visitStat->image_path = $image_path;
        $visitStat->save();
    }
}

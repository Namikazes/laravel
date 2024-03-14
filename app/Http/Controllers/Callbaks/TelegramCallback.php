<?php

namespace App\Http\Controllers\Callbaks;

use App\Http\Controllers\Controller;
use Azate\LaravelTelegramLoginAuth\TelegramLoginAuth;
use Illuminate\Http\Request;

class TelegramCallback extends Controller
{
    public function __invoke(TelegramLoginAuth $telegramLoginAuth, Request $request)
    {
        $data = $telegramLoginAuth->validate($request);

        auth()->user()->update([
            'telegram_id' => $data->getId()
        ]);

        notify()->success('You join on telegram');

        return redirect()->route('admin.dashboard');
    }
}

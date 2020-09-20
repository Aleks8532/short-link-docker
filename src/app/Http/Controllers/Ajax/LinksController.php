<?php

namespace App\Http\Controllers\Ajax;

use App\Link;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LinksController extends Controller
{
    public function add(Request $request)
    {
        $linkFull = $request->input('link-input');
        $linkAlias = $request->input('self-text') ?? '';
        $expireDate = $request->input('expireDate') ?? '';
        $isCommercial = $request->input('commercial') ?? false;
        $result = (new Link)->shorteningLink($linkFull, $linkAlias, $expireDate, $isCommercial);

        return $result;
    }
}

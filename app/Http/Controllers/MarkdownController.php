<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;

class MarkdownController extends Controller
{
    public function preview(Request $request)
    {
        $data = $request->input('markdown');
        $type = $request->input('type', 'minimal');

        $html = Str::marked($data ?? '', $type);

        return response()->json(['html' => $html]);
    }
}

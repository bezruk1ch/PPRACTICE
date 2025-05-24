<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SelectedBaseController extends Controller
{
    public function saveSelectedBase(Request $request)
    {
        $request->validate([
            'base_type' => 'required|string'
        ]);

        session()->put('selected_base', $request->base_type);

        return response()->json(['success' => true]);
    }
}

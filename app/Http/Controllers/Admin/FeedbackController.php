<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Feedback;

class FeedbackController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'phone'   => 'nullable|string|max:20',
            'message' => 'required|string',
        ]);

        Feedback::create($request->all());

        return response()->json(['message' => 'Заявка отправлена!']);
    }
    
    public function index()
    {
        $feedbacks = Feedback::latest()->paginate(10);

        return view('admin.feedbacks.index', compact('feedbacks'));
    }
}

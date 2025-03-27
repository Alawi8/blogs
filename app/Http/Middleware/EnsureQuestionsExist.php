<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Question;

class EnsureQuestionsExist
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Question::count() === 0) {
            return redirect()->route('home')->with('error', 'No questions available.');
        }

        return $next($request);
    }
}

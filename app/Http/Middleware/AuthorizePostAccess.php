<?php

namespace App\Http\Middleware;

use App\Post;
use Closure;

class AuthorizePostAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $post = Post::where('id', $request->route()->parameter('post')->id)->where('user_id', auth()->user()->id)->first();

        if (!$post) {
            return redirect()->route('home');
        }

        return $next($request);
    }
}

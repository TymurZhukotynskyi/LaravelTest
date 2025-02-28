<?php

namespace App\Http\Middleware;

use App\Models\Link;
use App\Repositories\Games\LinkRepository;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class CheckLink
{
    protected $linkRepository;

    public function __construct(LinkRepository $linkRepository)
    {
        $this->linkRepository = $linkRepository;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $uniqueLink = $request->route('link');;

        $link = Cache::get("link_{$uniqueLink}");
        if ($link && $link->is_active && $link->expires_at > now()) {
            $request->attributes->add(['link' => $link]);
            return $next($request);
        }

        $link = $this->linkRepository->findActiveLinkByUniqueLink($uniqueLink);
        if ($link instanceof Link) {
            $ttl = now()->diffInSeconds($link->expires_at);
            Cache::put("link_{$uniqueLink}", $link, $ttl);
            $request->attributes->add(['link' => $link]);
            return $next($request);
        }

        return redirect()->route('index');
    }
}

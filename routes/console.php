<?php

use App\Models\Post;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('posts:publish-scheduled-posts', function () {
    $updated = Post::where('status', Post::TYPE_SCHEDULED)
        ->where('published_at', '<=', now())
        ->update(['status' => Post::TYPE_ACTIVE]);

    $this->info("{$updated} post(s) have been activated.");
})->purpose('Publish scheduled posts')->everyMinute();
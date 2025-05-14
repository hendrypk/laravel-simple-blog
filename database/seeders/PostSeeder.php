<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 'active' post
        Post::create([
            'user_id' => 1,
            'title' => 'Active Post',
            'body' => 'Ini adalah postingan yang aktif',
            'status' => 'active',
            'published_at' => now(),
        ]);

        // Create 'scheduled' post (future date)
        Post::create([
            'user_id' => 1,
            'title' => 'Scheduled Post',
            'body' => 'ini adalah postingan yang dijadwalkan',
            'status' => 'scheduled',
            'published_at' => now()->addDays(7), // Set for 7 days in the future
        ]);

        // Create 'draft' post
        Post::create([
            'user_id' => 1,
            'title' => 'Draft Post',
            'body' => 'ini adalah postingan masih di draft',
            'status' => 'draft',
            'published_at' => null, // Draft posts don't have a publish date
        ]);
    }
}

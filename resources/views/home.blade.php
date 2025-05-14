<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Home') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl space-y-10 sm:px-6 lg:px-8">

            {{-- for gueset users --}}
            @guest
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <p>Please <a href="{{ route('login') }}" class="text-blue-500">login</a> or
                    <a href="{{ route('register') }}" class="text-blue-500">register</a>.</p>
                </div>
            </div>
            @endguest

            @auth
            {{-- for authenticated users --}}
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="space-y-6 p-6">
                    <h2 class="text-lg font-semibold">Your Posts</h2>
                    @foreach ($posts as $post)
                    <div class="rounded-md border p-5 shadow">
                        <div class="flex items-center gap-2">
                            <span class="flex-none rounded px-2 py-1 
                                @if($post->status == 'active')
                                    bg-green-100 text-green-800
                                @elseif($post->status == 'scheduled')
                                    bg-red-100 text-red-800
                                @elseif($post->status == 'draft')
                                    bg-yellow-100 text-yellow-800
                                @endif
                            ">
                                {{ $post->status }}
                            </span>
                            <h3><a href="#" class="text-blue-500">{{ $post->title }}</a></h3>
                        </div>
                        <div class="mt-4 flex items-end justify-between">
                            <div>
                                <div>Published: {{ $post->published_at->format('d M Y') }}</div>
                                <div>Updated: {{ $post->updated_at->format('d M Y') }}</div>
                            </div>
                            <div>
                                <a href="{{ route('posts.show', $post->id) }}" class="text-blue-500">Detail</a> /
                                <a href="{{ route('posts.edit', $post->id) }}" class="text-blue-500">Edit</a> /
                                <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button class="text-red-500">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach

                    <div>Pagination Here</div>
                </div>
            </div>
        </div>
        @endauth
    </div>
</x-app-layout>

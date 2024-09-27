<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('ランキング') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h1>ツイートランキング</h1>
                    @foreach ($tweets as $tweet)
                    <div class="mb-4 p-4 border-b border-gray-200 dark:border-gray-700">
                        <p class="text-lg font-semibold">{{ $tweet->user->name }}: {{ $tweet->tweet }}</p>
                        <p>いいね数: {{ $tweet->liked_count }}</p>

                        <div class="flex mt-2 space-x-2">
                            @if ($tweet->liked->contains(auth()->id()))
                            <form action="{{ route('tweets.dislike', $tweet) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700">
                                    いいねを解除する ({{ $tweet->liked_count }})
                                </button>
                            </form>
                            @else
                            <form action="{{ route('tweets.like', $tweet) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-blue-500 hover:text-blue-700">
                                    いいねする ({{ $tweet->liked_count }})
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<x-forum.layouts.app>
    <ul class="divide-y divide-gray-100">
        @foreach ($blogs as $blog)
        <li class="flex justify-between gap-4 py-4">
            <div class="flex gap-4">
                <div class="size-8 rounded-full flex items-center justify-center" style="background-color: {{ $blog->category->color }};">
                    <x-forum.logo />
                </div>
                <div class="flex-auto">
                    <p class="text-sm font-semibold text-white-900">
                        <a href="{{ route('blogs.show', $blog) }}" class="hover:underline">
                            {{ $blog->title }}
                        </a>
                    </p>
                    <p class="mt-1 text-xs text-gray-100">
                        {{ $blog->user->name }}
                    </p>
                </div>
            </div>

            <div class="hidden sm:flex sm:flex-col sm:items-end">
                <p class="text-sm text-white-900">
                    {{ $blog->category->name }}
                </p>
                <p class="mt-1 text-xs text-white-500">
                    {{ $blog->created_at->diffForHumans() }}
                </p>
            </div>
        </li>
        @endforeach
    </ul>
</x-forum.layouts.app>

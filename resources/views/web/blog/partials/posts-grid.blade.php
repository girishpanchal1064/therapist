@foreach($posts as $post)
    <div class="blog-card bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow duration-200">
        <!-- Featured Image -->
        <div class="relative h-48 bg-gradient-to-br from-gray-100 to-gray-200">
            @if($post->featured_image)
                <img src="{{ $post->featured_image_url }}"
                     alt="{{ $post->title }}"
                     class="w-full h-full object-cover">
            @else
                <div class="w-full h-full flex items-center justify-center">
                    <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            @endif

            <!-- Category Badge -->
            <div class="absolute top-4 left-4">
                <span class="px-3 py-1 rounded-full text-sm font-medium text-white"
                      style="background-color: {{ $post->category->color }}">
                    {{ $post->category->name }}
                </span>
            </div>

            @if($post->is_featured)
                <!-- Featured Badge -->
                <div class="absolute top-4 right-4">
                    <span class="px-3 py-1 bg-yellow-500 text-white rounded-full text-sm font-medium">
                        Featured
                    </span>
                </div>
            @endif
        </div>

        <!-- Content -->
        <div class="p-6">
            <!-- Title -->
            <h3 class="text-xl font-semibold text-gray-900 mb-3 line-clamp-2">
                <a href="{{ route('blog.show', $post->slug) }}" class="hover:text-primary-600 transition-colors">
                    {{ $post->title }}
                </a>
            </h3>

            <!-- Excerpt -->
            <p class="text-gray-600 mb-4 line-clamp-3">
                {{ $post->excerpt }}
            </p>

            <!-- Meta Information -->
            <div class="flex items-center justify-between text-sm text-gray-500">
                <div class="flex items-center">
                    @if($post->author->profile && $post->author->profile->profile_image)
                        <img src="{{ asset('storage/' . $post->author->profile->profile_image) }}"
                             alt="{{ $post->author->name }}"
                             class="w-8 h-8 rounded-full object-cover mr-2">
                    @else
                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-primary-500 to-secondary-500 flex items-center justify-center text-white text-sm font-semibold mr-2">
                            {{ substr($post->author->name, 0, 1) }}
                        </div>
                    @endif
                    <span class="font-medium">{{ $post->author->name }}</span>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ $post->reading_time }} min read
                    </span>
                    <span class="flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        {{ $post->views_count }}
                    </span>
                </div>
            </div>

            <!-- Published Date -->
            <div class="mt-3 text-sm text-gray-500">
                {{ $post->published_at->format('M d, Y') }}
            </div>
        </div>
    </div>
@endforeach

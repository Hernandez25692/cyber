@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex justify-center mt-8 text-base">
        <ul class="inline-flex items-center space-x-2 bg-white px-4 py-2 rounded-lg shadow-md">
            {{-- Botón anterior --}}
            @if ($paginator->onFirstPage())
                <li class="px-4 py-2 text-gray-400 bg-gray-100 border border-gray-200 rounded-lg cursor-not-allowed select-none transition">
                    <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                    Anterior
                </li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}"
                        class="px-4 py-2 text-blue-600 bg-white border border-blue-200 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition font-medium flex items-center">
                        <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                        </svg>
                        Anterior
                    </a>
                </li>
            @endif

            {{-- Páginas --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="px-3 py-2 text-gray-400 select-none">…</li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="px-4 py-2 font-bold text-white bg-blue-600 border border-blue-600 rounded-lg shadow-inner select-none transition">
                                {{ $page }}
                            </li>
                        @else
                            <li>
                                <a href="{{ $url }}"
                                    class="px-4 py-2 text-blue-600 bg-white border border-blue-200 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition font-medium">
                                    {{ $page }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Botón siguiente --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}"
                        class="px-4 py-2 text-blue-600 bg-white border border-blue-200 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition font-medium flex items-center">
                        Siguiente
                        <svg class="inline w-4 h-4 ml-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </li>
            @else
                <li class="px-4 py-2 text-gray-400 bg-gray-100 border border-gray-200 rounded-lg cursor-not-allowed select-none transition">
                    Siguiente
                    <svg class="inline w-4 h-4 ml-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </li>
            @endif
        </ul>
    </nav>
@endif

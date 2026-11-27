@if ($paginator->hasPages())

    <nav role="navigation" aria-label="Paginación"
        class="flex items-center justify-center gap-1">

        {{-- Anterior --}}
        @if ($paginator->onFirstPage())

            <span class="flex h-9 w-9 items-center justify-center
                         rounded-lg border border-slate-200
                         text-slate-300 cursor-not-allowed">

                <svg class="h-4 w-4" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2" d="m15 18-6-6 6-6"/>
                </svg>

            </span>

        @else

            <a href="{{ $paginator->previousPageUrl() }}"
                rel="prev"
                class="flex h-9 w-9 items-center justify-center
                       rounded-lg border border-slate-200
                       text-slate-600 transition
                       hover:border-[#40899A]/40
                       hover:bg-[#EAF4F5] hover:text-[#40899A]">

                <svg class="h-4 w-4" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2" d="m15 18-6-6 6-6"/>
                </svg>

            </a>

        @endif

        {{-- Números --}}
        @foreach ($elements as $element)

            @if (is_string($element))

                <span class="px-2 text-sm text-slate-400">
                    {{ $element }}
                </span>

            @endif

            @if (is_array($element))

                @foreach ($element as $page => $url)

                    @if ($page == $paginator->currentPage())

                        <span aria-current="page"
                            class="flex h-9 min-w-9 items-center
                                   justify-center rounded-lg
                                   bg-[#40899A] px-3 text-sm
                                   font-semibold text-white shadow-sm">
                            {{ $page }}
                        </span>

                    @else

                        <a href="{{ $url }}"
                            class="flex h-9 min-w-9 items-center
                                   justify-center rounded-lg
                                   border border-slate-200 bg-white
                                   px-3 text-sm font-medium
                                   text-slate-600 transition
                                   hover:border-[#40899A]/40
                                   hover:bg-[#EAF4F5]
                                   hover:text-[#40899A]">
                            {{ $page }}
                        </a>

                    @endif

                @endforeach

            @endif

        @endforeach

        {{-- Siguiente --}}
        @if ($paginator->hasMorePages())

            <a href="{{ $paginator->nextPageUrl() }}"
                rel="next"
                class="flex h-9 w-9 items-center justify-center
                       rounded-lg border border-slate-200
                       text-slate-600 transition
                       hover:border-[#40899A]/40
                       hover:bg-[#EAF4F5] hover:text-[#40899A]">

                <svg class="h-4 w-4" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2" d="m9 18 6-6-6-6"/>
                </svg>

            </a>

        @else

            <span class="flex h-9 w-9 items-center justify-center
                         rounded-lg border border-slate-200
                         text-slate-300 cursor-not-allowed">

                <svg class="h-4 w-4" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2" d="m9 18 6-6-6-6"/>
                </svg>

            </span>

        @endif

    </nav>

@endif

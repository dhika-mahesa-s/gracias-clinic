@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-between animate-fade-in">
        {{-- Mobile Pagination --}}
        <div class="flex justify-between flex-1 sm:hidden gap-3">
            @if ($paginator->onFirstPage())
                <span class="relative inline-flex items-center px-4 py-2.5 text-sm font-semibold text-muted-foreground bg-muted border border-border cursor-default rounded-xl shadow-sm">
                    <i class="fa-solid fa-chevron-left mr-2"></i>
                    {!! __('pagination.previous') !!}
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2.5 text-sm font-semibold text-foreground bg-card border border-border rounded-xl shadow-sm hover:bg-primary hover:text-primary-foreground hover:border-primary transition-smooth hover-scale-sm active-press">
                    <i class="fa-solid fa-chevron-left mr-2"></i>
                    {!! __('pagination.previous') !!}
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="relative inline-flex items-center px-4 py-2.5 text-sm font-semibold text-foreground bg-card border border-border rounded-xl shadow-sm hover:bg-primary hover:text-primary-foreground hover:border-primary transition-smooth hover-scale-sm active-press">
                    {!! __('pagination.next') !!}
                    <i class="fa-solid fa-chevron-right ml-2"></i>
                </a>
            @else
                <span class="relative inline-flex items-center px-4 py-2.5 text-sm font-semibold text-muted-foreground bg-muted border border-border cursor-default rounded-xl shadow-sm">
                    {!! __('pagination.next') !!}
                    <i class="fa-solid fa-chevron-right ml-2"></i>
                </span>
            @endif
        </div>

        {{-- Desktop Pagination --}}
        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-muted-foreground font-medium flex items-center gap-1.5">
                    <i class="fa-solid fa-list-ol text-primary"></i>
                    <span>
                        {!! __('Showing') !!}
                        @if ($paginator->firstItem())
                            <span class="font-bold text-foreground">{{ $paginator->firstItem() }}</span>
                            {!! __('to') !!}
                            <span class="font-bold text-foreground">{{ $paginator->lastItem() }}</span>
                        @else
                            <span class="font-bold text-foreground">{{ $paginator->count() }}</span>
                        @endif
                        {!! __('of') !!}
                        <span class="font-bold text-foreground">{{ $paginator->total() }}</span>
                        {!! __('results') !!}
                    </span>
                </p>
            </div>

            <div>
                <span class="relative z-0 inline-flex shadow-md rounded-xl overflow-hidden">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                            <span class="relative inline-flex items-center px-3 py-2.5 text-sm font-semibold text-muted-foreground bg-muted border border-border cursor-default" aria-hidden="true">
                                <i class="fa-solid fa-chevron-left"></i>
                            </span>
                        </span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}" rel="prev" 
                           class="relative inline-flex items-center px-3 py-2.5 text-sm font-semibold text-foreground bg-card border border-border hover:bg-primary hover:text-primary-foreground hover:z-10 transition-smooth active-press" 
                           aria-label="{{ __('pagination.previous') }}">
                            <i class="fa-solid fa-chevron-left"></i>
                        </a>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <span aria-disabled="true">
                                <span class="relative inline-flex items-center px-4 py-2.5 -ml-px text-sm font-bold text-muted-foreground bg-card border border-border cursor-default">{{ $element }}</span>
                            </span>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span aria-current="page">
                                        <span class="relative inline-flex items-center px-4 py-2.5 -ml-px text-sm font-bold text-primary-foreground bg-primary border border-primary cursor-default z-10 shadow-md">{{ $page }}</span>
                                    </span>
                                @else
                                    <a href="{{ $url }}" 
                                       class="relative inline-flex items-center px-4 py-2.5 -ml-px text-sm font-semibold text-foreground bg-card border border-border hover:bg-primary/10 hover:text-primary hover:border-primary/20 hover:z-10 transition-smooth active-press" 
                                       aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}" rel="next" 
                           class="relative inline-flex items-center px-3 py-2.5 -ml-px text-sm font-semibold text-foreground bg-card border border-border hover:bg-primary hover:text-primary-foreground hover:z-10 transition-smooth active-press" 
                           aria-label="{{ __('pagination.next') }}">
                            <i class="fa-solid fa-chevron-right"></i>
                        </a>
                    @else
                        <span aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                            <span class="relative inline-flex items-center px-3 py-2.5 -ml-px text-sm font-semibold text-muted-foreground bg-muted border border-border cursor-default" aria-hidden="true">
                                <i class="fa-solid fa-chevron-right"></i>
                            </span>
                        </span>
                    @endif
                </span>
            </div>
        </div>
    </nav>
@endif

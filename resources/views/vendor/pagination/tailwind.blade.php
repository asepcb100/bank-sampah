@if ($paginator->hasPages())
    <div class="flex items-center justify-between pt-4 px-6 pb-4 border-t border-[#2b2417]/10 bg-[#fbf8ef]">
        <!-- Mobile Pagination -->
        <div class="flex justify-between flex-1 sm:hidden">
            @if ($paginator->onFirstPage())
                <span class="relative inline-flex items-center px-4 py-2 text-xs font-semibold text-slate-400 bg-white/50 border border-[#2b2417]/12 rounded-xl cursor-default">
                    &laquo; Sebelumnya
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-xs font-semibold text-[#2c3821] bg-white border border-[#2b2417]/16 rounded-xl hover:bg-[#f6f1e2] transition-colors">
                    &laquo; Sebelumnya
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-xs font-semibold text-[#2c3821] bg-white border border-[#2b2417]/16 rounded-xl hover:bg-[#f6f1e2] transition-colors">
                    Berikutnya &raquo;
                </a>
            @else
                <span class="relative inline-flex items-center px-4 py-2 text-xs font-semibold text-slate-400 bg-white/50 border border-[#2b2417]/12 rounded-xl cursor-default">
                    Berikutnya &raquo;
                </span>
            @endif
        </div>

        <!-- Desktop Pagination -->
        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
                <p class="text-xs text-[#6b6150]">
                    Menampilkan
                    @if ($paginator->firstItem())
                        <span class="font-bold text-[#2c3821]">{{ $paginator->firstItem() }}</span>
                        sampai
                        <span class="font-bold text-[#2c3821]">{{ $paginator->lastItem() }}</span>
                    @else
                        {{ $paginator->count() }}
                    @endif
                    dari
                    <span class="font-bold text-[#2c3821]">{{ $paginator->total() }}</span>
                    data
                </p>
            </div>

            <div>
                <span class="relative z-0 inline-flex shadow-xs rounded-2xl overflow-hidden border border-[#2b2417]/14 divide-x divide-[#2b2417]/10">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <span aria-disabled="true" aria-label="Sebelumnya">
                            <span class="relative inline-flex items-center px-3 py-2 text-xs font-bold text-slate-400 bg-[#f6f1e2]/40 cursor-default" aria-hidden="true">
                                &laquo;
                            </span>
                        </span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="relative inline-flex items-center px-3 py-2 text-xs font-bold text-[#2c3821] bg-white hover:bg-[#f6f1e2] transition-colors" aria-label="Sebelumnya">
                            &laquo;
                        </a>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <span aria-disabled="true">
                                <span class="relative inline-flex items-center px-3 py-2 text-xs font-bold text-[#6b6150] bg-white cursor-default">{{ $element }}</span>
                            </span>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span aria-current="page">
                                        <span class="relative inline-flex items-center px-3.5 py-2 text-xs font-bold text-[#fbf8ef] bg-[#2c3821] cursor-default">{{ $page }}</span>
                                    </span>
                                @else
                                    <a href="{{ $url }}" class="relative inline-flex items-center px-3.5 py-2 text-xs font-bold text-[#2c3821] bg-white hover:bg-[#f6f1e2] transition-colors" aria-label="Ke halaman {{ $page }}">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="relative inline-flex items-center px-3 py-2 text-xs font-bold text-[#2c3821] bg-white hover:bg-[#f6f1e2] transition-colors" aria-label="Berikutnya">
                            &raquo;
                        </a>
                    @else
                        <span aria-disabled="true" aria-label="Berikutnya">
                            <span class="relative inline-flex items-center px-3 py-2 text-xs font-bold text-slate-400 bg-[#f6f1e2]/40 cursor-default" aria-hidden="true">
                                &raquo;
                            </span>
                        </span>
                    @endif
                </span>
            </div>
        </div>
    </div>
@endif

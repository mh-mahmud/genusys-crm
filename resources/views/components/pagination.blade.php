<!-- @if ($paginator->total() > 10) -->
<ul class="pagination mt-5">
    <!-- Previous Page Link -->
    @if ($paginator->onFirstPage())
        <li class="page-item previous disabled"><span class="page-link"><i class="previous"></i></span></li>
    @else
        <li class="page-item previous"><a href="{{ $paginator->previousPageUrl() }}" class="page-link"><i class="previous"></i></a></li>
    @endif

    <!-- Pagination Elements -->
    @php
    $currentPage = $paginator->currentPage(); // Current page
    $lastPage = $paginator->lastPage(); // Last page
    $startPage = max(1, $currentPage - 4); // Start page (2 pages before current page)
    $endPage = min($lastPage, $currentPage + 4); // End page (2 pages after current page)
    @endphp

    @for ($page = $startPage; $page <= $endPage; $page++)
        @if ($page == $paginator->currentPage())
            <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
        @else
            <li class="page-item"><a href="{{ $paginator->url($page) }}" class="page-link">{{ $page }}</a></li>
        @endif
    @endfor

    <!-- Next Page Link -->
    @if ($paginator->hasMorePages())
        <li class="page-item next"><a href="{{ $paginator->nextPageUrl() }}" class="page-link"><i class="next"></i></a></li>
    @else
        <li class="page-item next disabled"><span class="page-link"><i class="next"></i></span></li>
    @endif
</ul>
<!-- @endif -->

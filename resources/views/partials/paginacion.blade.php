@if ($paginator->hasPages())
    <div class="paginacion">
        <span>Página {{ $paginator->currentPage() }} de {{ $paginator->lastPage() }} · {{ $paginator->total() }} registros</span>
        <nav aria-label="Paginación">
            @if ($paginator->onFirstPage())
                <span class="pag" aria-disabled="true">Anterior</span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev">Anterior</a>
            @endif
            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="pag" aria-disabled="true">{{ $element }}</span>
                @endif
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="pag" aria-current="page">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next">Siguiente</a>
            @else
                <span class="pag" aria-disabled="true">Siguiente</span>
            @endif
        </nav>
    </div>
@endif

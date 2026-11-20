{{-- Movimiento firma: cada libro es un lomo. Alto = páginas, color = género. --}}
<div class="estante">
    <div class="lomos" role="list" aria-label="Estantería de libros">
        @foreach ($libros as $libro)
            @php
                [$fondo, $texto] = $libro->genero->tela();
                $alto = min(13.5, max(8.5, 7.5 + $libro->paginas * 0.0065));
            @endphp
            <a class="lomo" role="listitem" href="{{ route('libros.show', $libro) }}"
               style="height: {{ $alto }}rem; background-color: {{ $fondo }}; color: {{ $texto }}"
               title="{{ $libro->titulo }} · {{ $libro->genero->nombre }} · {{ $libro->paginas }} páginas"
               aria-label="{{ $libro->titulo }}, {{ $libro->genero->nombre }}, {{ $libro->paginas }} páginas">
                <span class="bandas" aria-hidden="true"></span>
                <span class="titulo" aria-hidden="true">{{ $libro->titulo }}</span>
                <span class="codigo" aria-hidden="true">{{ $libro->genero->codigo }}</span>
            </a>
        @endforeach
        <span class="sujetalibros" aria-hidden="true"></span>
    </div>
</div>

@php([$fondo, $texto] = $genero->tela())
<a class="chip-tela" href="{{ route('generos.show', $genero) }}" style="background: {{ $fondo }}; color: {{ $texto }}">{{ $genero->codigo }}</a>

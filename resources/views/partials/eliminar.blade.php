<form class="en-linea" method="POST" action="{{ $accion }}"
      onsubmit="return confirm('{{ $pregunta }}');">
    @csrf
    @method('DELETE')
    <button class="btn peligro {{ $clase ?? 'chico' }}" type="submit">
        @include('partials.icono', ['n' => 'borrar']) Eliminar
    </button>
</form>

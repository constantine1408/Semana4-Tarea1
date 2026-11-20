@if ($errors->any())
    <div class="aviso error" role="alert">
        @include('partials.icono', ['n' => 'alerta'])
        <div>
            <strong>Revisa {{ $errors->count() === 1 ? 'el campo marcado' : 'los ' . $errors->count() . ' campos marcados' }}.</strong>
            <ul>
                @foreach ($errors->all() as $mensaje)
                    <li>{{ $mensaje }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif

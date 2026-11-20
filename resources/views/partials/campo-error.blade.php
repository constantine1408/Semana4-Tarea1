@error($campo)
    <div class="error" id="{{ $campo }}-error">@include('partials.icono', ['n' => 'alerta']) {{ $message }}</div>
@enderror

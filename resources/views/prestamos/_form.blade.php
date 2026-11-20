@php($prestamo = $prestamo ?? null)

<div class="campo">
    <label for="libro_id">Libro <span class="req" aria-hidden="true">*</span></label>
    <select id="libro_id" name="libro_id" required @error('libro_id') aria-invalid="true" aria-describedby="libro_id-error" @enderror>
        <option value="">Selecciona un libro</option>
        @foreach ($libros as $libro)
            <option value="{{ $libro->id }}" @selected((string) old('libro_id', $prestamo?->libro_id ?? request('libro')) === (string) $libro->id)>{{ $libro->titulo }}</option>
        @endforeach
    </select>
    @include('partials.campo-error', ['campo' => 'libro_id'])
</div>

<div class="campo">
    <label for="socio_id">Socio <span class="req" aria-hidden="true">*</span></label>
    <select id="socio_id" name="socio_id" required @error('socio_id') aria-invalid="true" aria-describedby="socio_id-error" @enderror>
        <option value="">Selecciona un socio</option>
        @foreach ($socios as $socio)
            <option value="{{ $socio->id }}" @selected((string) old('socio_id', $prestamo?->socio_id ?? request('socio')) === (string) $socio->id)>{{ $socio->nombres }} · {{ $socio->cedula }}</option>
        @endforeach
    </select>
    @include('partials.campo-error', ['campo' => 'socio_id'])
</div>

<div class="dos-col">
    <div class="campo">
        <label for="fecha_prestamo">Fecha de préstamo <span class="req" aria-hidden="true">*</span></label>
        <input id="fecha_prestamo" name="fecha_prestamo" type="date" required
               value="{{ old('fecha_prestamo', $prestamo?->fecha_prestamo?->format('Y-m-d') ?? date('Y-m-d')) }}" @error('fecha_prestamo') aria-invalid="true" aria-describedby="fecha_prestamo-error" @enderror>
        @include('partials.campo-error', ['campo' => 'fecha_prestamo'])
    </div>
    <div class="campo">
        <label for="fecha_limite">Fecha límite <span class="req" aria-hidden="true">*</span></label>
        <input id="fecha_limite" name="fecha_limite" type="date" required
               aria-describedby="fecha_limite-ayuda @error('fecha_limite') fecha_limite-error @enderror"
               value="{{ old('fecha_limite', $prestamo?->fecha_limite?->format('Y-m-d') ?? now()->addDays(15)->format('Y-m-d')) }}" @error('fecha_limite') aria-invalid="true" @enderror>
        <p class="ayuda" id="fecha_limite-ayuda">Por defecto, 15 días después de hoy.</p>
        @include('partials.campo-error', ['campo' => 'fecha_limite'])
    </div>
</div>

<fieldset class="grupo-radio">
    <legend>Estado <span class="req" aria-hidden="true">*</span></legend>
    <div class="opciones">
        @foreach (\App\Models\Prestamo::ESTADOS as $estado)
            <label class="casilla">
                <input type="radio" name="estado" value="{{ $estado }}" required
                    @checked(old('estado', $prestamo?->estado ?? 'prestado') === $estado)>
                {{ ucfirst($estado) }}
            </label>
        @endforeach
    </div>
    @include('partials.campo-error', ['campo' => 'estado'])
</fieldset>

@php($autor = $autor ?? null)

<div class="campo">
    <label for="nombres">Nombres completos <span class="req" aria-hidden="true">*</span></label>
    <input id="nombres" name="nombres" type="text" maxlength="120" required autocomplete="off"
           value="{{ old('nombres', $autor?->nombres) }}" @error('nombres') aria-invalid="true" aria-describedby="nombres-error" @enderror>
    @include('partials.campo-error', ['campo' => 'nombres'])
</div>

<div class="dos-col">
    <div class="campo">
        <label for="nacionalidad">Nacionalidad <span class="req" aria-hidden="true">*</span></label>
        <input id="nacionalidad" name="nacionalidad" type="text" maxlength="60" required placeholder="Ecuatoriana"
               value="{{ old('nacionalidad', $autor?->nacionalidad) }}" @error('nacionalidad') aria-invalid="true" aria-describedby="nacionalidad-error" @enderror>
        @include('partials.campo-error', ['campo' => 'nacionalidad'])
    </div>
    <div class="campo">
        <label for="fecha_nacimiento">Fecha de nacimiento</label>
        <input id="fecha_nacimiento" name="fecha_nacimiento" type="date" max="{{ now()->subDay()->format('Y-m-d') }}"
               value="{{ old('fecha_nacimiento', $autor?->fecha_nacimiento?->format('Y-m-d')) }}" @error('fecha_nacimiento') aria-invalid="true" aria-describedby="fecha_nacimiento-error" @enderror>
        @include('partials.campo-error', ['campo' => 'fecha_nacimiento'])
    </div>
</div>

<div class="campo">
    <label for="correo">Correo electrónico</label>
    <input id="correo" name="correo" type="email" maxlength="160" placeholder="autor@correo.com"
           aria-describedby="correo-ayuda @error('correo') correo-error @enderror"
           value="{{ old('correo', $autor?->correo) }}" @error('correo') aria-invalid="true" @enderror>
    <p class="ayuda" id="correo-ayuda">Opcional. No puede repetirse entre autores.</p>
    @include('partials.campo-error', ['campo' => 'correo'])
</div>

<div class="campo">
    <input type="hidden" name="activo" value="0">
    <label class="casilla" for="activo">
        <input id="activo" name="activo" type="checkbox" value="1" {{ old('activo', $autor?->activo ?? true) ? 'checked' : '' }}>
        Autor activo
    </label>
</div>

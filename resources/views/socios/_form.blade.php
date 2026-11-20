@php($socio = $socio ?? null)

<div class="campo">
    <label for="nombres">Nombres completos <span class="req" aria-hidden="true">*</span></label>
    <input id="nombres" name="nombres" type="text" maxlength="120" required autocomplete="off"
           value="{{ old('nombres', $socio?->nombres) }}" @error('nombres') aria-invalid="true" aria-describedby="nombres-error" @enderror>
    @include('partials.campo-error', ['campo' => 'nombres'])
</div>

<div class="dos-col">
    <div class="campo">
        <label for="cedula">Cédula <span class="req" aria-hidden="true">*</span></label>
        <input id="cedula" name="cedula" type="text" inputmode="numeric" minlength="10" maxlength="10" required placeholder="1801234567"
               aria-describedby="cedula-ayuda @error('cedula') cedula-error @enderror"
               value="{{ old('cedula', $socio?->cedula) }}" @error('cedula') aria-invalid="true" @enderror>
        <p class="ayuda" id="cedula-ayuda">10 dígitos.</p>
        @include('partials.campo-error', ['campo' => 'cedula'])
    </div>
    <div class="campo">
        <label for="telefono">Teléfono <span class="req" aria-hidden="true">*</span></label>
        <input id="telefono" name="telefono" type="tel" inputmode="numeric" maxlength="15" required placeholder="0991234567"
               value="{{ old('telefono', $socio?->telefono) }}" @error('telefono') aria-invalid="true" aria-describedby="telefono-error" @enderror>
        @include('partials.campo-error', ['campo' => 'telefono'])
    </div>
</div>

<div class="dos-col">
    <div class="campo">
        <label for="correo">Correo electrónico <span class="req" aria-hidden="true">*</span></label>
        <input id="correo" name="correo" type="email" maxlength="160" required placeholder="socio@correo.com"
               value="{{ old('correo', $socio?->correo) }}" @error('correo') aria-invalid="true" aria-describedby="correo-error" @enderror>
        @include('partials.campo-error', ['campo' => 'correo'])
    </div>
    <div class="campo">
        <label for="fecha_afiliacion">Fecha de afiliación <span class="req" aria-hidden="true">*</span></label>
        <input id="fecha_afiliacion" name="fecha_afiliacion" type="date" required
               value="{{ old('fecha_afiliacion', $socio?->fecha_afiliacion?->format('Y-m-d') ?? date('Y-m-d')) }}" @error('fecha_afiliacion') aria-invalid="true" aria-describedby="fecha_afiliacion-error" @enderror>
        @include('partials.campo-error', ['campo' => 'fecha_afiliacion'])
    </div>
</div>

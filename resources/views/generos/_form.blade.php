@php($genero = $genero ?? null)

<div class="dos-col">
    <div class="campo">
        <label for="nombre">Nombre <span class="req" aria-hidden="true">*</span></label>
        <input id="nombre" name="nombre" type="text" maxlength="80" required placeholder="Novela"
               value="{{ old('nombre', $genero?->nombre) }}" @error('nombre') aria-invalid="true" aria-describedby="nombre-error" @enderror>
        @include('partials.campo-error', ['campo' => 'nombre'])
    </div>
    <div class="campo">
        <label for="codigo">Código <span class="req" aria-hidden="true">*</span></label>
        <input id="codigo" name="codigo" type="text" minlength="3" maxlength="3" required placeholder="NOV"
               style="text-transform: uppercase" aria-describedby="codigo-ayuda @error('codigo') codigo-error @enderror"
               value="{{ old('codigo', $genero?->codigo) }}" @error('codigo') aria-invalid="true" @enderror>
        <p class="ayuda" id="codigo-ayuda">Tres letras; se imprime en el lomo de cada libro.</p>
        @include('partials.campo-error', ['campo' => 'codigo'])
    </div>
</div>

<div class="campo">
    <label for="descripcion">Descripción</label>
    <textarea id="descripcion" name="descripcion" rows="3" maxlength="255" @error('descripcion') aria-invalid="true" aria-describedby="descripcion-error" @enderror>{{ old('descripcion', $genero?->descripcion) }}</textarea>
    @include('partials.campo-error', ['campo' => 'descripcion'])
</div>

<div class="dos-col">
    <div class="campo">
        <label for="edad_minima">Edad mínima recomendada <span class="req" aria-hidden="true">*</span></label>
        <input id="edad_minima" name="edad_minima" type="number" min="0" max="18" required
               aria-describedby="edad-ayuda @error('edad_minima') edad_minima-error @enderror"
               value="{{ old('edad_minima', $genero?->edad_minima ?? 0) }}" @error('edad_minima') aria-invalid="true" @enderror>
        <p class="ayuda" id="edad-ayuda">De 0 a 18 años.</p>
        @include('partials.campo-error', ['campo' => 'edad_minima'])
    </div>
</div>

<div class="campo">
    <input type="hidden" name="activo" value="0">
    <label class="casilla" for="activo">
        <input id="activo" name="activo" type="checkbox" value="1" {{ old('activo', $genero?->activo ?? true) ? 'checked' : '' }}>
        Género activo
    </label>
</div>

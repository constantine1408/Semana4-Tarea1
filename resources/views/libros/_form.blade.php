@php($libro = $libro ?? null)

<div class="campo">
    <label for="titulo">Título <span class="req" aria-hidden="true">*</span></label>
    <input id="titulo" name="titulo" type="text" maxlength="200" required
           value="{{ old('titulo', $libro?->titulo) }}" @error('titulo') aria-invalid="true" aria-describedby="titulo-error" @enderror>
    @include('partials.campo-error', ['campo' => 'titulo'])
</div>

<div class="dos-col">
    <div class="campo">
        <label for="isbn">ISBN <span class="req" aria-hidden="true">*</span></label>
        <input id="isbn" name="isbn" type="text" inputmode="numeric" minlength="13" maxlength="13" required placeholder="9789978670014"
               aria-describedby="isbn-ayuda @error('isbn') isbn-error @enderror"
               value="{{ old('isbn', $libro?->isbn) }}" @error('isbn') aria-invalid="true" @enderror>
        <p class="ayuda" id="isbn-ayuda">13 dígitos, sin guiones.</p>
        @include('partials.campo-error', ['campo' => 'isbn'])
    </div>
    <div class="campo">
        <label for="paginas">Páginas <span class="req" aria-hidden="true">*</span></label>
        <input id="paginas" name="paginas" type="number" min="1" max="5000" required
               value="{{ old('paginas', $libro?->paginas) }}" @error('paginas') aria-invalid="true" aria-describedby="paginas-error" @enderror>
        @include('partials.campo-error', ['campo' => 'paginas'])
    </div>
</div>

<div class="dos-col">
    <div class="campo">
        <label for="autor_id">Autor <span class="req" aria-hidden="true">*</span></label>
        <select id="autor_id" name="autor_id" required @error('autor_id') aria-invalid="true" aria-describedby="autor_id-error" @enderror>
            <option value="">Selecciona un autor</option>
            @foreach ($autores as $autor)
                <option value="{{ $autor->id }}" @selected((string) old('autor_id', $libro?->autor_id) === (string) $autor->id)>{{ $autor->nombres }}</option>
            @endforeach
        </select>
        @if ($autores->isEmpty())
            <p class="ayuda">No hay autores. <a href="{{ route('autores.create') }}">Registra uno primero</a>.</p>
        @endif
        @include('partials.campo-error', ['campo' => 'autor_id'])
    </div>
    <div class="campo">
        <label for="genero_id">Género <span class="req" aria-hidden="true">*</span></label>
        <select id="genero_id" name="genero_id" required @error('genero_id') aria-invalid="true" aria-describedby="genero_id-error" @enderror>
            <option value="">Selecciona un género</option>
            @foreach ($generos as $genero)
                <option value="{{ $genero->id }}" @selected((string) old('genero_id', $libro?->genero_id) === (string) $genero->id)>{{ $genero->codigo }} · {{ $genero->nombre }}</option>
            @endforeach
        </select>
        @if ($generos->isEmpty())
            <p class="ayuda">No hay géneros. <a href="{{ route('generos.create') }}">Registra uno primero</a>.</p>
        @endif
        @include('partials.campo-error', ['campo' => 'genero_id'])
    </div>
</div>

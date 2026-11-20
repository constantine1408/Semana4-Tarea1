@php($s = $prestamo->situacion())
<span class="estado {{ $s['clave'] }}">{{ $s['etiqueta'] }}</span>

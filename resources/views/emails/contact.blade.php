<x-mail::message>
# Tienes un nuevo mensaje en Boxes

Alguien ha usado el formulario de contacto de Kartbooking. Aquí tienes los datos de telemetría:

**Piloto:** {{ $datos['name'] }}  
**Email:** {{ $datos['email'] }}

**Mensaje:** <x-mail::panel>
{{ $datos['message'] }}
</x-mail::panel>


El Sistema Automático de {{ config('app.name') }}
</x-mail::message>
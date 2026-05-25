<x-mail::message>
# ¡Semáforo en verde, {{ $user->name }}! 

Tu cuenta de piloto en **Kartbooking** ha sido creada con éxito. Ya formas parte de la comunidad de karting más grande.

A partir de ahora podrás:
- Localizar los mejores circuitos en tu zona.
- Ver las coordenadas exactas y trazar tu ruta.
- (Próximamente) Registrar tus mejores tiempos en cada circuito.

<x-mail::button :url="url('/buscar-kartings')">
Buscar Circuitos Ahora
</x-mail::button>

Nos vemos en la pista,<br>
**El equipo de {{ config('app.name') }}**
</x-mail::message>
<x-mail::message>
# Estado de tu Trámite Actualizado

Hola **{{ $tramite->user->name }}**,

Te informamos que tu expediente ha tenido un cambio de estado.

<x-mail::panel>
**Expediente:** {{ $tramite->numero_expediente }}
**Procedimiento:** {{ $tramite->procedimientoTupa->nombre }}
**Estado anterior:** {{ $estadoAnterior }}
**Nuevo estado:** {{ $tramite->estado }}
</x-mail::panel>

@if($tramite->estado === 'Aprobado')
🎉 **¡Felicitaciones!** Tu trámite ha sido aprobado. Puedes acercarte a nuestras oficinas para retirar tu resolución o continuar con el proceso indicado.

@elseif($tramite->estado === 'Rechazado')
❌ Lamentablemente tu trámite ha sido **rechazado**. Por favor revisa los comentarios en el detalle de tu expediente para conocer el motivo y presentar una nueva solicitud si corresponde.

@elseif($tramite->estado === 'En Revisión')
🔍 Tu trámite está siendo **revisado** por nuestro equipo. Te notificaremos cuando haya una resolución.

@elseif($tramite->estado === 'Finalizado')
📦 Tu expediente ha sido **finalizado** y archivado. Gracias por utilizar nuestros servicios.

@else
El estado de tu expediente ha sido actualizado a **{{ $tramite->estado }}**.
@endif

Puedes ver el detalle completo y hacer seguimiento en tiempo real haciendo clic en el botón:

<x-mail::button :url="$urlSeguimiento" color="primary">
Ver mi trámite
</x-mail::button>

Si tienes alguna consulta, no dudes en acercarte a nuestras ventanillas de atención o responder a este correo.

Atentamente,  
**Mesa de Partes — AHPRA**

---
<small>Este es un mensaje automático. Por favor no responda directamente a este correo si su cliente de email no lo permite.</small>
</x-mail::message>

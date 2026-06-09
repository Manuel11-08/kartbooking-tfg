<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kartbooking - Restablecer Contraseña</title>
</head>
<body style="margin:0;padding:0;background-color:#09090b;font-family:Arial,sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#09090b;padding:40px 0;">
        <tr>
            <td align="center">
                <table width="560" cellpadding="0" cellspacing="0" style="background-color:#18181b;border:1px solid #27272a;border-radius:12px;overflow:hidden;">

                    <tr>
                        <td style="background-color:#e8001e;padding:28px 40px;text-align:center;">
                            <span style="font-size:24px;font-weight:900;color:#ffffff;letter-spacing:6px;text-transform:uppercase;font-style:italic;">
                                KARTBOOKING
                            </span>
                        </td>
                    </tr>

                    <tr>
                        <td style="height:4px;background-color:#e8001e;"></td>
                    </tr>

                    <tr>
                        <td style="padding:40px;">

                            <p style="margin:0 0 8px 0;font-size:11px;color:#71717a;text-transform:uppercase;letter-spacing:3px;font-weight:700;">
                                Recuperación de acceso
                            </p>

                            <h1 style="margin:0 0 24px 0;font-size:26px;font-weight:900;color:#ffffff;text-transform:uppercase;letter-spacing:1px;">
                                Restablece tu contraseña
                            </h1>

                            <p style="margin:0 0 24px 0;font-size:14px;color:#a1a1aa;line-height:1.7;">
                                Hemos recibido una solicitud para restablecer la contraseña de tu cuenta en Kartbooking. Si no has sido tú, puedes ignorar este mensaje.
                            </p>

                            <p style="margin:0 0 32px 0;font-size:14px;color:#a1a1aa;line-height:1.7;">
                                Pulsa el botón para crear una nueva contraseña. El enlace es válido durante <strong style="color:#ffffff;">60 minutos</strong>.
                            </p>

                            <table cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td align="center">
                                        <a href="{{ $url }}" style="display:inline-block;background-color:#e8001e;color:#ffffff;font-size:13px;font-weight:900;text-transform:uppercase;letter-spacing:3px;padding:16px 40px;border-radius:6px;text-decoration:none;">
                                            Restablecer Contraseña
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin:32px 0 0 0;font-size:12px;color:#52525b;line-height:1.6;">
                                Si el botón no funciona, copia y pega este enlace en tu navegador:
                            </p>
                            <p style="margin:8px 0 0 0;font-size:11px;color:#71717a;word-break:break-all;">
                                {{ $url }}
                            </p>

                        </td>
                    </tr>

                    <tr>
                        <td style="padding:24px 40px;border-top:1px solid #27272a;text-align:center;">
                            <p style="margin:0;font-size:11px;color:#52525b;text-transform:uppercase;letter-spacing:2px;">
                                Kartbooking &mdash; IES Mar de Cádiz &mdash; 2025/2026
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

</body>
</html>
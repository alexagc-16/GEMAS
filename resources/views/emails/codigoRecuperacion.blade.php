<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recuperación de contraseña</title>
</head>
<body style="margin: 0; padding: 30px; background-color: #EEF6F8; font-family: Arial, sans-serif; color: #334155;">

    <div style="max-width: 520px; margin: auto; padding: 30px; background-color: #ffffff; border-radius: 12px; border: 1px solid #E2E8F0;">

        <div style="text-align: center; margin-bottom: 25px;">
            <img
                src="{{ rtrim(config('app.url'), '/') }}/img/logo.png"
                alt="GEMAS"
                width="150"
                style="display: block; width: 150px; max-width: 100%; height: auto; margin: auto;"
            >
        </div>

        <h3 style="text-align: center;">
            Recuperación de contraseña
        </h3>

        <p>
            Hemos recibido una solicitud para restablecer tu contraseña.
        </p>

        <p>
            Utiliza el siguiente código para verificar tu identidad:
        </p>

        <div style="margin: 25px 0; padding: 18px; background-color: #EAF4F5; border-radius: 8px; text-align: center;">
            <span style="font-size: 32px; font-weight: bold; letter-spacing: 8px; color: #397184;">
                {{ $codigo }}
            </span>
        </div>

        <p>
            Este código tiene una vigencia de <strong>10 minutos</strong>
            y solo puede utilizarse una vez.
        </p>

        <p>
            Si no solicitaste este cambio, puedes ignorar este mensaje.
        </p>

        <p style="margin-top: 30px; font-size: 13px; color: #64748B; text-align: center;">
            Este es un mensaje automático de GEMAS. Por favor, no respondas a este correo.
        </p>

    </div>

</body>
</html>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Establecer contraseña - GEMAS</title>
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

        <h3 style="text-align: center; color: #334155;">
            Establecer contraseña
        </h3>

        <p>
            ¡Hola!
        </p>

        <p>
            Se ha creado una cuenta de veterinario para ti en GEMAS.
        </p>

        <p>
            Para comenzar a utilizar tu cuenta, debes establecer tu contraseña.
        </p>

        <div style="margin: 25px 0; text-align: center;">
            <a
                href="{{ $url }}"
                style="display: inline-block; padding: 13px 25px; background-color: #4A90A4; color: #ffffff; text-decoration: none; font-weight: bold; border-radius: 8px;"
            >
                Establecer contraseña
            </a>
        </div>

        <p>
            Este enlace tiene una vigencia de <strong>60 minutos</strong>
            y solo puede utilizarse para establecer tu contraseña.
        </p>

        <p>
            Si no solicitaste la creación de esta cuenta, puedes ignorar este mensaje.
        </p>

        <p style="margin-top: 30px; font-size: 13px; color: #64748B; text-align: center;">
            Este es un mensaje automático de GEMAS. Por favor, no respondas a este correo.
        </p>

    </div>

</body>
</html>


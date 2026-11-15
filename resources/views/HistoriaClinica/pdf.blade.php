<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">

    <title>Expediente médico - GEMAS</title>

    <style>
        @page {
            margin: 35px 38px 45px 38px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 9px;
            line-height: 1.55;
            color: #334155;
            margin: 0;
            background: #ffffff;
        }

        /* PALETA GEMAS */
        :root {
            --principal: #40899A;
            --oscuro: #245765;
            --claro: #EAF4F5;
            --texto: #334155;
            --secundario: #64748b;
            --borde: #dce7e9;
            --fondo: #f7fafb;
        }

        /* ENCABEZADO */
        .header {
            width: 100%;
            border-bottom: 3px solid #40899A;
            padding-bottom: 13px;
            margin-bottom: 20px;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
        }

        .header-table td {
            vertical-align: middle;
        }

        .logo-container {
            width: 100px;
        }

        .logo {
            width: 85px;
            max-height: 65px;
            object-fit: contain;
        }

        .header-info {
            text-align: right;
        }

        .header-title {
            color: #245765;
            font-size: 17px;
            font-weight: bold;
            margin: 0;
        }

        .header-subtitle {
            color: #64748b;
            font-size: 8px;
            margin-top: 4px;
        }

        .header-tag {
            display: inline-block;
            margin-top: 7px;
            padding: 4px 9px;
            background: #EAF4F5;
            color: #347787;
            font-size: 7px;
            font-weight: bold;
            letter-spacing: 0.7px;
            border-radius: 10px;
        }

        /* TITULO DEL DOCUMENTO */
        .document-title {
            margin-bottom: 17px;
        }

        .document-title h1 {
            font-size: 16px;
            color: #245765;
            margin: 0;
        }

        .document-title p {
            color: #64748b;
            font-size: 8px;
            margin: 4px 0 0;
        }

        /* INFORMACION DEL EXPEDIENTE */
        .resumen {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .resumen td {
            padding: 10px 12px;
            border: 1px solid #dce7e9;
            vertical-align: middle;
        }

        .resumen-label {
            color: #64748b;
            font-size: 7px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .resumen-value {
            color: #245765;
            font-size: 10px;
            font-weight: bold;
            margin-top: 3px;
        }

        .estado {
            display: inline-block;
            padding: 4px 9px;
            border-radius: 10px;
            font-size: 7px;
            font-weight: bold;
        }

        .estado-completa {
            background: #dcfce7;
            color: #166534;
        }

        .estado-pendiente {
            background: #fef3c7;
            color: #92400e;
        }

        /* SECCIONES */
        .section {
            margin-top: 19px;
            margin-bottom: 15px;
        }

        .section-header {
            border-bottom: 1px solid #dce7e9;
            padding-bottom: 7px;
            margin-bottom: 11px;
        }

        .section-title {
            color: #245765;
            font-size: 11px;
            font-weight: bold;
            margin: 0;
        }

        .section-description {
            color: #94a3b8;
            font-size: 7px;
            margin-top: 3px;
        }

        .section-number {
            display: inline-block;
            width: 19px;
            height: 19px;
            line-height: 19px;
            text-align: center;
            border-radius: 5px;
            background: #EAF4F5;
            color: #40899A;
            font-weight: bold;
            margin-right: 6px;
        }

        /* TABLA DE DATOS */
        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table td {
            width: 50%;
            padding: 8px 10px;
            border: 1px solid #e2e8f0;
            vertical-align: top;
        }

        .data-label {
            display: block;
            color: #64748b;
            font-size: 7px;
            margin-bottom: 3px;
        }

        .data-value {
            color: #334155;
            font-size: 9px;
            font-weight: bold;
        }

        /* BLOQUES MEDICOS */
        .medical-block {
            border: 1px solid #e2e8f0;
            border-radius: 5px;
            padding: 10px 12px;
            margin-bottom: 9px;
            background: #ffffff;
            page-break-inside: avoid;
        }

        .medical-label {
            color: #40899A;
            font-size: 8px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .medical-content {
            color: #475569;
            font-size: 8px;
            white-space: pre-wrap;
            word-wrap: break-word;
        }

        .empty {
            color: #94a3b8;
            font-style: italic;
        }

        /* EVOLUCIONES */
        .evolution-card {
            border: 1px solid #dce7e9;
            border-radius: 6px;
            margin-bottom: 15px;
            page-break-inside: auto;
        }

        .evolution-header {
            background: #EAF4F5;
            padding: 9px 11px;
            border-bottom: 1px solid #dce7e9;
        }

        .evolution-header-table {
            width: 100%;
            border-collapse: collapse;
        }

        .evolution-header-table td {
            vertical-align: middle;
        }

        .evolution-title {
            color: #245765;
            font-size: 9px;
            font-weight: bold;
        }

        .evolution-date {
            color: #40899A;
            font-size: 8px;
            text-align: right;
        }

        .evolution-body {
            padding: 11px;
        }

        .metrics {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }

        .metrics td {
            width: 50%;
            padding: 8px;
            background: #f7fafb;
            border: 1px solid #e2e8f0;
        }

        .metric-label {
            color: #64748b;
            font-size: 7px;
        }

        .metric-value {
            color: #245765;
            font-size: 10px;
            font-weight: bold;
            margin-top: 3px;
        }

        .veterinarian {
            background: #f7fafb;
            border-left: 3px solid #40899A;
            padding: 7px 9px;
            margin-bottom: 11px;
        }

        .veterinarian-label {
            color: #64748b;
            font-size: 7px;
        }

        .veterinarian-name {
            color: #334155;
            font-weight: bold;
            font-size: 8px;
            margin-top: 2px;
        }

        /* DIAGNOSTICOS Y TRATAMIENTOS */
        .diagnosis-title {
            color: #245765;
            font-size: 9px;
            font-weight: bold;
            margin-top: 13px;
            margin-bottom: 7px;
            padding-bottom: 5px;
            border-bottom: 1px solid #e2e8f0;
        }

        .diagnosis-card {
            background: #f7fafb;
            border-left: 3px solid #40899A;
            padding: 9px 10px;
            margin-bottom: 9px;
            page-break-inside: avoid;
        }

        .diagnosis-name {
            color: #245765;
            font-weight: bold;
            font-size: 9px;
            margin-bottom: 6px;
        }

        .diagnosis-detail {
            margin-top: 6px;
            color: #475569;
            font-size: 8px;
            white-space: pre-wrap;
            word-wrap: break-word;
        }

        .diagnosis-detail strong {
            color: #64748b;
            font-size: 7px;
            display: block;
            margin-bottom: 2px;
        }

        .detail-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 7px;
        }

        .detail-table td {
            width: 50%;
            padding: 5px 7px;
            border: 1px solid #e2e8f0;
            vertical-align: top;
        }

        /* MENSAJES SIN REGISTROS */
        .empty-box {
            padding: 12px;
            text-align: center;
            background: #f7fafb;
            border: 1px dashed #cbd5e1;
            color: #94a3b8;
            font-size: 8px;
            border-radius: 5px;
        }

        /* PIE */
        .footer {
            border-top: 1px solid #dce7e9;
            margin-top: 22px;
            padding-top: 9px;
            text-align: center;
            color: #94a3b8;
            font-size: 7px;
        }

        .footer-brand {
            color: #40899A;
            font-weight: bold;
        }
    </style>
</head>

<body>

    @php
        $mascota = $historiaClinica->Mascota;
        $fechaGeneracion = now()->format('d/m/Y H:i');
    @endphp

    {{-- ENCABEZADO INSTITUCIONAL --}}
    <div class="header">

        <table class="header-table">
            <tr>

                <td class="logo-container">
                    <img src="{{ public_path('img/logo.png') }}"
                        alt="Logo GEMAS"
                        style="width: 112px; height: 112px; object-fit: contain;">
                </td>

                <td class="header-info">

                    <h1 class="header-title">
                        Expediente médico veterinario
                    </h1>

                    <p class="header-subtitle">
                        Gestión Médica y Atención de Mascotas
                    </p>

                    <span class="header-tag">
                        DOCUMENTO CLÍNICO
                    </span>

                </td>

            </tr>
        </table>

    </div>

    {{-- TITULO --}}
    <div class="document-title">

        <h1>
            Historia clínica
        </h1>

        <p>
            Registro de información médica, antecedentes y seguimiento clínico.
        </p>

    </div>

    {{-- RESUMEN --}}
    <table class="resumen">

        <tr>

            <td>
                <div class="resumen-label">
                    Paciente
                </div>

                <div class="resumen-value">
                    {{ $mascota?->nombre ?? 'No disponible' }}
                </div>
            </td>

            <td>
                <div class="resumen-label">
                    Número de expediente
                </div>

                <div class="resumen-value">
                    HC-{{ str_pad($historiaClinica->id, 5, '0', STR_PAD_LEFT) }}
                </div>
            </td>

        </tr>

        <tr>

            <td>
                <div class="resumen-label">
                    Fecha de apertura
                </div>

                <div class="resumen-value">
                    {{ $historiaClinica->fechaApertura
                        ? \Carbon\Carbon::parse($historiaClinica->fechaApertura)->format('d/m/Y')
                        : 'No registrada' }}
                </div>
            </td>

            <td>
                <div class="resumen-label">
                    Estado del expediente
                </div>

                <div style="margin-top: 5px;">

                    @if($historiaClinica->completadaEn)
                        <span class="estado estado-completa">
                            COMPLETO
                        </span>
                    @else
                        <span class="estado estado-pendiente">
                            PENDIENTE
                        </span>
                    @endif

                </div>
            </td>

        </tr>

    </table>

    {{-- 01. IDENTIFICACION --}}
    <div class="section">

        <div class="section-header">

            <h2 class="section-title">
                <span class="section-number">01</span>
                Identificación del paciente
            </h2>

            <p class="section-description">
                Datos generales de la mascota registrada en GEMAS.
            </p>

        </div>

        <table class="data-table">

            <tr>
                <td>
                    <span class="data-label">Nombre</span>
                    <span class="data-value">
                        {{ $mascota?->nombre ?? 'No registrado' }}
                    </span>
                </td>

                <td>
                    <span class="data-label">Especie</span>
                    <span class="data-value">
                        {{ $mascota?->especie ?? 'No registrada' }}
                    </span>
                </td>
            </tr>

            <tr>
                <td>
                    <span class="data-label">Raza</span>
                    <span class="data-value">
                        {{ $mascota?->raza ?? 'No registrada' }}
                    </span>
                </td>

                <td>
                    <span class="data-label">Sexo</span>
                    <span class="data-value">
                        {{ $mascota?->sexo ?? 'No registrado' }}
                    </span>
                </td>
            </tr>

            <tr>
                <td>
                    <span class="data-label">Fecha de nacimiento</span>
                    <span class="data-value">
                        {{ $mascota?->fechaNacimiento
                            ? \Carbon\Carbon::parse($mascota->fechaNacimiento)->format('d/m/Y')
                            : 'No registrada' }}
                    </span>
                </td>

                <td>
                    <span class="data-label">Color</span>
                    <span class="data-value">
                        {{ $mascota?->color ?? 'No registrado' }}
                    </span>
                </td>
            </tr>

            <tr>
                <td>
                    <span class="data-label">Peso registrado en la mascota</span>
                    <span class="data-value">
                        {{ $mascota?->peso !== null
                            ? $mascota->peso . ' kg'
                            : 'No registrado' }}
                    </span>
                </td>

                
                <td>
                    <span class="data-label">Cuidador</span>
                    <span class="data-value">
                        {{ $historiaClinica->Mascota->Usuario->nombre ?? 'No registrado' }}
                    </span>
                </td>
            </tr>

        </table>

    </div>

    {{-- 02. ANTECEDENTES --}}
    <div class="section">

        <div class="section-header">

            <h2 class="section-title">
                <span class="section-number">02</span>
                Antecedentes médicos
            </h2>

            <p class="section-description">
                Información clínica previa y observaciones generales.
            </p>

        </div>

        <div class="medical-block">

            <div class="medical-label">
                Antecedentes
            </div>

            <div class="medical-content">
                {{ $historiaClinica->antecedentes ?: 'Sin información registrada.' }}
            </div>

        </div>

        <div class="medical-block">

            <div class="medical-label">
                Alergias
            </div>

            <div class="medical-content">
                {{ $historiaClinica->alergias ?: 'Sin información registrada.' }}
            </div>

        </div>

        <div class="medical-block">

            <div class="medical-label">
                Enfermedades previas
            </div>

            <div class="medical-content">
                {{ $historiaClinica->enfermedadesPrevias ?: 'Sin información registrada.' }}
            </div>

        </div>

        <div class="medical-block">

            <div class="medical-label">
                Observaciones generales
            </div>

            <div class="medical-content">
                {{ $historiaClinica->observaciones ?: 'Sin información registrada.' }}
            </div>

        </div>

    </div>

    {{-- 03. EVOLUCIONES --}}
    <div class="section">

        <div class="section-header">

            <h2 class="section-title">
                <span class="section-number">03</span>
                Seguimiento y evoluciones clínicas
            </h2>

            <p class="section-description">
                Registro cronológico de las consultas y valoraciones médicas.
            </p>

        </div>

        @forelse($historiaClinica->Evolucion as $indice => $evolucion)

            <div class="evolution-card">

                {{-- Encabezado de evolución --}}
                <div class="evolution-header">

                    <table class="evolution-header-table">
                        <tr>

                            <td>
                                <span class="evolution-title">
                                    Evolución clínica {{ $indice + 1 }}
                                </span>
                            </td>

                            <td class="evolution-date">
                                {{ $evolucion->fecha
                                    ? \Carbon\Carbon::parse($evolucion->fecha)->format('d/m/Y H:i')
                                    : 'Fecha no registrada' }}
                            </td>

                        </tr>
                    </table>

                </div>

                <div class="evolution-body">

                    {{-- Indicadores --}}
                    <table class="metrics">

                        <tr>

                            <td>
                                <div class="metric-label">
                                    Peso
                                </div>

                                <div class="metric-value">
                                    {{ $evolucion->peso !== null
                                        ? $evolucion->peso . ' kg'
                                        : 'Sin registro' }}
                                </div>
                            </td>

                            <td>
                                <div class="metric-label">
                                    Temperatura
                                </div>

                                <div class="metric-value">
                                    {{ $evolucion->temperatura !== null
                                        ? $evolucion->temperatura . ' °C'
                                        : 'Sin registro' }}
                                </div>
                            </td>

                        </tr>

                    </table>

                    {{-- Veterinario --}}
                    <div class="veterinarian">

                        <div class="veterinarian-label">
                            Profesional responsable
                        </div>

                        <div class="veterinarian-name">
                            {{ $evolucion->Veterinario?->nombre ?? 'No registrado' }}
                        </div>

                    </div>

                    {{-- Síntomas --}}
                    <div class="medical-block">

                        <div class="medical-label">
                            Síntomas
                        </div>

                        <div class="medical-content">
                            {{ $evolucion->sintomas ?: 'Sin información registrada.' }}
                        </div>

                    </div>

                    {{-- Observaciones --}}
                    <div class="medical-block">

                        <div class="medical-label">
                            Observaciones de la evolución
                        </div>

                        <div class="medical-content">
                            {{ $evolucion->observaciones ?: 'Sin información registrada.' }}
                        </div>

                    </div>

                    {{-- Diagnósticos --}}
                    <div class="diagnosis-title">
                        Diagnósticos y tratamientos
                    </div>

                    @forelse($evolucion->DiagnosticoTratamiento as $registro)

                        <div class="diagnosis-card">

                            <div class="diagnosis-name">
                                {{ $registro->diagnostico ?? 'Diagnóstico no registrado' }}
                            </div>

                            <div class="diagnosis-detail">
                                <strong>Tratamiento</strong>
                                {{ $registro->tratamiento ?: 'Sin tratamiento registrado.' }}
                            </div>

                            <table class="detail-table">

                                <tr>
                                    <td>
                                        <span class="data-label">Medicamento</span>
                                        {{ $registro->medicamento ?: 'No registrado' }}
                                    </td>

                                    <td>
                                        <span class="data-label">Dosis</span>
                                        {{ $registro->dosis ?: 'No registrada' }}
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <span class="data-label">Frecuencia</span>
                                        {{ $registro->frecuencia ?: 'No registrada' }}
                                    </td>

                                    <td>
                                        <span class="data-label">Duración</span>
                                        {{ $registro->duracion ?: 'No registrada' }}
                                    </td>
                                </tr>

                            </table>

                            <div class="diagnosis-detail">
                                <strong>Procedimiento</strong>
                                {{ $registro->procedimiento ?: 'No registrado.' }}
                            </div>

                            <div class="diagnosis-detail">
                                <strong>Exámenes ordenados</strong>
                                {{ $registro->examenOrdenado ?: 'No registrados.' }}
                            </div>

                            <div class="diagnosis-detail">
                                <strong>Indicaciones</strong>
                                {{ $registro->indicaciones ?: 'No registradas.' }}
                            </div>

                        </div>

                    @empty

                        <div class="empty-box">
                            No hay diagnósticos ni tratamientos registrados en esta evolución.
                        </div>

                    @endforelse

                </div>

            </div>

        @empty

            <div class="empty-box">
                Esta historia clínica todavía no tiene evoluciones registradas.
            </div>

        @endforelse

    </div>

    {{-- PIE DE DOCUMENTO --}}
    <div class="footer">

        <span class="footer-brand">GEMAS</span>
        — Sistema de gestión veterinaria

        <br>

        Documento generado el {{ $fechaGeneracion }}

        <br>

        Este documento contiene información correspondiente al expediente
        médico de la mascota identificada en el encabezado.

    </div>

</body>
</html>


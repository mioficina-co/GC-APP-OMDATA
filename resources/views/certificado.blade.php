<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Certificado de Eliminación de Datos</title>
  <style>
    /* Quitar márgenes de la página */
    @page {
      margin: 0;
    }
    html, body {
      margin: 0;
      padding: 0;
      width: 21cm;
      height: 29.7cm;
      font-family: 'Arial', sans-serif;
    }
    /* Wrapper para centrar verticalmente */
    .wrapper {
      display: table;
      width: 100%;
      height: 100%;
    }
    .table-cell {
      display: table-cell;
      vertical-align: middle;
    }
    /* Contenedor principal del certificado (altura auto para ajustar el contenido) */
    .container {
      width: 21cm;
      margin: 0 auto;
      background: white;
      padding: 1.5cm;
      box-sizing: border-box;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      position: relative;
    }
    /* Encabezado */
    .header {
      text-align: center;
      margin-bottom: 1.5rem;
      border-bottom: 2px solid #2c3e50;
      padding-bottom: 1rem;
    }
    .logo {
      height: 70px;
      margin-bottom: 0.5rem;
    }
    .title {
      font-size: 24px;
      font-weight: 700;
      color: #2c3e50;
      text-transform: uppercase;
      letter-spacing: 1px;
      margin: 0.5rem 0;
    }
    .subtitle {
      font-size: 16px;
      color: #4a5568;
      margin-top: 0.5rem;
    }
    /* Contenido principal */
    .content {
      margin: 1.5rem auto;
      max-width: 16cm;
      text-align: center;
    }
    .declaration {
      font-size: 14px;
      line-height: 1.5;
      color: #4a5568;
      margin: 1.5rem 0;
      padding: 0 1rem;
      text-align: center;
    }
    /* Grid de datos */
    .data-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 0.75rem;
      margin: 1rem 0;
      padding: 1rem;
      background: #f8fafc;
      border-radius: 6px;
      border: 1px solid #e2e8f0;
      text-align: left;
    }
    .data-item {
      margin: 0.25rem 0;
    }
    .data-label {
      font-weight: 600;
      color: #2c3e50;
      display: block;
      margin-bottom: 0.1rem;
      font-size: 13px;
    }
    .data-value {
      color: #4a5568;
      font-size: 13px;
      word-wrap: break-word;
      overflow-wrap: break-word;
      display: block;
      max-width: 100%;
    }
    /* Firma */
    .signature {
      margin-top: 2rem;
      text-align: center;
    }
    .signature-line {
      display: inline-block;
      width: 250px;
      border-top: 2px solid #2c3e50;
      margin: 0.5rem 0;
    }
    .signature-text {
      color: #4a5568;
      font-size: 12px;
      margin-top: 0.25rem;
    }
    /* Pie de página */
    .footer {
      text-align: center;
      font-size: 10px;
      color: #718096;
      margin-top: 2rem;
    }
    /* Watermark */
    .watermark {
      position: absolute;
      opacity: 0.1;
      font-size: 100px;
      transform: rotate(-45deg);
      top: 40%;
      left: 20%;
      z-index: -1;
      color: #2c3e50;
      font-weight: bold;
      pointer-events: none;
    }
  </style>
</head>
<body>
  <div class="wrapper">
    <div class="table-cell">
      <div class="container">
        <!-- Watermark -->
        <div class="watermark">CERTIFICADO</div>

        <!-- Encabezado -->
        <div class="header">
          <img src="{{ public_path('assets/images/logo_sm_omdata-alt.png') }}" class="logo" alt="OMDATA">
          <h1 class="title">Certificado de Eliminación de Datos</h1>
          <p class="subtitle">Cumplimiento de la Ley de Protección de Datos Personales</p>
        </div>

        <!-- Contenido principal -->
        <div class="content">
          <div class="declaration">
            Se certifica que la información personal del titular ha sido eliminada permanentemente de nuestros sistemas de acuerdo con lo establecido en nuestras políticas de seguridad de datos y la normativa vigente.
          </div>
          <div class="data-grid">
            <div class="data-item">
              <span class="data-label">Nombre Completo</span>
              <span class="data-value">{{ $nombre }}</span>
            </div>
            <div class="data-item">
              <span class="data-label">Número de Documento</span>
              <span class="data-value">{{ $documento }}</span>
            </div>
            <div class="data-item">
              <span class="data-label">Teléfono</span>
              <span class="data-value">{{ $telefono }}</span>
            </div>
            <div class="data-item">
              <span class="data-label">Correo Electrónico</span>
              <span class="data-value">{{ $email }}</span>
            </div>
            <div class="data-item">
              <span class="data-label">EPS</span>
              <span class="data-value">{{ $eps }}</span>
            </div>
            <div class="data-item">
              <span class="data-label">ARL</span>
              <span class="data-value">{{ $arl }}</span>
            </div>
            <div class="data-item">
              <span class="data-label">Fecha de Registro</span>
              <span class="data-value">{{ $fecha_creacion }}</span>
            </div>
            <div class="data-item">
              <span class="data-label">Fecha de Eliminación</span>
              <span class="data-value">{{ $fecha_eliminacion }}</span>
            </div>
          </div>
        </div>

        <!-- Firma -->
        <div class="signature">
          <div class="signature-line"></div>
          <div class="signature-text">Firma Autorizada - Responsable de Protección de Datos</div>
        </div>

        <!-- Pie de página -->
        <div class="footer">
          © {{ date('Y') }} OMDATA · Todos los derechos reservados · www.omdata.com
        </div>
      </div>
    </div>
  </div>
</body>
</html>

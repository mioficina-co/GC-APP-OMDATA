<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class VisitasRepository
{
    public function tratamientoImagen($base64, $numerodocumento, $tipo)
    {
        // Campo a reportar en validación según tipo
        $field = match ($tipo) {
            'foto' => 'foto',
            'firma' => 'firma',
            default => null,
        };

        if (!$field) {
            // Si intentan manipular el payload con un tipo inválido → 422 controlado
            throw ValidationException::withMessages([
                'foto' => 'Tipo de evidencia no permitido.',
            ]);
        }

        try {
            $base64 = trim($base64);

            if ($base64 === '') {
                throw ValidationException::withMessages([
                    $field => 'La imagen es requerida.',
                ]);
            }

            // 1) Validar encabezado Base64 permitido
            // Acepta: data:image/jpeg;base64,  data:image/jpg;base64,  data:image/png;base64,
            if (!preg_match('/^data:image\/(jpeg|jpg|png);base64,/', $base64)) {
                throw ValidationException::withMessages([
                    $field => 'El formato del archivo no es válido. Solo se permite JPG o PNG.',
                ]);
            }

            // 2) Separar metadatos y data
            $parts = explode(',', $base64, 2);
            if (count($parts) !== 2 || $parts[1] === '') {
                throw ValidationException::withMessages([
                    $field => 'El contenido de la imagen no es válido.',
                ]);
            }

            [$meta, $data] = $parts;

            // 3) Decodificar Base64 (strict)
            $decoded = base64_decode($data, true);
            if ($decoded === false) {
                throw ValidationException::withMessages([
                    $field => 'La imagen no pudo ser decodificada.',
                ]);
            }

            // 4) Validar tamaño (ajusta según tu operación)
            $maxBytes = 2 * 1024 * 1024;  // 2MB
            if (strlen($decoded) > $maxBytes) {
                throw ValidationException::withMessages([
                    $field => 'La imagen excede el tamaño permitido (máx. 2MB).',
                ]);
            }

            // 5) Validar que sea imagen real
            $info = @getimagesizefromstring($decoded);
            if ($info === false) {
                throw ValidationException::withMessages([
                    $field => 'El archivo no es una imagen válida.',
                ]);
            }

            $width = $info[0] ?? 0;
            $height = $info[1] ?? 0;

            if ($tipo === 'foto' && ($width < 240 || $height < 240)) {
                throw ValidationException::withMessages([
                    $field => 'La foto debe tener una resolución mínima de 240x240 píxeles.',
                ]);
            }

            // 6) Validar MIME permitido
            $mime = $info['mime'] ?? null;

            $extMap = [
                'image/jpeg' => 'jpg',
                'image/jpg' => 'jpg',
                'image/png' => 'png',
            ];

            if (!$mime || !isset($extMap[$mime])) {
                throw ValidationException::withMessages([
                    $field => 'Tipo de imagen no permitido. Solo se permite JPG o PNG.',
                ]);
            }

            $ext = $extMap[$mime];

            // 7) Construir ruta segura
            $documentoSafe = preg_replace('/\D+/', '', $numerodocumento) ?: 'doc';
            $dir = $tipo === 'foto' ? 'visitantes/fotos/' : 'visitantes/firmas/';
            $ruta = $dir . uniqid('', true) . '_' . $documentoSafe . '.' . $ext;

            // 8) Guardar en disk public
            $ok = Storage::disk('public')->put($ruta, $decoded);

            if (!$ok) {
                throw ValidationException::withMessages([
                    $field => 'No fue posible almacenar la imagen. Intente nuevamente.',
                ]);
            }

            return [
                'ruta' => $ruta,
                'mime' => $mime,
                'ext' => $ext,
            ];
        } catch (ValidationException $e) {
            // Mantener respuesta 422 (Livewire mostrará errores de validación)
            throw $e;
        } catch (\Throwable $e) {
            // Evitar exponer detalles técnicos; responder 422 controlado
            throw ValidationException::withMessages([
                $field => 'Ocurrió un error procesando la imagen. Intente nuevamente.',
            ]);
        }
    }
}

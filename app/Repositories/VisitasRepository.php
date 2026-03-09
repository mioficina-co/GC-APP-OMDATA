<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class VisitasRepository
{
    public function tratamientoImagen(string $base64, string $numerodocumento, string $tipo): array
    {
        $field = match ($tipo) {
            'foto' => 'foto',
            'firma' => 'firma',
            default => null,
        };

        if (!$field) {
            throw ValidationException::withMessages([
                'foto' => 'Tipo de evidencia no permitido.',
            ]);
        }

        $base64 = trim($base64);

        if ($base64 === '') {
            throw ValidationException::withMessages([
                $field => 'La imagen es requerida.',
            ]);
        }

        // En este flujo ambas evidencias salen del canvas del navegador.
        if (!str_starts_with($base64, 'data:image/png;base64,')) {
            throw ValidationException::withMessages([
                $field => 'Formato no permitido. Solo se acepta PNG.',
            ]);
        }

        $parts = explode(',', $base64, 2);

        if (count($parts) !== 2 || $parts[1] === '') {
            throw ValidationException::withMessages([
                $field => 'El contenido de la imagen no es válido.',
            ]);
        }

        $decoded = base64_decode($parts[1], true);

        if ($decoded === false) {
            throw ValidationException::withMessages([
                $field => 'La imagen no pudo ser decodificada.',
            ]);
        }

        $maxBytes = $tipo === 'foto'
            ? 3 * 1024 * 1024
            : 1 * 1024 * 1024;

        if (strlen($decoded) > $maxBytes) {
            throw ValidationException::withMessages([
                $field => 'La imagen excede el tamaño permitido.',
            ]);
        }

        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $realMime = $finfo->buffer($decoded);

        if ($realMime !== 'image/png') {
            throw ValidationException::withMessages([
                $field => 'El archivo no corresponde a un PNG válido.',
            ]);
        }

        $image = @imagecreatefromstring($decoded);

        if ($image === false) {
            throw ValidationException::withMessages([
                $field => 'El archivo no es una imagen válida.',
            ]);
        }

        try {
            $width = imagesx($image);
            $height = imagesy($image);

            if ($tipo === 'foto') {
                if ($width < 240 || $height < 240) {
                    throw ValidationException::withMessages([
                        $field => 'La foto debe tener una resolución mínima de 240x240 píxeles.',
                    ]);
                }

                if ($width > 1200 || $height > 1200) {
                    throw ValidationException::withMessages([
                        $field => 'La foto excede la resolución máxima permitida.',
                    ]);
                }

                if (abs($width - $height) > 10) {
                    throw ValidationException::withMessages([
                        $field => 'La foto debe conservar formato cuadrado.',
                    ]);
                }
            }

            if ($tipo === 'firma') {
                if ($width < 150 || $height < 80) {
                    throw ValidationException::withMessages([
                        $field => 'La firma no tiene una resolución válida.',
                    ]);
                }

                if ($width > 1200 || $height > 800) {
                    throw ValidationException::withMessages([
                        $field => 'La firma excede la resolución máxima permitida.',
                    ]);
                }
            }

            imagealphablending($image, false);
            imagesavealpha($image, true);

            ob_start();
            imagepng($image, null, 6);
            $cleanBytes = ob_get_clean();

            if ($cleanBytes === false || $cleanBytes === '') {
                throw ValidationException::withMessages([
                    $field => 'No fue posible normalizar la imagen.',
                ]);
            }
        } finally {
            imagedestroy($image);
        }

        $dir = $tipo === 'foto'
            ? 'visitantes/fotos/' . now()->format('Y/m')
            : 'visitantes/firmas/' . now()->format('Y/m');

        $ruta = $dir . '/' . Str::ulid() . '.png';

        $ok = Storage::disk('private')->put($ruta, $cleanBytes);

        if (!$ok) {
            throw ValidationException::withMessages([
                $field => 'No fue posible almacenar la imagen.',
            ]);
        }

        return [
            'ruta' => $ruta,
            'mime' => 'image/png',
            'ext' => 'png',
            'sha256' => hash('sha256', $cleanBytes),
            'size_bytes' => strlen($cleanBytes),
            'width' => $width,
            'height' => $height,
        ];
    }
}

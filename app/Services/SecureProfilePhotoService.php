<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class SecureProfilePhotoService
{
    public function store(UploadedFile $file, int|string $userId): array
    {
        if (!$file->isValid()) {
            throw ValidationException::withMessages([
                'photo' => 'El archivo cargado no es válido.',
            ]);
        }

        $raw = @file_get_contents($file->getRealPath());

        if ($raw === false || $raw === '') {
            throw ValidationException::withMessages([
                'photo' => 'No fue posible leer la imagen cargada.',
            ]);
        }

        if (strlen($raw) > (2 * 1024 * 1024)) {
            throw ValidationException::withMessages([
                'photo' => 'La imagen excede el tamaño permitido de 2 MB.',
            ]);
        }

        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $realMime = $finfo->buffer($raw);

        if (!in_array($realMime, ['image/jpeg', 'image/png', 'image/webp'], true)) {
            throw ValidationException::withMessages([
                'photo' => 'Formato no permitido. Solo se acepta JPG, PNG o WEBP.',
            ]);
        }

        $image = @imagecreatefromstring($raw);

        if ($image === false) {
            throw ValidationException::withMessages([
                'photo' => 'El archivo no corresponde a una imagen válida.',
            ]);
        }

        $normalized = null;

        try {
            $width = imagesx($image);
            $height = imagesy($image);

            if ($width < 120 || $height < 120) {
                throw ValidationException::withMessages([
                    'photo' => 'La imagen debe tener una resolución mínima de 120x120 píxeles.',
                ]);
            }

            if ($width > 4000 || $height > 4000) {
                throw ValidationException::withMessages([
                    'photo' => 'La imagen excede la resolución máxima permitida.',
                ]);
            }

            [$targetWidth, $targetHeight] = $this->fitWithin($width, $height, 1200, 1200);

            $normalized = imagecreatetruecolor($targetWidth, $targetHeight);

            $white = imagecolorallocate($normalized, 255, 255, 255);
            imagefill($normalized, 0, 0, $white);

            imagecopyresampled(
                $normalized,
                $image,
                0,
                0,
                0,
                0,
                $targetWidth,
                $targetHeight,
                $width,
                $height
            );

            ob_start();
            imagejpeg($normalized, null, 90);
            $cleanBytes = ob_get_clean();

            if ($cleanBytes === false || $cleanBytes === '') {
                throw ValidationException::withMessages([
                    'photo' => 'No fue posible normalizar la imagen.',
                ]);
            }
        } finally {
            imagedestroy($image);

            if ($normalized instanceof \GdImage || is_resource($normalized)) {
                imagedestroy($normalized);
            }
        }

        $path = 'profile-photos/' . $userId . '/' . Str::ulid() . '.jpg';

        $ok = Storage::disk('private')->put($path, $cleanBytes);

        if (!$ok) {
            throw ValidationException::withMessages([
                'photo' => 'No fue posible almacenar la imagen.',
            ]);
        }

        return [
            'ruta' => $path,
            'mime' => 'image/jpeg',
            'ext' => 'jpg',
            'sha256' => hash('sha256', $cleanBytes),
            'size_bytes' => strlen($cleanBytes),
            'width' => $targetWidth,
            'height' => $targetHeight,
        ];
    }

    private function fitWithin(int $width, int $height, int $maxWidth, int $maxHeight): array
    {
        if ($width <= $maxWidth && $height <= $maxHeight) {
            return [$width, $height];
        }

        $ratio = min($maxWidth / $width, $maxHeight / $height);

        return [
            max(1, (int) floor($width * $ratio)),
            max(1, (int) floor($height * $ratio)),
        ];
    }
}

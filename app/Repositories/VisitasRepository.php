<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Storage;

class VisitasRepository
{
    public function tratamientoImagen($base64, $numerodocumento, $tipo)
    {

        try {
            // Validar que sea Base64 con un encabezado de imagen válido
            if (!preg_match('/^data:image\/(jpeg|jpg|png);base64,/', $base64)) {
                throw new \Exception('El formato del archivo no es válido.');
            }

            // Extraer datos del archivo
            [$meta, $data] = explode(',', $base64, 2);

            // Decodificar los datos y validar el tamaño
            $dataDecodificada = base64_decode($data, true);
            if ($dataDecodificada === false) {
                throw new \Exception('El archivo no pudo ser decodificado.');
            }

            // Validar que sea una imagen válida
            $infoArchivo = getimagesizefromstring($dataDecodificada);
            if ($infoArchivo === false) {
                throw new \Exception('El archivo no es una imagen válida.');
            }

            // Determinar el formato de la imagen
            $extensiones = ['image/jpeg' => 'jpg', 'image/png' => 'png'];
            $extension = $extensiones[$infoArchivo['mime']] ?? 'png';

            // Construir la ruta de almacenamiento según el tipo
            $directorio = $tipo === 'foto' ? 'visitantes/fotos/' : 'visitantes/firmas/';
            $rutaArchivo = $directorio . uniqid('', false) . '_' . $numerodocumento . '.' . $extension;

            // Almacenar el archivo
            Storage::disk('public')->put($rutaArchivo, $dataDecodificada);

            return $rutaArchivo;

        } catch (\Exception $e) {
            // Manejar errores
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}

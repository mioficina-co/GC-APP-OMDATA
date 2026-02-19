import './bootstrap';
import './js/countUp.min';
import SignaturePad from 'signature_pad';
window.SignaturePad = SignaturePad; // Exponer SignaturePad globalmente

import flatpickr from "flatpickr"; // Importar Flatpickr
import "flatpickr/dist/flatpickr.min.css"; // Importar estilos
import { Spanish } from "flatpickr/dist/l10n/es.js"; // Importar localización en español

// Configuración global para Flatpickr
window.flatpickr = flatpickr; // Exponer Flatpickr globalmente si es necesario
flatpickr.localize(Spanish);

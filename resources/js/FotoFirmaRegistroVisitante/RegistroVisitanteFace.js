import { FaceDetector, FilesetResolver } from '@mediapipe/tasks-vision';

const MEDIAPIPE_VERSION = '0.10.32';

const DEFAULT_FACE_OPTIONS = {
    wasmPath: `https://cdn.jsdelivr.net/npm/@mediapipe/tasks-vision@${MEDIAPIPE_VERSION}/wasm`,
    modelPath: null,

    facingMode: 'user',
    idealWidth: 640,
    idealHeight: 480,

    processIntervalMs: 120,
    captureSize: 480,

    minDetectionConfidence: 0.75,
    minSuppressionThreshold: 0.3,

    minValidScore: 0.75,
    minKeypoints: 6,
    minAreaRatio: 0.10,
    maxOffsetX: 0.18,
    maxOffsetY: 0.20,
};

function buildStatePayload(ok, message, extra = {}) {
    return {
        ok: ok,
        message: message || null,
        count: typeof extra.count === 'number' ? extra.count : 0,
        score: typeof extra.score === 'number' ? extra.score : null,
        box: extra.box || [],
        foto: extra.foto || '',
    };
}

function stopMediaStream(stream) {
    if (!stream) return;

    stream.getTracks().forEach((track) => {
        try {
            track.stop();
        } catch (error) {
            console.warn('No fue posible detener un track de video:', error);
        }
    });
}

window.fotoHandler = function fotoHandler(userOptions = {}) {
    const options = {
        ...DEFAULT_FACE_OPTIONS,
        ...userOptions,
    };

    let detector = null;
    let mediaStream = null;
    let rafId = null;
    let lastVideoTime = -1;
    let lastProcessMs = 0;
    let initialized = false;
    let resetFotoRegistered = false;
    let pageHideHandler = null;

    return {
        isDetectorReady: false,
        detectorBusy: false,
        captureInProgress: false,
        faceReady: false,
        faceMessage: 'Inicializando cámara...',
        faceScore: null,
        faceCount: 0,
        photoPreviewSrc: '',
        currentMetrics: null,

        async init() {
            if (initialized) return;
            initialized = true;

            try {
                if (!options.modelPath) {
                    throw new Error('No se configuró modelPath para fotoHandler().');
                }

                await this.setupCamera();
                await this.setupDetector();
                this.registerResetEvent();
                this.registerLifecycleEvents();
                this.startDetectionLoop();
            } catch (error) {
                console.error('Error init fotoHandler:', error);
                this.invalidateFace('No fue posible inicializar la validación facial.');
            }
        },

        async setupCamera() {
            mediaStream = await navigator.mediaDevices.getUserMedia({
                video: {
                    facingMode: options.facingMode,
                    width: { ideal: options.idealWidth },
                    height: { ideal: options.idealHeight },
                },
                audio: false,
            });

            this.$refs.video.srcObject = mediaStream;
            await this.$refs.video.play();

            this.faceMessage = 'Ubique un único rostro dentro de la guía.';
        },

        async setupDetector() {
            const filesetResolver = await FilesetResolver.forVisionTasks(options.wasmPath);

            detector = await FaceDetector.createFromOptions(filesetResolver, {
                baseOptions: {
                    modelAssetPath: options.modelPath,
                },
                runningMode: 'VIDEO',
                minDetectionConfidence: options.minDetectionConfidence,
                minSuppressionThreshold: options.minSuppressionThreshold,
            });

            this.isDetectorReady = true;
            this.faceMessage = 'Detector listo. Mire al frente.';
        },

        registerResetEvent() {
            if (resetFotoRegistered || !window.Livewire) return;

            resetFotoRegistered = true;

            window.Livewire.on('resetFoto', () => {
                this.clearPhoto(false);
            });
        },

        registerLifecycleEvents() {
            if (pageHideHandler) return;

            pageHideHandler = () => {
                this.cleanup();
            };

            window.addEventListener('pagehide', pageHideHandler);
            window.addEventListener('beforeunload', pageHideHandler);
        },

        startDetectionLoop() {
            this.stopDetectionLoop();

            const loop = async () => {
                if (
                    !detector ||
                    !this.$refs.video ||
                    this.$refs.video.readyState < 2 ||
                    this.captureInProgress ||
                    this.detectorBusy
                ) {
                    rafId = requestAnimationFrame(loop);
                    return;
                }

                const now = performance.now();

                if ((now - lastProcessMs) < options.processIntervalMs) {
                    rafId = requestAnimationFrame(loop);
                    return;
                }

                if (this.$refs.video.currentTime === lastVideoTime) {
                    rafId = requestAnimationFrame(loop);
                    return;
                }

                this.detectorBusy = true;

                try {
                    const result = detector.detectForVideo(this.$refs.video, now);
                    const detections = result && result.detections ? result.detections : [];

                    this.handleDetections(
                        detections,
                        this.$refs.video.videoWidth,
                        this.$refs.video.videoHeight
                    );

                    lastVideoTime = this.$refs.video.currentTime;
                    lastProcessMs = now;
                } catch (error) {
                    console.error('Error detectForVideo:', error);
                    this.invalidateFace('Error analizando el video.');
                } finally {
                    this.detectorBusy = false;
                    rafId = requestAnimationFrame(loop);
                }
            };

            rafId = requestAnimationFrame(loop);
        },

        stopDetectionLoop() {
            if (rafId) {
                cancelAnimationFrame(rafId);
                rafId = null;
            }
        },

        handleDetections(detections, frameWidth, frameHeight) {
            this.faceCount = detections.length;

            if (detections.length === 0) {
                this.invalidateFace('No se detecta ningún rostro.');
                return;
            }

            if (detections.length > 1) {
                this.invalidateFace('Solo debe haber un rostro en cámara.');
                return;
            }

            const metrics = this.buildMetrics(detections[0], frameWidth, frameHeight);
            const error = this.validateMetrics(metrics);

            if (error) {
                this.invalidateFace(error, metrics);
                return;
            }

            this.faceReady = true;
            this.faceScore = metrics.score;
            this.currentMetrics = metrics;
            this.faceMessage = `Rostro válido detectado (${Math.round(metrics.score * 100)}%).`;
        },

        buildMetrics(detection, frameWidth, frameHeight) {
            const box = detection.boundingBox;

            let score = 0;
            if (detection.categories && detection.categories[0]) {
                score = detection.categories[0].score;
            }

            const keypoints = detection.keypoints ? detection.keypoints.length : 0;

            const centerX = box.originX + (box.width / 2);
            const centerY = box.originY + (box.height / 2);

            const offsetX = Math.abs(centerX - (frameWidth / 2)) / frameWidth;
            const offsetY = Math.abs(centerY - (frameHeight / 2)) / frameHeight;
            const areaRatio = (box.width * box.height) / (frameWidth * frameHeight);

            return {
                score: Number(score.toFixed(4)),
                keypoints,
                areaRatio,
                offsetX,
                offsetY,
                box: {
                    originX: Math.round(box.originX),
                    originY: Math.round(box.originY),
                    width: Math.round(box.width),
                    height: Math.round(box.height),
                },
            };
        },

        validateMetrics(metrics) {
            if (metrics.score < options.minValidScore) {
                return 'La confianza del rostro es baja. Mire al frente.';
            }

            if (metrics.keypoints < options.minKeypoints) {
                return 'No se detecta el rostro completo.';
            }

            if (metrics.areaRatio < options.minAreaRatio) {
                return 'Acérquese un poco más a la cámara.';
            }

            if (metrics.offsetX > options.maxOffsetX || metrics.offsetY > options.maxOffsetY) {
                return 'Centre el rostro dentro de la guía.';
            }

            return null;
        },

        invalidateFace(message, metrics = null) {
            this.faceReady = false;
            this.faceScore = metrics ? metrics.score : null;
            this.currentMetrics = metrics;
            this.faceMessage = message;
        },

        captureFrameToCanvas(video, canvas) {
            const context = canvas.getContext('2d', { willReadFrequently: true });

            const side = Math.min(video.videoWidth, video.videoHeight);
            const sx = (video.videoWidth - side) / 2;
            const sy = (video.videoHeight - side) / 2;

            canvas.width = options.captureSize;
            canvas.height = options.captureSize;

            context.clearRect(0, 0, canvas.width, canvas.height);
            context.drawImage(video, sx, sy, side, side, 0, 0, canvas.width, canvas.height);

            return canvas.toDataURL('image/png');
        },

        async capturePhoto() {
            if (!this.faceReady || !detector || this.captureInProgress) {
                this.syncLivewireFaceState(
                    buildStatePayload(false, 'No hay un rostro válido para capturar.')
                );
                return;
            }

            this.captureInProgress = true;

            try {
                const video = this.$refs.video;
                const canvas = this.$refs.photoCanvas;

                const metrics = this.currentMetrics;

                if (!metrics) {
                    this.clearPhoto(false);
                    this.invalidateFace('No hay métricas válidas del rostro. Intente nuevamente.');
                    this.syncLivewireFaceState(
                        buildStatePayload(false, 'No hay métricas válidas del rostro. Intente nuevamente.')
                    );
                    return;
                }

                const error = this.validateMetrics(metrics);

                if (error) {
                    this.clearPhoto(false);
                    this.invalidateFace(error, metrics);
                    this.syncLivewireFaceState(
                        buildStatePayload(false, error, {
                            count: 1,
                            score: metrics.score,
                            box: metrics.box,
                        })
                    );
                    return;
                }

                const dataUrl = this.captureFrameToCanvas(video, canvas);

                this.photoPreviewSrc = dataUrl;
                this.faceReady = true;
                this.faceScore = metrics.score;
                this.faceCount = 1;
                this.faceMessage = 'Foto capturada correctamente con un rostro válido.';

                this.syncLivewireFaceState(
                    buildStatePayload(true, 'Foto validada correctamente.', {
                        count: 1,
                        score: metrics.score,
                        box: metrics.box,
                        foto: dataUrl,
                    })
                );
            } catch (error) {
                console.error('Error capturePhoto:', error);
                this.clearPhoto(false);
                this.invalidateFace('Error validando la foto capturada.');
                this.syncLivewireFaceState(
                    buildStatePayload(false, 'Error validando la foto capturada.')
                );
            } finally {
                this.captureInProgress = false;
            }
        },

        syncLivewireFaceState(payload = {}) {
            if (!this.$wire) {
                console.error('Livewire no está disponible dentro de fotoHandler.');
                return;
            }

            this.$wire.$set('foto', payload.foto ? payload.foto : '');
            this.$wire.$set('foto_face_ok', payload.ok ? true : false);
            this.$wire.$set('foto_face_count', typeof payload.count === 'number' ? payload.count : 0);
            this.$wire.$set('foto_face_score', typeof payload.score === 'number' ? payload.score : null);
            this.$wire.$set('foto_face_box', payload.box ? payload.box : []);
            this.$wire.$set('foto_face_message', payload.message ? payload.message : null);
        },

        clearPhoto(sync = true) {
            this.photoPreviewSrc = '';

            const canvas = this.$refs.photoCanvas;
            if (canvas) {
                const context = canvas.getContext('2d');
                context.clearRect(0, 0, canvas.width, canvas.height);
            }

            if (sync) {
                this.syncLivewireFaceState(
                    buildStatePayload(false, 'Debe capturar nuevamente una foto válida.')
                );
            }
        },

        cleanup() {
            this.stopDetectionLoop();

            if (pageHideHandler) {
                window.removeEventListener('pagehide', pageHideHandler);
                window.removeEventListener('beforeunload', pageHideHandler);
                pageHideHandler = null;
            }

            stopMediaStream(mediaStream);
            mediaStream = null;

            if (detector && typeof detector.close === 'function') {
                try {
                    detector.close();
                } catch (error) {
                    console.warn('No fue posible cerrar el detector:', error);
                }
            }

            detector = null;
            this.isDetectorReady = false;
        },
    };
};

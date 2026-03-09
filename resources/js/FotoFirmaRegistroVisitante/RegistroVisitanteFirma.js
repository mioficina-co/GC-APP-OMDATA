function scrollToFirstError() {
    const firstError = document.querySelector('.text-red-600, .text-red-500, .error-message');

    if (firstError) {
        firstError.scrollIntoView({
            behavior: 'smooth',
            block: 'center',
        });
    }
}

window.scrollToError = function scrollToError() {
    return {
        scrollToError() {
            scrollToFirstError();
        },
    };
};

window.scrollHandler = function scrollHandler() {
    return {
        scrolledToBottom: false,
        atBottom: false,

        checkScroll(event) {
            const element = event.target;
            const scrollPosition = Math.ceil(element.scrollTop + element.clientHeight);
            const isAtBottom = scrollPosition >= element.scrollHeight;

            this.scrolledToBottom = isAtBottom;
            this.atBottom = isAtBottom;
        },
    };
};

window.firmaHandler = function firmaHandler() {
    let signaturePad = null;
    let resizeHandler = null;
    let resetFirmaRegistered = false;

    return {
        ready: false,

        init() {
            this.$nextTick(() => {
                this.setupSignaturePad();
                this.registerResetEvent();
                this.registerResizeEvent();
            });
        },

        setupSignaturePad() {
            const canvas = this.$refs.canvas;

            if (!canvas) {
                console.error('Canvas de firma no encontrado.');
                return;
            }

            if (!window.SignaturePad) {
                console.error('SignaturePad no está disponible globalmente.');
                return;
            }

            this.resizeCanvas();

            signaturePad = new window.SignaturePad(canvas, {
                minWidth: 0.8,
                maxWidth: 2.2,
                penColor: '#1f2937',
            });

            this.ready = true;
        },

        resizeCanvas() {
            const canvas = this.$refs.canvas;
            if (!canvas) return;

            const ratio = Math.max(window.devicePixelRatio || 1, 1);
            const cssWidth = canvas.offsetWidth || 300;
            const cssHeight = canvas.offsetHeight || 200;

            const currentData = signaturePad && !signaturePad.isEmpty() ? signaturePad.toData() : null;

            canvas.width = cssWidth * ratio;
            canvas.height = cssHeight * ratio;
            canvas.getContext('2d').scale(ratio, ratio);

            canvas.style.width = `${cssWidth}px`;
            canvas.style.height = `${cssHeight}px`;

            if (signaturePad) {
                signaturePad.clear();

                if (currentData && currentData.length) {
                    signaturePad.fromData(currentData);
                }
            }
        },

        registerResizeEvent() {
            if (resizeHandler) return;

            resizeHandler = () => {
                this.resizeCanvas();
            };

            window.addEventListener('resize', resizeHandler);
        },

        registerResetEvent() {
            if (resetFirmaRegistered || !window.Livewire) return;

            resetFirmaRegistered = true;

            window.Livewire.on('resetFirma', () => {
                this.clear();
            });
        },

        clear() {
            if (signaturePad) {
                signaturePad.clear();
            }

            if (this.$wire) {
                this.$wire.$set('firma', '');
            }
        },

        captureSignature() {
            if (!signaturePad || signaturePad.isEmpty()) {
                if (this.$wire) {
                    this.$wire.$set('firma', '');
                }
                return;
            }

            const firmaBase64 = signaturePad.toDataURL('image/png');

            if (this.$wire) {
                this.$wire.$set('firma', firmaBase64);
            }
        },

        cleanup() {
            if (resizeHandler) {
                window.removeEventListener('resize', resizeHandler);
                resizeHandler = null;
            }

            if (signaturePad) {
                signaturePad.off();
                signaturePad = null;
            }

            this.ready = false;
        },
    };
};

function bindRegistroVisitanteLivewireUi() {
    if (!window.Livewire || window.__registroVisitanteUiHooksBound) return;

    window.__registroVisitanteUiHooksBound = true;

    window.Livewire.on('confirmacionGuardado', () => {
        if (!window.Swal) return;

        window.Swal.fire({
            title: '¡Registro Exitoso!',
            text: 'Gracias por registrarte. Ahora puedes disfrutar de todos nuestros servicios.',
            icon: 'success',
            iconColor: '#4CAF50',
            confirmButtonText: '¡Genial!',
            confirmButtonColor: '#3085d6',
            background: '#f9f9f9',
            color: '#333',
            timer: 5000,
            timerProgressBar: true,
            showClass: {
                popup: 'animate__animated animate__fadeInDown',
            },
            hideClass: {
                popup: 'animate__animated animate__fadeOutUp',
            },
        });
    });

    window.Livewire.hook('message.processed', () => {
        scrollToFirstError();
    });
}

document.addEventListener('livewire:init', bindRegistroVisitanteLivewireUi);
document.addEventListener('DOMContentLoaded', bindRegistroVisitanteLivewireUi);

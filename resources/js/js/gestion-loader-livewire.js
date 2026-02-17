document.addEventListener('livewire:navigated', function () {
    const loader = document.querySelector('.screen_loader');
    if (loader) {
        loader.classList.add('animate__fadeOut');
        setTimeout(() => {
            if (loader.parentNode) {
                loader.parentNode.removeChild(loader);
            }
        }, 200);
    }
});
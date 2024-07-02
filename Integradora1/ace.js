document.getElementById('startButton').addEventListener('click', function() {
    const downloadSpeedElement = document.getElementById('downloadSpeed');
    const uploadSpeedElement = document.getElementById('uploadSpeed');

    // URL de un archivo para probar la velocidad de descarga
    const downloadUrl = 'https://www.youtube.com'; // Reemplaza con una URL válida
    const uploadUrl = 'https://icons.getbootstrap.com/'; // Reemplaza con una URL válida

    // Medir velocidad de descarga
    measureDownloadSpeed(downloadUrl, (speed) => {
        downloadSpeedElement.textContent = speed.toFixed(2);
    });

    // Medir velocidad de subida
    measureUploadSpeed(uploadUrl, (speed) => {
        uploadSpeedElement.textContent = speed.toFixed(2);
    });
});

function measureDownloadSpeed(url, callback) {
    const startTime = (new Date()).getTime();
    const xhr = new XMLHttpRequest();

    xhr.open('GET', url, true);
    xhr.responseType = 'blob';

    xhr.onload = function() {
        const endTime = (new Date()).getTime();
        const fileSize = xhr.response.size * 8; // Tamaño en bits
        const duration = (endTime - startTime) / 1000; // Duración en segundos
        const speed = fileSize / duration / 1024 / 1024; // Velocidad en Mbps

        callback(speed);
    };

    xhr.send();
}

function measureUploadSpeed(url, callback) {
    const startTime = (new Date()).getTime();
    const xhr = new XMLHttpRequest();
    const data = new Blob([new Uint8Array(10 * 1024 * 1024)]); // Archivo de 10MB

    xhr.open('POST', url, true);

    xhr.onload = function() {
        const endTime = (new Date()).getTime();
        const fileSize = data.size * 8; // Tamaño en bits
        const duration = (endTime - startTime) / 1000; // Duración en segundos
        const speed = fileSize / duration / 1024 / 1024; // Velocidad en Mbps

        callback(speed);
    };

    xhr.send(data);
}


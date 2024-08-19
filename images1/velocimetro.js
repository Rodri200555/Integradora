const barraVelocidad = document.getElementById('barra-velocidad');
const barraPing = document.getElementById('barra-ping');
const velocidadElement = document.getElementById('velocidad');
const pingElement = document.getElementById('ping');

let velocidad = 0;
let ping = 0;

function actualizarGrafica() {
	barraVelocidad.style.width = (velocidad / 100) * 100 + '%';
	barraPing.style.width = (ping / 100) * 100 + '%';
	velocidadElement.textContent = velocidad.toFixed(2) + ' Mbps';
	pingElement.textContent = ping.toFixed(2) + ' ms';
}

function medirVelocidad() {
	const startTime = performance.now();
	const xhr = new XMLHttpRequest();
	xhr.open('GET', '(https://www.netflix.com/mx/)', true);
	xhr.onload = () => {
		const endTime = performance.now();
		const duration = endTime - startTime;
		velocidad = (xhr.responseText.length * 8) / (duration / 1000) / 1024 / 1024;
		ping = duration;
		actualizarGrafica();
	};
	xhr.send();
}

setInterval(medirVelocidad, 1000); // Medir velocidad cada 1 segundo

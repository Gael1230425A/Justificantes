const fs = require('fs');
const express = require('express');
const { Client, LocalAuth } = require('whatsapp-web.js');
const qrcode = require('qrcode'); // Para generar QR en formato base64

const app = express();
const port = 3000;

// Configuración del cliente de WhatsApp
const client = new Client({
    authStrategy: new LocalAuth(),
});

// Variable para almacenar el QR
let qrCodeData = null;
let estaAutenticado = false;

// Evento de generación del QR
client.on('qr', (qr) => {
    // Convertir el QR a base64 para enviarlo al navegador
    qrcode.toDataURL(qr, (err, url) => {
        if (err) {
            console.error('Error al generar QR:', err);
            return;
        }
        qrCodeData = url; // Guardar el QR en base64
    });
});

// Evento cuando el cliente está listo
client.on('ready', () => {
    console.log('Bot está listo para enviar mensajes.');
    estaAutenticado = true;
    // Cargar números desde un archivo JSON
    const numbers = JSON.parse(fs.readFileSync('numeros.json'));
    const mensaje = '¡Hola, este es un mensaje automatizado!';
});

client.on('auth_failure', () => {
    res.send(`
            <html>
                <body>
                    <h1 style='color:red;'>fallo de autenticado</h1>
                </body>
            </html>
        `);
})

client.initialize();

if (estaAutenticado) {
    res.send(`
        <html>
            <body>
                <h1>Cliente Autenticado</h1>
                <button onclick ='MandarMensajes()' >Mandar mensaje ${mensaje} </button>
            </body>
        </html>
    `);
}
// Configuración del servidor web con Express
app.get('/', (req, res) => {
    // Si hay un QR generado, mostrarlo, de lo contrario, indicar que no está listo
    if (qrCodeData) {
        console.log("qr realizado");
        res.send(`
            <html>
                <body>
                    <h1>Escanea el QR para iniciar sesión</h1>
                    <img src="${qrCodeData}" alt="Código QR">
                </body>
            </html>
        `);
    }
});

// Iniciar el servidor
app.listen(port, () => {
    console.log(`Servidor corriendo en http://localhost:${port}`);
});



function MandarMensajes() {
    // Enviar mensajes
    numbers.forEach(number => {
        const chatId = `${number}@c.us`; // Formato de ID de chat de WhatsApp
        client.sendmensaje(chatId, mensaje)
            .then(() => {
                console.log(`Mensaje enviado a: ${chatId}`);
            })
            .catch(err => {
                console.error('Error al enviar mensaje:', err);
            });
    });
}

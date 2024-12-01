const fs = require('fs');
const express = require('express');
const { Client, LocalAuth } = require('whatsapp-web.js');
const qrcode = require('qrcode'); // Para generar QR en formato base64

const app = express();
const port = 3000;

let qrCodeData = null;
let estaAutenticado = false;
let numbers = [];
const mensaje = '¡Hola, este es un mensaje automatizado!';

// Configuración del cliente de WhatsApp
const client = new Client({
    authStrategy: new LocalAuth(),
});

// Evento de generación del QR
client.on('qr', (qr) => {
    qrcode.toDataURL(qr, (err, url) => {
        if (err) {
            console.error('Error al generar QR:', err);
            return;
        }
        qrCodeData = url; // Guardar el QR en base64
    });
});

// Evento cuando el cliente está listo (autenticación exitosa)
client.on('ready', () => {
    console.log('Bot está listo para enviar mensajes.');
    estaAutenticado = true;
    window.location.reload();

    // Cargar números desde un archivo JSON de manera asíncrona
    fs.readFile('numeros.json', 'utf8', (err, data) => {
        if (err) {
            console.error('Error al leer el archivo de números:', err);
            return;
        }
        numbers = JSON.parse(data);
    });
});

// Evento cuando la autenticación falla
client.on('auth_failure', () => {
    console.log('Fallo de autenticación. Necesitas escanear el QR.');
});

// Inicializar el cliente de WhatsApp Web
client.initialize();

// Ruta principal que muestra el mensaje de carga o el QR si no está autenticado
app.get('/', (req, res) => {
    if (estaAutenticado) {
        res.send(`
            <html>
                <body>
                    <h1>Cliente Autenticado</h1>
                    <button onclick="window.location.href='/mandar-mensajes'">Mandar mensaje</button>
                </body>
            </html>
        `);
    } else if (qrCodeData) {
        res.send(`
            <html>
                <body>
                    <h1>Escanea el QR para iniciar sesión</h1>
                    <img src="${qrCodeData}" alt="Código QR">
                    <p>Por favor, escanea el código QR para autenticarte.</p>
                    <div id="carga">Cargando... por favor espera.</div>
                </body>
                <script>
                    // Aquí, puedes usar JavaScript para esperar la autenticación
                    setInterval(function() {
                        fetch('/check-auth')
                            .then(response => response.json())
                            .then(data => {
                                if (data.authenticated) {
                                    document.getElementById('carga').innerHTML = 'Autenticación completada. ¡Listo para enviar mensajes!';
                                }
                            });
                    }, 3000);
                </script>
            </html>
        `);
    } else {
        res.send(`
            <html>
                <body>
                    <h1>Esperando para generar el código QR...</h1>
                    <div id="carga">Cargando... por favor espera.</div>
                </body>
            </html>
        `);
    }
});

// Ruta para comprobar si el cliente está autenticado
app.get('/check-auth', (req, res) => {
    res.json({ authenticated: estaAutenticado });
});

// Ruta para enviar mensajes
app.get('/mandar-mensajes', (req, res) => {
    if (estaAutenticado) {
        // Enviar mensajes
        numbers.forEach(number => {
            const chatId = `${number}@c.us`; // Formato de ID de chat de WhatsApp
            client.sendMessage(chatId, mensaje)
                .then(() => {
                    console.log(`Mensaje enviado a: ${chatId}`);
                })
                .catch(err => {
                    console.error('Error al enviar mensaje:', err);
                });
        });
        res.send(`
            <html>
                <body>
                    <h1>Mensajes enviados con éxito!</h1>
                    <a href="/">Volver</a>
                </body>
            </html>
        `);
    } else {
        res.send(`
            <html>
                <body>
                    <h1>El bot no está autenticado. Vuelve a escanear el QR.</h1>
                    <a href="/">Volver</a>
                </body>
            </html>
        `);
    }
});
// Iniciar el servidor
app.listen(port, () => {
    console.log(`Servidor corriendo en http://localhost:${port}`);
});

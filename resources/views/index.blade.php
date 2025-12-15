<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Corporativo Zúñiga</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            /* Paleta de colores CORPORATIVA */
            --primary-blue: #003e65; /* Color corporativo principal */
            --white: #ffffff; 
            --bg: #f8f9fa; /* Fondo muy claro (Blanco suave) */
            --text-dark: #212529; /* Texto oscuro para contraste */
            --muted-dark: #6c757d; /* Texto gris para subtítulos */

            /* Variaciones para gradientes y blobs */
            --primary-light: #00568c; /* Versión más clara para gradiente */
            --blob-accent: #3876A2; /* Tono de azul más claro/vibrante para los blobs */
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--text-dark); 
            height: 100vh;
            overflow: hidden; 
        }

        /* ====== BLOBS MINIMALISTAS (Opacidad ajustada) ====== */
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }

        .blob-minimal {
            position: fixed; 
            z-index: 0; 
            width: 500px;
            height: 500px;
            border-radius: 50%;
            filter: blur(150px); 
            /* *** CAMBIO AQUÍ: Aumentamos la opacidad de 0.20 a 0.25 *** */
            opacity: 0.30; 
            mix-blend-mode: multiply; 
            animation: blob 7s infinite ease-in-out;
        }

        .blob-minimal.primary {
            background: var(--primary-blue);
            top: 15%;
            left: 5%;
        }

        .blob-minimal.accent {
            background: var(--blob-accent);
            bottom: 10%;
            right: 10%;
            animation-delay: 2s;
        }

        /* ====== CONTENIDO ====== */
        .container {
            position: relative;
            z-index: 10;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 2rem;
        }

        .card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(8px);
            border-radius: 20px;
            padding: 3.5rem 3rem;
            max-width: 520px;
            width: 100%;
            border: 1px solid rgba(0, 62, 101, 0.1); 
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1); 
        }

        /* Estilos de texto y botón */
        .logo {
            font-size: 2.4rem;
            font-weight: 700;
            letter-spacing: -0.03em;
            margin-bottom: 0.5rem;
            color: var(--primary-blue); 
        }

        .subtitle {
            color: var(--muted-dark);
            margin-bottom: 2.5rem;
            font-size: 1.05rem;
        }

        .enter-btn {
            display: inline-block;
            background: linear-gradient(135deg, var(--primary-blue), var(--primary-light));
            color: var(--white); 
            font-size: 1.2rem;
            font-weight: 600;
            padding: 1.1rem 3rem;
            border-radius: 999px;
            text-decoration: none;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            box-shadow: 0 10px 30px rgba(0, 62, 101, 0.4);
        }

        .enter-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 40px rgba(0, 62, 101, 0.6);
        }

        .footer {
            margin-top: 2.5rem;
            font-size: 0.85rem;
            color: var(--muted-dark);
        }

        @media (max-width: 640px) {
            .card {
                padding: 2.5rem 2rem;
            }

            .logo {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>

    <div class="blob-minimal primary"></div>
    <div class="blob-minimal accent"></div>

    <div class="container">
        <div class="card">
            <div class="logo">Corporativo Zúñiga</div>
            <div class="subtitle">
                Plataforma interna de gestión y comunicación
            </div>

            <a href="/admin" class="enter-btn">
                Entrar
            </a>

            <div class="footer">
                © <?= date('Y') ?> Corporativo Zúñiga
            </div>
        </div>
    </div>

</body>
</html>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Corporativo Zúñiga</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            /* Paleta de colores */
            --bg: #0f172a; /* Fondo muy oscuro */
            --primary: #38bdf8; /* Cian primario */
            --purple: #818cf8; /* Morado/Índigo (Nuevo color añadido de tu código original de blobs) */
            --cyan: #22d3ee; /* Cian secundario (Nuevo color añadido de tu código original de blobs) */
            --primary-dark: #0ea5e9;
            --text: #e5e7eb;
            --muted: #94a3b8;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--text);
            height: 100vh;
            /* Permite desplazamiento para el contenido si es necesario, pero mantiene el fondo fijo */
            overflow: hidden; 
        }

        /* ====== BLOBS MINIMALISTAS (NUEVO ESTILO) ====== */
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }

        .blob-minimal {
            position: fixed; /* Usar fixed para que el blob quede fijo en la pantalla */
            z-index: 0; /* Asegura que estén detrás del contenido */
            width: 500px;
            height: 500px;
            border-radius: 50%;
            filter: blur(150px); /* Aumento el blur para un look más etéreo */
            opacity: 0.35; /* Mucha menos opacidad */
            mix-blend-mode: screen; /* Clave para el efecto minimalista de "fusión" */
            animation: blob 7s infinite ease-in-out;
        }

        .blob-minimal.primary {
            background: var(--primary);
            top: 20%;
            left: 10%;
        }

        .blob-minimal.purple {
            background: var(--purple);
            bottom: 10%;
            right: 15%;
            animation-delay: 2s;
        }

        /* Removiendo el tercer blob (cyan) para mantenerlo minimalista, puedes añadirlo si lo deseas */
        /*
        .blob-minimal.cyan {
            background: var(--cyan);
            top: 60%;
            right: 50%;
            animation-delay: 4s;
        }
        */

        /* ====== CONTENIDO (Mantenido) ====== */
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
            /* Se ha reducido el fondo y el blur ligeramente para el nuevo estilo */
            background: rgba(15, 23, 42, 0.85);
            backdrop-filter: blur(8px);
            border-radius: 20px;
            padding: 3.5rem 3rem;
            max-width: 520px;
            width: 100%;
            box-shadow: 0 15px 45px rgba(0, 0, 0, 0.5); /* Sombra más sutil */
        }

        /* Estilos de texto y botón (Mantenidos) */
        .logo {
            font-size: 2.4rem;
            font-weight: 700;
            letter-spacing: -0.03em;
            margin-bottom: 0.5rem;
        }

        .subtitle {
            color: var(--muted);
            margin-bottom: 2.5rem;
            font-size: 1.05rem;
        }

        .enter-btn {
            display: inline-block;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: #020617;
            font-size: 1.2rem;
            font-weight: 600;
            padding: 1.1rem 3rem;
            border-radius: 999px;
            text-decoration: none;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            box-shadow: 0 10px 30px rgba(56, 189, 248, 0.4);
        }

        .enter-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 40px rgba(56, 189, 248, 0.6);
        }

        .footer {
            margin-top: 2.5rem;
            font-size: 0.85rem;
            color: var(--muted);
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
    <div class="blob-minimal purple"></div>

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
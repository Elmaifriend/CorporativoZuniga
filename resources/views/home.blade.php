<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Corporativo Zúñiga</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            /* Paleta corporativa */
            --bg: #ffffff;
            --surface: #ffffff;

            --primary: #003e65;
            --primary-dark: #002f4d;

            --blob-blue: #cfe4f1;

            --text: #003e65;
            --muted: #5f7d91;
            --border: #e5e7eb;
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
            min-height: 100vh;
            overflow: hidden;
        }

        /* ====== BLOBS SUAVES ====== */
        @keyframes blob {
            0%   { transform: translate(0, 0) scale(1); }
            33%  { transform: translate(20px, -30px) scale(1.05); }
            66%  { transform: translate(-15px, 25px) scale(0.95); }
            100% { transform: translate(0, 0) scale(1); }
        }

        .blob-minimal {
            position: fixed;
            z-index: 0;
            width: 720px;
            height: 720px;
            border-radius: 50%;
            filter: blur(240px);
            opacity: 0.2;
            animation: blob 14s infinite ease-in-out;
        }

        .blob-minimal.primary {
            background: var(--blob-blue);
            top: 10%;
            left: 5%;
        }

        .blob-minimal.secondary {
            background: var(--blob-blue);
            bottom: 5%;
            right: 10%;
            animation-delay: 4s;
        }

        /* ====== CONTENIDO ====== */
        .container {
            position: relative;
            z-index: 10;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
        }

        .card {
            background: var(--surface);
            border-radius: 20px;
            padding: 3.5rem 3rem;
            max-width: 520px;
            width: 100%;
            text-align: center;
            border: 1px solid var(--border);
            box-shadow: 0 20px 40px rgba(0, 62, 101, 0.08);
        }

        .logo {
            font-size: 2.4rem;
            font-weight: 700;
            letter-spacing: -0.03em;
            margin-bottom: 0.5rem;
            color: var(--primary);
        }

        .subtitle {
            color: var(--muted);
            margin-bottom: 2.5rem;
            font-size: 1.05rem;
        }

        /* ====== BOTÓN ====== */
        .enter-btn {
            display: inline-block;
            background: linear-gradient(
                135deg,
                var(--primary),
                var(--primary-dark)
            );
            color: #ffffff;
            font-size: 1.15rem;
            font-weight: 600;
            padding: 1.1rem 3rem;
            border-radius: 999px;
            text-decoration: none;
            transition: all 0.25s ease;
            box-shadow: 0 10px 25px rgba(0, 62, 101, 0.35);
        }

        .enter-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 16px 35px rgba(0, 62, 101, 0.45);
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

    <!-- Blobs decorativos -->
    <div class="blob-minimal primary"></div>
    <div class="blob-minimal secondary"></div>

    <!-- Contenido -->
    <div class="container">
        <div class="card">
            <div class="logo">Corporativo Zúñiga</div>
            <div class="subtitle">Soluciones empresariales modernas</div>

            <a href="/admin/login" class="enter-btn">Entrar</a>

            <div class="footer">
                © 2026 Corporativo Zúñiga. Todos los derechos reservados.
            </div>
        </div>
    </div>

</body>
</html>

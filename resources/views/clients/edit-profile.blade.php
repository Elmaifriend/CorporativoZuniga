<!DOCTYPE html>
<html>
<head>
    <title>Editar Perfil</title>

    <style>
        :root {
            --bg: #ffffff;
            --surface: #ffffff;
            --primary: #003e65;
            --primary-dark: #002f4d;
            --blob-blue: #cfe4f1;
            --text: #003e65;
            --muted: #5f7d91;
            --border: #e5e7eb;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--text);
            margin: 0;
        }

        .card {
            background: var(--surface);
            border-radius: 20px;
            padding: 3rem;
            max-width: 700px;
            width: 100%;
            border: 1px solid var(--border);
            box-shadow: 0 20px 40px rgba(0, 62, 101, 0.08);
        }

        .input {
            width: 100%;
            padding: 0.9rem 1rem;
            border-radius: 12px;
            border: 1px solid var(--border);
            margin-bottom: 1rem;
            font-size: 0.95rem;
            font-family: inherit;
        }

        .input:focus {
            outline: none;
            border-color: var(--primary);
        }

        .label {
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 0.4rem;
            display: block;
        }

        .section-title {
            margin-top: 2rem;
            margin-bottom: 1rem;
            font-size: 1.2rem;
            font-weight: 700;
        }

        .btn-primary {
            width: 100%;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            padding: 1rem;
            border-radius: 999px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            margin-top: 1rem;
        }

        .btn-primary:hover {
            opacity: 0.95;
        }

        .success-box {
            background: #e6f4ea;
            color: #1e7e34;
            padding: 1rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
        }
    </style>
</head>

<body>

<div style="min-height:100vh; display:flex; align-items:center; justify-content:center; padding:2rem;">

    <div class="card">

        <h2 style="font-size:1.8rem; font-weight:700; margin-bottom:0.5rem;">
            Editar Perfil
        </h2>

        <p style="color:var(--muted); margin-bottom:2rem;">
            Mantén tu información actualizada
        </p>

        @if(session('success'))
            <div class="success-box">
                ✅ {{ session('success') }}
            </div>
        @endif

        <form method="POST" enctype="multipart/form-data"
              action="{{ route('cliente.editar-perfil.update', $client) }}">
            @csrf

            <label class="label">Nombre completo</label>
            <input class="input" type="text" name="full_name"
                   value="{{ old('full_name', $client->full_name) }}">

            <label class="label">Teléfono</label>
            <input class="input" type="text" name="phone_number"
                   value="{{ old('phone_number', $client->phone_number) }}">

            <label class="label">Correo electrónico</label>
            <input class="input" type="email" name="email"
                   value="{{ old('email', $client->email) }}">

            <label class="label">Dirección</label>
            <textarea class="input" name="address">{{ old('address', $client->address) }}</textarea>

            <label class="label">Ocupación</label>
            <input class="input" type="text" name="occupation"
                   value="{{ old('occupation', $client->occupation) }}">

            <label class="label">Fecha de nacimiento</label>
            <input class="input" type="date" name="date_of_birth"
                   value="{{ old('date_of_birth', $client->date_of_birth) }}">

            <div class="section-title">
                Documentos
            </div>

            <label class="label">INE Frente</label>
            <input class="input" type="file" name="ine_front">

            <label class="label">INE Reverso</label>
            <input class="input" type="file" name="ine_back">

            <label class="label">Acta de Nacimiento</label>
            <input class="input" type="file" name="birth_certificate">

            <label class="label">Acta Matrimonio / Divorcio</label>
            <input class="input" type="file" name="marriage_document">

            <button type="submit" class="btn-primary">
                Guardar cambios
            </button>

        </form>

    </div>

</div>

</body>
</html>
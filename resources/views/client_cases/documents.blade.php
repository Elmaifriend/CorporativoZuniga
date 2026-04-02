<!DOCTYPE html>
<html>
<head>
    <title>Subir Documentos del Caso</title>

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
            box-sizing: border-box;
        }

        .label {
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 0.4rem;
            display: block;
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

        .btn-secondary {
            width: 100%;
            background: var(--blob-blue);
            color: var(--primary);
            padding: 0.8rem;
            border-radius: 999px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            margin-top: 0.5rem;
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
            Subir Documentos
        </h2>

        <p style="color:var(--muted); margin-bottom:2rem;">
            Caso: <strong>{{ $clientCase->case_name }}</strong><br>
            <span style="font-size: 0.85rem;">Cliente: {{ $clientCase->client->full_name }}</span>
        </p>

        @if(session('success'))
            <div class="success-box">
                ✅ {{ session('success') }}
            </div>
        @endif

        <form method="POST" enctype="multipart/form-data" action="{{ route('caso.documentos.store', $clientCase) }}">
            @csrf

            <div id="documents-wrapper">
                <div class="document-group">
                    <label class="label">Tipo de documento</label>
                    <select name="documents[0][type]" class="input" required>
                        <option value="">Seleccione una opción</option>
                        @foreach($documentTypes as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>

                    <label class="label">Archivo</label>
                    <input type="file" name="documents[0][file]" class="input" required>
                </div>
            </div>

            <button type="button" class="btn-secondary" onclick="addDocument()">
                + Agregar otro documento
            </button>

            <button type="submit" class="btn-primary">
                Enviar documentos
            </button>

        </form>
    </div>
</div>

<script>
let index = 1;

function addDocument() {
    const wrapper = document.getElementById('documents-wrapper');

    const html = `
        <div class="document-group" style="margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px dashed #ccc;">
            <label class="label">Tipo de documento</label>
            <select name="documents[${index}][type]" class="input" required>
                <option value="">Seleccione una opción</option>
                @foreach($documentTypes as $value => $label)
                    <option value="{{ $value }}">{{ $label }}</option>
                @endforeach
            </select>

            <label class="label">Archivo</label>
            <input type="file" name="documents[${index}][file]" class="input" required>
        </div>
    `;

    wrapper.insertAdjacentHTML('beforeend', html);
    index++;
}
</script>

</body>
</html>
<div>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
    :root {
        --brand-primary: #004c7a;
        --brand-primary-light: #00629e;
        --brand-primary-dark: #003a5e;
        --brand-gold: #d4af37;
        --brand-gold-light: #f3e5ab;
        --brand-gold-50: #fffaf0;
        --success: #10b981;
        --error: #ef4444;
        --text-main: #111827;
        --text-muted: #6b7280;
        --bg-page: #f8fafc;
        --border: #e2e8f0;
        --radius-xl: 20px;
        --radius-lg: 12px;
        --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
    }

    .appointment-container {
        font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 1rem;
        background-color: var(--bg-page);
        background-image: radial-gradient(circle at 0% 0%, rgba(0, 76, 122, 0.03) 0%, transparent 50%),
                          radial-gradient(circle at 100% 100%, rgba(212, 175, 55, 0.03) 0%, transparent 50%);
    }

    .card {
        background: white;
        border-radius: var(--radius-xl);
        padding: 3rem;
        max-width: 520px;
        width: 100%;
        border: 1px solid var(--border);
        box-shadow: var(--shadow-lg);
        position: relative;
    }

    @media (max-width: 640px) {
        .card {
            padding: 2rem 1.5rem;
        }
    }

    .card-header {
        margin-bottom: 2.5rem;
        text-align: center;
    }

    .card-header h2 {
        font-size: 1.875rem;
        font-weight: 800;
        color: var(--brand-primary);
        letter-spacing: -0.025em;
        margin-bottom: 0.5rem;
    }

    .card-header p {
        color: var(--text-muted);
        font-size: 1rem;
    }

    .input-group {
        margin-bottom: 1.25rem;
    }

    .label {
        display: block;
        font-size: 0.875rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: var(--text-main);
    }

    .input {
        width: 100%;
        padding: 0.875rem 1rem;
        border-radius: 12px;
        border: 1.5px solid var(--border);
        font-size: 0.95rem;
        font-family: inherit;
        transition: all 0.2s;
        background: #fcfcfc;
        color: var(--text-main);
        box-sizing: border-box;
    }

    .input:focus {
        outline: none;
        border-color: var(--brand-primary);
        background: white;
        box-shadow: 0 0 0 4px rgba(0, 76, 122, 0.1);
    }

    .input:disabled {
        background: #f3f4f6;
        color: #9ca3af;
        cursor: not-allowed;
    }

    textarea.input {
        min-height: 100px;
        resize: vertical;
    }

    .btn-primary {
        width: 100%;
        background: var(--brand-primary);
        color: white;
        padding: 1.125rem;
        border-radius: 999px;
        font-weight: 700;
        border: none;
        cursor: pointer;
        margin-top: 1.5rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        font-size: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
        box-shadow: 0 4px 12px rgba(0, 76, 122, 0.2);
    }

    .btn-primary:hover {
        background: var(--brand-primary-light);
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0, 76, 122, 0.3);
    }

    .success-box {
        background: #f0fdf4;
        color: #166534;
        padding: 1.25rem;
        border-radius: 16px;
        border: 1px solid #bbf7d0;
        text-align: center;
        font-weight: 600;
        animation: fadeIn 0.4s ease-out;
    }

    .info-box {
        background: var(--brand-gold-50);
        color: var(--brand-primary-dark);
        padding: 0.75rem 1rem;
        border-radius: 10px;
        border: 1px solid var(--brand-gold-light);
        margin-bottom: 1.5rem;
        font-size: 0.875rem;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        animation: slideDown 0.3s ease-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: scale(0.95); }
        to { opacity: 1; transform: scale(1); }
    }

    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<div class="appointment-container">
    <div class="card">
        <header class="card-header">
            <h2>Agenda tu cita</h2>
            <p>Ingresa tus datos para coordinar una reunión legal.</p>
        </header>

        @if($success)
            <div class="success-box">
                <div style="font-size: 2rem; margin-bottom: 0.5rem;">✅</div>
                Tu cita ha sido agendada con éxito.<br>
                Nos pondremos en contacto contigo pronto.
            </div>
        @else

            <div class="input-group">
                <label class="label">Teléfono de contacto</label>
                <input type="text"
                    class="input"
                    placeholder="Ej. 5512345678"
                    wire:model="phone_number"
                    wire:blur="checkPhone">
            </div>

            @if($isExisting)
                <div class="info-box">
                    <svg width="18" height="18" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    Perfil encontrado. Tus datos están protegidos.
                </div>
            @endif

            <div class="input-group">
                <label class="label">Nombre completo</label>
                <input type="text"
                    class="input"
                    placeholder="Como aparece en tu identificación"
                    wire:model="full_name"
                    @disabled($isExisting)>
            </div>

            <div class="input-group">
                <label class="label">Correo electrónico</label>
                <input type="email"
                    class="input"
                    placeholder="ejemplo@correo.com"
                    wire:model="email"
                    @disabled($isExisting)>
            </div>

            <div style="display: grid; grid-template-columns: 1.2fr 0.8fr; gap: 1rem;">
                <div class="input-group">
                    <label class="label">Fecha</label>
                    <input type="date"
                        class="input"
                        wire:model="date">
                </div>

                <div class="input-group">
                    <label class="label">Hora</label>
                    <input type="time"
                        class="input"
                        wire:model="time">
                </div>
            </div>

            <div class="input-group">
                <label class="label">Notas adicionales (opcional)</label>
                <textarea
                    class="input"
                    placeholder="Describe brevemente el motivo de tu consulta..."
                    wire:model="notes"></textarea>
            </div>

            <button class="btn-primary"
                wire:click="confirmAppointment">
                Confirmar y Agendar
            </button>

        @endif
    </div>
</div>
</div>

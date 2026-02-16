<div>

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
}

.card {
    background: var(--surface);
    border-radius: 20px;
    padding: 3rem;
    max-width: 520px;
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
}

.input:focus {
    outline: none;
    border-color: var(--primary);
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
}

.btn-primary:hover {
    opacity: 0.95;
}

.success-box {
    background: #e6f4ea;
    color: #1e7e34;
    padding: 1rem;
    border-radius: 12px;
    margin-top: 1rem;
}
</style>

<div style="min-height:100vh; display:flex; align-items:center; justify-content:center; padding:2rem;">

    <div class="card">

        <h2 style="font-size:1.8rem; font-weight:700; margin-bottom:0.5rem;">
            Agenda tu cita
        </h2>

        <p style="color:var(--muted); margin-bottom:2rem;">
            Ingresa tu teléfono para continuar
        </p>

        @if($success)
            <div class="success-box">
                ✅ Tu cita fue agendada correctamente.
            </div>
        @else

        <input type="text"
            class="input"
            placeholder="Teléfono"
            wire:model="phone_number"
            wire:blur="checkPhone">

        @if($isExisting)
            <div style="color:green; margin-bottom:1rem;">
                ✅ Perfil encontrado. Tus datos están protegidos.
            </div>
        @endif

        <input type="text"
            class="input"
            placeholder="Nombre completo"
            wire:model="full_name"
            @disabled($isExisting)>

        <input type="email"
            class="input"
            placeholder="Correo electrónico"
            wire:model="email"
            @disabled($isExisting)>

        <input type="date"
            class="input"
            wire:model="date">

        <input type="time"
            class="input"
            wire:model="time">

        <textarea
            class="input"
            placeholder="Notas adicionales (opcional)"
            wire:model="notes"></textarea>

        <button class="btn-primary"
            wire:click="confirmAppointment">
            Confirmar cita
        </button>


        @endif

    </div>

</div>
</div>

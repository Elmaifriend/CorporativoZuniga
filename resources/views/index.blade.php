<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Legal - El sistema operativo para despachos</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <link href="https://cdn.boxicons.com/3.0.7/fonts/basic/boxicons.min.css" rel="stylesheet">

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="overflow-x-hidden bg-gray-50">
    <nav class="fixed z-50 w-full border-b border-gray-100 bg-white/80 backdrop-blur-md transition-all duration-300"
        id="navbar">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-20 items-center justify-between">
                <a class="flex shrink-0 cursor-pointer items-center gap-2" href="#hero">
                    <div class="bg-brand flex items-center justify-center rounded-full p-2 text-white">
                        <i class="bx bxs-landmark text-2xl"></i>
                    </div>
                    <span class="font-display text-brand text-2xl font-bold tracking-tight">Legal</span>
                </a>

                <div class="hidden items-center space-x-8 md:flex">
                    <a href="#features"
                        class="hover:text-brand font-medium text-gray-600 transition-colors">Funcionalidades</a>
                    <a href="#demo" class="hover:text-brand font-medium text-gray-600 transition-colors">Demo</a>
                    <a href="#founders" class="hover:text-brand font-medium text-gray-600 transition-colors">Oferta</a>
                    <a href="#app" class="hover:text-brand font-medium text-gray-600 transition-colors">App</a>
                    <a href="#faq" class="hover:text-brand font-medium text-gray-600 transition-colors">FAQ</a>
                    <a href="#contact" class="hover:text-brand font-medium text-gray-600 transition-colors">Contacto</a>
                </div>

                <div class="flex items-center md:hidden">
                    <button id="mobile-menu-btn" class="hover:text-brand text-gray-600 focus:outline-none">
                        <i class="bx bx-menu text-3xl"></i>
                    </button>
                </div>
            </div>
        </div>

        <div id="mobile-menu" class="absolute hidden w-full border-t border-gray-100 bg-white shadow-lg md:hidden">
            <div class="divide-brand/5 flex flex-col divide-y px-4 py-4">
                <a href="#features"
                    class="hover:text-brand py-4 font-medium text-gray-700 transition-colors">Funcionalidades</a>
                <a href="#demo" class="hover:text-brand py-4 font-medium text-gray-700 transition-colors">Demo</a>
                <a href="#founders" class="hover:text-brand py-4 font-medium text-gray-700 transition-colors">Oferta</a>
                <a href="#app" class="hover:text-brand py-4 font-medium text-gray-700 transition-colors">App</a>
                <a href="#faq" class="hover:text-brand py-4 font-medium text-gray-700 transition-colors">FAQ</a>
                <a href="#contact"
                    class="hover:text-brand py-4 font-medium text-gray-700 transition-colors">Contacto</a>
            </div>
        </div>
    </nav>

    <section class="relative flex items-center justify-center overflow-hidden bg-gray-50 py-32 lg:min-h-screen"
        id="hero">
        <div class="absolute inset-0 z-0 opacity-[0.4]"
            style="background-image: linear-gradient(#cbd5e1 1px, transparent 1px), linear-gradient(to right, #cbd5e1 1px, transparent 1px); background-size: 40px 40px; mask-image: linear-gradient(to bottom, black 40%, transparent 100%); -webkit-mask-image: linear-gradient(to bottom, black 40%, transparent 100%);">
        </div>

        <div class="relative z-10 max-w-7xl px-4 sm:px-8 lg:px-12">
            <div class="grid grid-cols-1 items-center gap-12 lg:grid-cols-2">
                <div class="fade-in-up">
                    <h1 class="mb-6 text-4xl font-extrabold leading-tight text-gray-900 md:text-5xl lg:text-6xl">
                        Moderniza tu despacho con <span class="text-brand">Legal</span>
                    </h1>
                    <p class="mb-8 max-w-lg text-lg leading-relaxed text-gray-600">
                        El sistema operativo todo-en-uno para despachos legales que quieren crecer. Gestiona
                        expedientes, clientes y facturación en un solo lugar
                    </p>
                    <div class="flex flex-col gap-4 sm:flex-row">
                        <a
                            href="#contact"
                            class="bg-brand hover:bg-brand-dark shadow-brand/30 hover:shadow-brand/50 flex transform cursor-pointer items-center justify-center gap-1 rounded-lg px-8 py-4 text-lg font-bold text-white shadow-xl transition-all hover:-translate-y-1">
                            Comenzar ahora <i class="bx bxs-chevron-right text-2xl"></i>
                        </a>
                        <a
                            href="#demo"
                            class="flex cursor-pointer items-center justify-center gap-1 rounded-lg border border-gray-200 bg-white px-8 py-4 text-lg font-bold text-gray-700 transition-all hover:bg-gray-50 hover:shadow-lg">
                            <i class="bx bx-play-circle text-brand text-2xl"></i> Ver demo
                        </a>
                    </div>
                </div>

                <div class="fade-in-up relative flex justify-center delay-200 lg:justify-end">
                    <div
                        class="glass-card shadow-soft relative z-20 w-full max-w-xs transform rounded-2xl border border-white/50 bg-white/60 p-10 text-center backdrop-blur-xl transition-transform duration-500 hover:scale-[1.02]">
                        <div class="bg-brand-50 mb-4 inline-block rounded-2xl p-4">
                            <i class="bx bxs-bar-chart-big text-brand text-6xl"></i>
                        </div>
                        <div class="mb-2 text-5xl font-extrabold tracking-tight text-gray-900">+30%</div>
                        <p class="text-sm font-medium uppercase tracking-widest text-gray-500">Ingresos Mensuales</p>

                        <div class="top-11/12 absolute lg:-right-6 right-4 flex animate-bounce items-center gap-3 rounded-xl border border-gray-100 bg-white p-3 shadow-lg"
                            style="animation-duration: 6s;">
                            <div
                                class="flex items-center justify-center rounded-full bg-green-100 p-1.5 text-green-600">
                                <i class="bx bxs-trending-up text-2xl"></i>
                            </div>
                            <div class="text-left">
                                <p class="text-[10px] font-bold uppercase text-gray-400">Eficiencia</p>
                                <p class="text-sm font-bold text-gray-800">Alta</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-brand relative overflow-hidden py-16 text-white" id="benefits">
        <div class="absolute inset-0 opacity-10"
            style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 20px 20px;"></div>

        <div class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="divide-brand-light/30 grid grid-cols-2 gap-8 divide-x text-center md:grid-cols-4">
                <div class="p-4">
                    <div class="font-display mb-2 text-4xl font-extrabold md:text-5xl">+30%</div>
                    <p class="text-brand-100 text-sm font-medium md:text-base">En horas facturables</p>
                </div>
                <div class="p-4">
                    <div class="font-display mb-2 text-4xl font-extrabold md:text-5xl">0</div>
                    <p class="text-brand-100 text-sm font-medium md:text-base">Plazos judiciales perdidos</p>
                </div>
                <div class="p-4">
                    <div class="font-display mb-2 text-4xl font-extrabold md:text-5xl">40%</div>
                    <p class="text-brand-100 text-sm font-medium md:text-base">Menos carga operativa</p>
                </div>
                <div class="border-none p-4">
                    <div class="font-display mb-2 text-4xl font-extrabold md:text-5xl">24/7</div>
                    <p class="text-brand-100 text-sm font-medium md:text-base">Atención para clientes</p>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-white py-24" id="features">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mx-auto mb-16 max-w-3xl text-center">
                <span class="text-brand text-sm font-bold uppercase tracking-wider">Funcionalidades</span>
                <h2 class="mb-4 mt-2 text-3xl font-bold text-gray-900 md:text-4xl">Todo lo que tu despacho necesita
                </h2>
                <p class="text-lg text-gray-600">Herramientas esenciales para el abogado moderno</p>
            </div>

            <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
                <div
                    class="hover:shadow-card group rounded-lg border border-transparent bg-gray-50 p-8 transition-all duration-300 hover:border-gray-100 hover:bg-white">
                    <div
                        class="bg-brand mb-6 flex h-12 w-12 items-center justify-center rounded-lg text-white transition-transform group-hover:scale-110">
                        <i class="bx bxs-calendar-check text-2xl"></i>
                    </div>
                    <h3 class="mb-2 text-lg font-bold text-gray-900">Citas automáticas 24/7</h3>
                    <p class="text-sm text-gray-600">Agenda sincronizada con clientes y juzgados en tiempo real</p>
                </div>
                <div
                    class="hover:shadow-card group rounded-lg border border-transparent bg-gray-50 p-8 transition-all duration-300 hover:border-gray-100 hover:bg-white">
                    <div
                        class="bg-brand mb-6 flex h-12 w-12 items-center justify-center rounded-lg text-white transition-transform group-hover:scale-110">
                        <i class="bx bxs-sparkles-alt text-2xl"></i>
                    </div>
                    <h3 class="mb-2 text-lg font-bold text-gray-900">Automatización con IA</h3>
                    <p class="text-sm text-gray-600">Redacción y análisis de documentos asistido por inteligencia
                        artificial</p>
                </div>
                <div
                    class="hover:shadow-card group rounded-lg border border-transparent bg-gray-50 p-8 transition-all duration-300 hover:border-gray-100 hover:bg-white">
                    <div
                        class="bg-brand mb-6 flex h-12 w-12 items-center justify-center rounded-lg text-white transition-transform group-hover:scale-110">
                        <i class="bx bxs-folder text-2xl"></i>
                    </div>
                    <h3 class="mb-2 text-lg font-bold text-gray-900">Expedientes digitales</h3>
                    <p class="text-sm text-gray-600">Acceso instantáneo a todos tus archivos desde cualquier lugar</p>
                </div>
                <div
                    class="hover:shadow-card group rounded-lg border border-transparent bg-gray-50 p-8 transition-all duration-300 hover:border-gray-100 hover:bg-white">
                    <div
                        class="bg-brand mb-6 flex h-12 w-12 items-center justify-center rounded-lg text-white transition-transform group-hover:scale-110">
                        <i class="bx bxs-bell-ring text-2xl"></i>
                    </div>
                    <h3 class="mb-2 text-lg font-bold text-gray-900">Alertas de plazos</h3>
                    <p class="text-sm text-gray-600">Notificaciones críticas para que nunca pierdas un término legal
                    </p>
                </div>
                <div
                    class="hover:shadow-card group rounded-lg border border-transparent bg-gray-50 p-8 transition-all duration-300 hover:border-gray-100 hover:bg-white">
                    <div
                        class="bg-brand mb-6 flex h-12 w-12 items-center justify-center rounded-lg text-white transition-transform group-hover:scale-110">
                        <i class="bx bxs-user-circle text-2xl"></i>
                    </div>
                    <h3 class="mb-2 text-lg font-bold text-gray-900">Clientes 360°</h3>
                    <p class="text-sm text-gray-600">Historial completo, pagos y comunicaciones en un solo perfil</p>
                </div>
                <div
                    class="hover:shadow-card group rounded-lg border border-transparent bg-gray-50 p-8 transition-all duration-300 hover:border-gray-100 hover:bg-white">
                    <div
                        class="bg-brand mb-6 flex h-12 w-12 items-center justify-center rounded-lg text-white transition-transform group-hover:scale-110">
                        <i class="bx bxs-check-shield text-2xl"></i>
                    </div>
                    <h3 class="mb-2 text-lg font-bold text-gray-900">Documentos protegidos</h3>
                    <p class="text-sm text-gray-600">Encriptación bancaria para la máxima confidencialidad</p>
                </div>
            </div>
        </div>
    </section>

    <section class="relative overflow-hidden bg-gray-900 py-20 text-white" id="admin-panel">
        <div class="absolute inset-0 opacity-20"
            style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 30px 30px;"></div>

        <div class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-12 text-center">
                <span class="text-brand-light text-sm font-bold uppercase tracking-wider">Panel de
                    Administración</span>
                <h2 class="mt-2 text-3xl font-bold md:text-5xl">Tu despacho, bajo control</h2>
                <p class="mx-auto mt-4 max-w-2xl text-lg text-gray-400">Una interfaz diseñada para la productividad en
                    pantallas grandes. Analiza métricas, gestiona usuarios y visualiza expedientes completos</p>
            </div>

            <div class="fade-in-up flex justify-center">
                <img class="relative w-full max-w-2xl" src="{{ asset('images/computer.png') }}" />
            </div>
        </div>
    </section>

    <section class="bg-gray-50 py-32">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col items-center gap-16 pt-12 lg:flex-row">
                <div class="lg:w-1/2">
                    <div
                        class="mb-6 inline-flex items-center gap-2 rounded-full border border-gray-200 bg-white px-3 py-1 text-xs font-bold uppercase text-emerald-700">
                        <span class="h-2 w-2 animate-pulse rounded-full bg-emerald-700"></span>
                        Acceso Remoto
                    </div>
                    <h2 class="mb-6 text-3xl font-bold text-gray-900 md:text-4xl">Productividad donde la necesites</h2>
                    <p class="mb-8 text-lg text-gray-600">
                        La versión portátil de Legal se adapta a tu laptop sin perder funcionalidad. Ya sea en la
                        cafetería, en casa o en una sala de juntas, tienes toda la potencia de la oficina contigo
                    </p>
                </div>

                <div class="w-full lg:w-1/2">
                    <img src="{{ asset('images/laptop.png') }}" alt="Vista Laptop"
                        class="h-full w-full rounded-t-lg object-cover">
                </div>
            </div>
        </div>
    </section>

    <section class="relative overflow-hidden bg-white py-24" id="demo">
        <div
            class="bg-brand-light absolute left-1/2 top-1/2 -z-10 h-[600px] w-[600px] -translate-x-1/2 -translate-y-1/2 rounded-full opacity-10 blur-[120px]">
        </div>

        <div class="mx-auto max-w-5xl px-4 text-center sm:px-6 lg:px-8">
            <div class="mb-10">
                <span class="text-brand text-sm font-bold uppercase tracking-wider">Demo</span>
                <h2 class="mb-4 mt-2 text-3xl font-bold text-gray-900 md:text-4xl">Mira cómo Legal transforma tu día a
                    día</h2>
                <p class="mx-auto max-w-2xl text-lg text-gray-600">En menos de 3 minutos, descubre por qué más de 50
                    despachos han migrado sus operaciones a nuestra plataforma</p>
            </div>

            <div
                class="group relative aspect-video w-full cursor-pointer overflow-hidden rounded-2xl border border-gray-200 bg-gray-900 shadow-2xl">
                <img src="{{ asset('images/panel.png') }}" alt="Video Thumbnail"
                    class="h-full w-full object-cover opacity-80 transition-opacity duration-300 group-hover:opacity-60">

                <div class="absolute inset-0 flex items-center justify-center">
                    <div
                        class="flex h-20 w-20 items-center justify-center rounded-full border border-white/50 bg-white/20 backdrop-blur-sm transition-transform duration-300 group-hover:scale-110">
                        <div class="bg-brand flex h-14 w-14 items-center justify-center rounded-full shadow-lg">
                            <i class="bx bxs-play ml-1 text-4xl text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="relative overflow-hidden bg-white py-24">
        <div class="absolute inset-0 opacity-5"
            style="background-image: radial-gradient(#004C7A 1px, transparent 1px); background-size: 20px 20px;"></div>

        <div class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-16 text-center">
                <span class="text-brand text-sm font-bold uppercase tracking-wider">Proceso</span>
                <h2 class="mt-2 text-3xl font-bold text-gray-900 md:text-4xl">¿Cómo empiezo?</h2>
            </div>

            <div class="relative">
                <div
                    class="absolute left-0 top-1/2 -z-10 hidden h-2 w-full -translate-y-1/2 rounded-full bg-gray-200 md:block">
                </div>

                <div class="grid grid-cols-1 gap-16 md:grid-cols-3 md:gap-8">
                    <div
                        class="relative transform rounded-xl border border-gray-100 bg-white p-8 shadow-lg transition-transform duration-300 hover:-translate-y-2">
                        <div
                            class="bg-brand absolute -top-8 left-1/2 flex size-16 -translate-x-1/2 items-center justify-center rounded-full border-4 border-white text-2xl font-bold text-white shadow-md">
                            1</div>
                        <h3 class="mt-4 text-center text-xl font-bold text-gray-900">Registro Rápido</h3>
                        <p class="mt-2 text-center text-sm text-gray-600">Crea tu cuenta en 2 minutos sin tarjeta de
                            crédito</p>
                    </div>

                    <div
                        class="relative transform rounded-xl border border-gray-100 bg-white p-8 shadow-lg transition-transform duration-300 hover:-translate-y-2">
                        <div
                            class="bg-brand absolute -top-8 left-1/2 flex size-16 -translate-x-1/2 items-center justify-center rounded-full border-4 border-white text-2xl font-bold text-white shadow-md">
                            2</div>
                        <h3 class="mt-4 text-center text-xl font-bold text-gray-900">Migración Simple</h3>
                        <p class="mt-2 text-center text-sm text-gray-600">Importa tus clientes y expedientes actuales
                            con un clic</p>
                    </div>

                    <div
                        class="relative transform rounded-xl border border-gray-100 bg-white p-8 shadow-lg transition-transform duration-300 hover:-translate-y-2">
                        <div
                            class="bg-brand absolute -top-8 left-1/2 flex size-16 -translate-x-1/2 items-center justify-center rounded-full border-4 border-white text-2xl font-bold text-white shadow-md">
                            3</div>
                        <h3 class="mt-4 text-center text-xl font-bold text-gray-900">Control Total</h3>
                        <p class="mt-2 text-center text-sm text-gray-600">Empieza a gestionar tu despacho desde
                            cualquier lugar</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="relative overflow-hidden bg-gray-50 py-24" id="founders">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
            <div class="border-gold shadow-gold relative overflow-hidden rounded-2xl border-2 bg-white p-8 md:p-12">
                <div
                    class="bg-gold absolute right-0 top-0 z-10 translate-x-10 translate-y-5 rotate-45 transform px-10 py-2 font-bold text-white shadow-sm">
                    LIMITADO
                </div>

                <div class="flex flex-col items-center gap-12 lg:flex-row">
                    <div class="lg:w-2/3">
                        <div class="mb-6 flex items-center gap-3">
                            <i class="bx bxs-crown text-gold text-4xl"></i>
                            <span class="text-gold text-sm font-bold uppercase tracking-wider">Programa
                                Fundadores</span>
                        </div>
                        <h2 class="mb-6 text-3xl font-bold text-gray-900 md:text-4xl">Sé dueño de tu tecnología, no la
                            rentes</h2>

                        <div class="space-y-4 text-lg text-gray-600">
                            <p>
                                Para nuestros primeros
                                <span class="bg-gold-light rounded px-2 font-bold text-gray-900">10 clientes</span>,
                                ofrecemos un modelo único de financiamiento
                            </p>
                            <ul class="space-y-3">
                                <li class="flex items-start gap-3">
                                    <i class="bx bxs-check-circle text-gold mt-1 text-xl"></i>
                                    <span>Paga tu sistema mensualmente durante <strong>2 años</strong></span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <i class="bx bxs-check-circle text-gold mt-1 text-xl"></i>
                                    <span>Al finalizar el plazo, <strong>el software es 100% tuyo</strong></span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <i class="bx bxs-check-circle text-gold mt-1 text-xl"></i>
                                    <span>Olvídate de pagar rentas mensuales de por vida</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="rounded-xl border border-gray-100 bg-gray-50 p-6 text-center lg:w-1/3">
                        <p class="mb-2 font-medium text-gray-500">Lugares Restantes</p>
                        <div class="mb-2 text-6xl font-extrabold text-gray-900">0<span
                                class="text-gray-300">/10</span></div>
                        <div class="mb-6 h-2.5 w-full rounded-full bg-gray-200">
                            <div class="bg-gold h-2.5 rounded-full" style="width: 0%"></div>
                        </div>
                        <a
                            class="flex w-full cursor-pointer items-center justify-center gap-2 rounded-lg bg-gray-900 px-6 py-4 font-bold text-white transition-colors hover:bg-gray-800">
                            Aplicar ahora <i class="bx bx-right-arrow-alt"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="overflow-hidden bg-white py-24" id="app">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mx-auto mb-16 max-w-3xl text-center">
                <span class="text-brand text-sm font-bold uppercase tracking-wider">Movilidad</span>
                <h2 class="mb-4 mt-2 text-3xl font-bold text-gray-900 md:text-4xl">Lleva tu despacho contigo</h2>
            </div>

            <div class="mb-12 flex flex-wrap items-center justify-center gap-4 md:gap-8 lg:flex-nowrap">
                <div
                    class="phone-frame w-[240px] transform transition-all duration-500 hover:z-20 hover:scale-105 lg:translate-y-8 lg:-rotate-6">
                    <div class="notch"></div>
                    <img src="{{ asset('images/app-2.png') }}"
                        class="h-full w-full object-cover">
                </div>

                <div
                    class="phone-frame z-10 w-[260px] shadow-2xl transition-all duration-500 hover:scale-105">
                    <div class="notch"></div>
                    <img src="{{ asset('images/app-1.png') }}"
                        class="h-full w-full object-cover">
                </div>

                <div
                    class="phone-frame w-[240px] transform transition-all duration-500 hover:z-20 hover:scale-105 lg:translate-y-8 lg:rotate-6">
                    <div class="notch"></div>
                    <img src="{{ asset('images/app-3.png') }}"
                        class="h-full w-full object-cover">
                </div>
            </div>
        </div>
    </section>

    <section class="bg-gray-50 py-24" id="faq">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            <h2 class="mb-12 text-center text-3xl font-bold">Preguntas Frecuentes</h2>
            <div class="space-y-6">
                <details
                    class="group cursor-pointer rounded-xl border border-transparent bg-white p-6 transition-all duration-300 hover:shadow-lg hover:shadow-black/5">
                    <summary class="flex select-none items-center justify-between font-bold text-gray-900">
                        <p>
                            ¿Cómo funciona la propiedad del sistema para fundadores?
                        </p>
                        <span
                            class="group-hover:bg-brand-50 h- flex rounded-full bg-white p-1 transition-all duration-300 group-open:rotate-180"><i
                                class='bx bx-chevron-down text-brand text-xl'></i></span>
                    </summary>
                    <p class="mt-4 leading-relaxed text-gray-600">
                        La propiedad del sistema fundadores funciona montando el sistema Legal en sus servidores, por lo
                        que el sistema es completamente suyo y mantienen control total sobre la infraestructura y los
                        datos.
                    </p>
                </details>

                <details
                    class="group cursor-pointer rounded-xl border border-transparent bg-white p-6 transition-all duration-300 hover:shadow-lg hover:shadow-black/5">
                    <summary class="flex select-none items-center justify-between font-bold text-gray-900">
                        <p>
                            ¿Mis datos están seguros?
                        </p>
                        <span
                            class="group-hover:bg-brand-50 h- flex rounded-full bg-white p-1 transition-all duration-300 group-open:rotate-180"><i
                                class='bx bx-chevron-down text-brand text-xl'></i></span>
                    </summary>
                    <p class="mt-4 leading-relaxed text-gray-600">
                        Sí, utilizamos encriptación AES-256 de punta a punta. Nadie fuera de tu despacho tiene acceso a
                        tus expedientes ni a tu información confidencial.
                    </p>
                </details>

                <details
                    class="group cursor-pointer rounded-xl border border-transparent bg-white p-6 transition-all duration-300 hover:shadow-lg hover:shadow-black/5">
                    <summary class="flex select-none items-center justify-between font-bold text-gray-900">
                        <p>
                            ¿Cuánto tiempo tarda la implementación?
                        </p>
                        <span
                            class="group-hover:bg-brand-50 h- flex rounded-full bg-white p-1 transition-all duration-300 group-open:rotate-180"><i
                                class='bx bx-chevron-down text-brand text-xl'></i></span>
                    </summary>
                    <p class="mt-4 leading-relaxed text-gray-600">
                        Nuestro equipo técnico realiza la instalación y configuración inicial en su infraestructura.
                        Generalmente, el sistema está listo para usarse en menos de 48 horas hábiles tras la firma del
                        contrato.
                    </p>
                </details>

                <details
                    class="group cursor-pointer rounded-xl border border-transparent bg-white p-6 transition-all duration-300 hover:shadow-lg hover:shadow-black/5">
                    <summary class="flex select-none items-center justify-between font-bold text-gray-900">
                        <p>
                            ¿Puedo cancelar en cualquier momento?
                        </p>
                        <span
                            class="group-hover:bg-brand-50 h- flex rounded-full bg-white p-1 transition-all duration-300 group-open:rotate-180"><i
                                class='bx bx-chevron-down text-brand text-xl'></i></span>
                    </summary>
                    <p class="mt-4 leading-relaxed text-gray-600">
                        Para el plan de fundadores existe un contrato de financiamiento por el periodo acordado. Para
                        planes de suscripción regulares, la cancelación es libre sin plazos forzosos.
                    </p>
                </details>

                <details
                    class="group cursor-pointer rounded-xl border border-transparent bg-white p-6 transition-all duration-300 hover:shadow-lg hover:shadow-black/5">
                    <summary class="flex select-none items-center justify-between font-bold text-gray-900">
                        <p>
                            ¿El sistema se actualiza con nuevas leyes?
                        </p>
                        <span
                            class="group-hover:bg-brand-50 flex rounded-full bg-white p-1 transition-all duration-300 group-open:rotate-180"><i
                                class='bx bx-chevron-down text-brand text-xl'></i></span>
                    </summary>
                    <p class="mt-4 leading-relaxed text-gray-600">
                        Sí. Nosotros nos encargamos de desarrollar y subir las actualizaciones necesarias para mejorar
                        el sistema y adaptarlo a nuevos requerimientos legales, garantizando que siempre tengas la
                        versión más potente.
                    </p>
                </details>
            </div>
        </div>
    </section>

    <section class="bg-white py-24" id="contact">
        <div class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div
                class="flex flex-col overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-2xl lg:flex-row">

                <div class="bg-brand relative flex flex-col justify-between overflow-hidden p-12 text-white lg:w-2/5">
                    <div class="relative z-10">
                        <h2 class="font-display mb-4 text-3xl font-bold">¿Listo para escalar tu despacho?</h2>

                        <div class="space-y-4">
                            <div class="flex items-center gap-4">
                                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-white/10">
                                    <i class="bx bxs-clock text-xl"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-bold">Sesión de 60 o 30 minutos</p>
                                    <p class="text-brand-100 text-xs">Sin compromiso de compra</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
                                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-white/10">
                                    <i class="bx bxs-laptop text-xl"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-bold">Demostración en vivo</p>
                                    <p class="text-brand-100 text-xs">Verás el software real en acción</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="translate-x-2/12 absolute bottom-0 right-0 hidden translate-y-1/4 transform lg:block">
                        <i class="bx bxs-law text-[400px] text-white opacity-10"></i>
                    </div>
                </div>

                <div class="bg-white p-8 lg:w-3/5 lg:p-12">
                    <h3 class="mb-6 text-xl font-bold text-gray-900">Completa tus datos</h3>
                    <form class="space-y-6">
                        <div>
                            <label class="mb-2 block text-sm font-medium text-gray-700">Nombre Completo</label>
                            <input type="text"
                                class="focus:border-brand focus:ring-brand/20 w-full rounded-lg border border-gray-200 bg-gray-50 px-4 py-3 outline-none transition-all focus:ring-2"
                                placeholder="Juan Pérez">
                        </div>

                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div>
                                <label class="mb-2 block text-sm font-medium text-gray-700">WhatsApp</label>
                                <input type="tel"
                                    class="focus:border-brand focus:ring-brand/20 w-full rounded-lg border border-gray-200 bg-gray-50 px-4 py-3 outline-none transition-all focus:ring-2"
                                    placeholder="+52 664...">
                            </div>
                            <div>
                                <label class="mb-2 block text-sm font-medium text-gray-700">Correo Electrónico</label>
                                <input type="email"
                                    class="focus:border-brand focus:ring-brand/20 w-full rounded-lg border border-gray-200 bg-gray-50 px-4 py-3 outline-none transition-all focus:ring-2"
                                    placeholder="juan@bufete.com">
                            </div>
                        </div>


                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div>
                                <label class="mb-2 block text-sm font-medium text-gray-700">Número de Abogados</label>
                                <div class="relative">
                                    <select
                                        class="focus:border-brand focus:ring-brand/20 w-full cursor-pointer appearance-none rounded-lg border border-gray-200 bg-gray-50 px-4 py-3 text-gray-600 outline-none transition-all focus:ring-2">
                                        <option value="" disabled selected>Selecciona una opción</option>
                                        <option value="1-5">1 - 5 Abogados</option>
                                        <option value="6-15">6 - 15 Abogados</option>
                                        <option value="16-50">16 - 50 Abogados</option>
                                        <option value="50+">Más de 50 Abogados</option>
                                    </select>
                                    <i
                                        class='bx bx-chevron-down pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-gray-400'></i>
                                </div>
                            </div>

                            <div>
                                <label class="mb-2 block text-sm font-medium text-gray-700">Facturación Mensual
                                    Aprox.</label>
                                <div class="relative">
                                    <select
                                        class="focus:border-brand focus:ring-brand/20 w-full cursor-pointer appearance-none rounded-lg border border-gray-200 bg-gray-50 px-4 py-3 text-gray-600 outline-none transition-all focus:ring-2">
                                        <option value="" disabled selected>Selecciona un rango</option>
                                        <option value="<50k">Menos de $50,000 MXN</option>
                                        <option value="50k-150k">$50,000 - $150,000 MXN</option>
                                        <option value="150k-500k">$150,000 - $500,000 MXN</option>
                                        <option value="500k+">Más de $500,000 MXN</option>
                                    </select>
                                    <i
                                        class='bx bx-chevron-down pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-gray-400'></i>
                                </div>
                            </div>
                        </div>

                        <button type="button"
                            class="bg-brand hover:bg-brand-dark shadow-brand/20 flex w-full transform cursor-pointer items-center justify-center gap-2 rounded-lg py-4 text-sm font-bold text-white shadow-lg transition-all hover:-translate-y-1 md:text-base">
                            Solicitar Demo <i class="bx bxs-send"></i>
                        </button>

                        <p class="mt-4 text-center text-xs text-gray-400">
                            Tus datos están protegidos bajo nuestra política de privacidad. No compartimos información
                            con terceros.
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-gray-900 pb-8 pt-16 text-white">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-12 grid grid-cols-1 gap-12 md:grid-cols-4">
                <div class="col-span-1 mb-6 flex items-center gap-2">
                    <a class="flex shrink-0 cursor-pointer items-center gap-2" href="#hero">
                        <div class="bg-brand flex items-center justify-center rounded-full p-2 text-white">
                            <i class="bx bxs-landmark text-2xl"></i>
                        </div>
                        <span class="font-display text-2xl font-bold tracking-tight text-white">Legal</span>
                    </a>
                </div>
                <div>
                    <h4 class="mb-4 font-bold">Producto</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="#features" class="hover:text-white">Funcionalidades</a></li>
                        <li><a href="#founders" class="hover:text-white">Programa Fundadores</a></li>
                        <li><a href="#faq" class="hover:text-white">Preguntas</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="mb-4 font-bold">Contacto</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li>+52 664 267 7530</li>
                        <li>soporte@bytebytestudio.com</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8 text-center text-sm text-gray-500">
                © {{ now()->year }} Legal System. Todos los derechos reservados.
            </div>
        </div>
    </footer>

    <script>
        window.addEventListener("scroll", function() {
            const navbar = document.getElementById("navbar");
            if (window.scrollY > 20) {
                navbar.classList.add("shadow-sm");
            } else {
                navbar.classList.remove("shadow-sm");
            }
        });

        document.getElementById("mobile-menu-btn").addEventListener("click", () => {
            document.getElementById("mobile-menu").classList.toggle("hidden");
        });
    </script>
</body>

</html>

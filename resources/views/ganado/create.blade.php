<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Animal - Agronex</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .required-label::after {
            content: " *";
            color: #dc3545;
        }
        .card {
            border: none;
            border-radius: 15px;
        }
        .form-control:focus, .form-select:focus {
            border-color: #198754;
            box-shadow: 0 0 0 0.2rem rgba(25, 135, 84, 0.25);
        }
        .estado-badge {
            font-size: 0.75em;
            padding: 0.35em 0.65em;
        }
    </style>
</head>
<body class="bg-light">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-success shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('home') }}">
                <i class="fas fa-tractor"></i> Agronex
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="{{ route('ganado.index') }}">
                    <i class="fas fa-arrow-left"></i> Volver al Listado
                </a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg">
                    <div class="card-header bg-success text-white py-3">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-cow fa-2x me-3"></i>
                            <div>
                                <h4 class="mb-0">+ Agregar Animal</h4>
                                <small class="opacity-75">Complete todos los campos requeridos (*)</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-body p-4">
                        <!-- Alertas -->
                        @if($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show">
                                <h5 class="alert-heading">
                                    <i class="fas fa-exclamation-triangle"></i> Errores de validación
                                </h5>
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <!-- Formulario -->
                        <form action="{{ route('ganado.store') }}" method="POST" id="animalForm">
                            @csrf
                            
                            <!-- Información Básica -->
                            <h5 class="text-success mb-3">
                                <i class="fas fa-info-circle"></i> Información Básica
                            </h5>
                            
                            <div class="row">
                                <!-- Identificador -->
                                <div class="col-md-6 mb-3">
                                    <label for="identificador" class="form-label required-label">
                                        <i class="fas fa-tag"></i> Identificador
                                    </label>
                                    <input type="text" class="form-control @error('identificador') is-invalid @enderror" 
                                           id="identificador" name="identificador" 
                                           value="{{ old('identificador') }}" 
                                           placeholder="Ej: ANI-001, Vaca-12"
                                           required maxlength="50">
                                    @error('identificador')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Raza -->
                                <div class="col-md-6 mb-3">
                                    <label for="raza" class="form-label required-label">
                                        <i class="fas fa-paw"></i> Raza
                                    </label>
                                    <select class="form-select @error('raza') is-invalid @enderror" 
                                            id="raza" name="raza" required>
                                        <option value="">Seleccione una raza</option>
                                        <option value="Angus" {{ old('raza') == 'Angus' ? 'selected' : '' }}>Angus</option>
                                        <option value="Hereford" {{ old('raza') == 'Hereford' ? 'selected' : '' }}>Hereford</option>
                                        <option value="Holstein" {{ old('raza') == 'Holstein' ? 'selected' : '' }}>Holstein</option>
                                        <option value="Brahman" {{ old('raza') == 'Brahman' ? 'selected' : '' }}>Brahman</option>
                                        <option value="Nelore" {{ old('raza') == 'Nelore' ? 'selected' : '' }}>Nelore</option>
                                        <option value="Brangus" {{ old('raza') == 'Brangus' ? 'selected' : '' }}>Brangus</option>
                                        <option value="Jersey" {{ old('raza') == 'Jersey' ? 'selected' : '' }}>Jersey</option>
                                    </select>
                                    @error('raza')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <!-- Edad -->
                                <div class="col-md-4 mb-3">
                                    <label for="edad" class="form-label">
                                        <i class="fas fa-calendar-alt"></i> Edad
                                    </label>
                                    <div class="input-group">
                                        <input type="number" class="form-control @error('edad') is-invalid @enderror" 
                                               id="edad" name="edad" 
                                               value="{{ old('edad') }}" 
                                               min="0" max="30" step="1"
                                               placeholder="0">
                                        <span class="input-group-text">años</span>
                                    </div>
                                    @error('edad')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Peso -->
                                <div class="col-md-4 mb-3">
                                    <label for="peso" class="form-label">
                                        <i class="fas fa-weight-scale"></i> Peso
                                    </label>
                                    <div class="input-group">
                                        <input type="number" class="form-control @error('peso') is-invalid @enderror" 
                                               id="peso" name="peso" 
                                               value="{{ old('peso') }}" 
                                               min="0" max="2000" step="0.1"
                                               placeholder="0.0">
                                        <span class="input-group-text">kg</span>
                                    </div>
                                    @error('peso')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Sexo -->
                                <div class="col-md-4 mb-3">
                                    <label for="sexo" class="form-label">
                                        <i class="fas fa-venus-mars"></i> Sexo
                                    </label>
                                    <select class="form-select @error('sexo') is-invalid @enderror" 
                                            id="sexo" name="sexo">
                                        <option value="">Seleccionar</option>
                                        <option value="hembra" {{ old('sexo') == 'hembra' ? 'selected' : '' }}>Hembra</option>
                                        <option value="macho" {{ old('sexo') == 'macho' ? 'selected' : '' }}>Macho</option>
                                    </select>
                                    @error('sexo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Estado de Salud -->
                            <h5 class="text-success mb-3 mt-4">
                                <i class="fas fa-heartbeat"></i> Estado de Salud
                            </h5>
                            
                            <div class="mb-4">
                                <label for="estado" class="form-label required-label">
                                    Estado Actual
                                </label>
                                <select class="form-select @error('estado') is-invalid @enderror" 
                                        id="estado" name="estado" required onchange="mostrarInfoEstado()">
                                    <option value="">Seleccione el estado de salud</option>
                                    <option value="saludable" {{ old('estado') == 'saludable' ? 'selected' : '' }}>
                                        🟢 Saludable - Animal en condiciones óptimas
                                    </option>
                                    <option value="en_tratamiento" {{ old('estado') == 'en_tratamiento' ? 'selected' : '' }}>
                                        🟡 En tratamiento - Bajo cuidado veterinario
                                    </option>
                                    <option value="enfermo" {{ old('estado') == 'enfermo' ? 'selected' : '' }}>
                                        🔴 Enfermo - Requiere atención inmediata
                                    </option>
                                    <option value="gestacion" {{ old('estado') == 'gestacion' ? 'selected' : '' }}>
                                        👶 En gestación - Preñada
                                    </option>
                                    <option value="lactancia" {{ old('estado') == 'lactancia' ? 'selected' : '' }}>
                                        🥛 En lactancia - Amamantando
                                    </option>
                                    <option value="recuperacion" {{ old('estado') == 'recuperacion' ? 'selected' : '' }}>
                                        🟠 En recuperación - Mejorando de enfermedad/lesión
                                    </option>
                                    <option value="cuarentena" {{ old('estado') == 'cuarentena' ? 'selected' : '' }}>
                                        🚧 En cuarentena - Aislado por precaución
                                    </option>
                                </select>
                                @error('estado')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                
                                <!-- Información del estado seleccionado -->
                                <div id="infoEstado" class="mt-2 p-3 rounded d-none">
                                    <small id="textoInfoEstado"></small>
                                </div>
                            </div>

                            <!-- Fecha de Ingreso -->
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="fecha_ingreso" class="form-label">
                                        <i class="fas fa-calendar-day"></i> Fecha de Ingreso
                                    </label>
                                    <input type="date" class="form-control @error('fecha_ingreso') is-invalid @enderror" 
                                           id="fecha_ingreso" name="fecha_ingreso" 
                                           value="{{ old('fecha_ingreso', date('Y-m-d')) }}">
                                    @error('fecha_ingreso')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror>
                                </div>

                                <!-- Lote/Corral -->
                                <div class="col-md-6 mb-3">
                                    <label for="lote" class="form-label">
                                        <i class="fas fa-map-marker-alt"></i> Lote/Corral
                                    </label>
                                    <input type="text" class="form-control @error('lote') is-invalid @enderror" 
                                           id="lote" name="lote" 
                                           value="{{ old('lote') }}" 
                                           placeholder="Ej: Lote A, Corral 3"
                                           maxlength="50">
                                    @error('lote')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Observaciones -->
                            <div class="mb-4">
                                <label for="observaciones" class="form-label">
                                    <i class="fas fa-sticky-note"></i> Observaciones
                                </label>
                                <textarea class="form-control @error('observaciones') is-invalid @enderror" 
                                          id="observaciones" name="observaciones" 
                                          rows="3" placeholder="Notas adicionales sobre el animal, historial médico, comportamiento, etc."
                                          maxlength="500">{{ old('observaciones') }}</textarea>
                                @error('observaciones')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror>
                                <div class="form-text">
                                    <span id="contadorCaracteres">0</span>/500 caracteres
                                </div>
                            </div>

                            <!-- Botones -->
                            <div class="d-flex justify-content-between align-items-center border-top pt-4">
                                <a href="{{ route('ganado.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Volver al Panel
                                </a>
                                
                                <div class="btn-group">
                                    <button type="reset" class="btn btn-warning" onclick="return confirm('¿Limpiar todos los campos?')">
                                        <i class="fas fa-eraser me-2"></i>Limpiar
                                    </button>
                                    <button type="submit" class="btn btn-success px-4">
                                        <i class="fas fa-plus me-2"></i>Agregar Animal
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Leyenda de Estados -->
                <div class="card mt-4 border-0 bg-light">
                    <div class="card-header bg-white">
                        <h6 class="text-success mb-0">
                            <i class="fas fa-list me-2"></i>Leyenda de Estados
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row small">
                            <div class="col-md-6 mb-2">
                                <span class="badge bg-success estado-badge">🟢 Saludable</span>
                                <span class="text-muted">- Condiciones óptimas</span>
                            </div>
                            <div class="col-md-6 mb-2">
                                <span class="badge bg-warning text-dark estado-badge">🟡 En tratamiento</span>
                                <span class="text-muted">- Bajo cuidado veterinario</span>
                            </div>
                            <div class="col-md-6 mb-2">
                                <span class="badge bg-danger estado-badge">🔴 Enfermo</span>
                                <span class="text-muted">- Requiere atención inmediata</span>
                            </div>
                            <div class="col-md-6 mb-2">
                                <span class="badge bg-info estado-badge">👶 En gestación</span>
                                <span class="text-muted">- Preñada</span>
                            </div>
                            <div class="col-md-6 mb-2">
                                <span class="badge bg-primary estado-badge">🥛 En lactancia</span>
                                <span class="text-muted">- Amamantando</span>
                            </div>
                            <div class="col-md-6 mb-2">
                                <span class="badge bg-warning estado-badge">🟠 En recuperación</span>
                                <span class="text-muted">- Mejorando de enfermedad</span>
                            </div>
                            <div class="col-md-6 mb-2">
                                <span class="badge bg-secondary estado-badge">🚧 En cuarentena</span>
                                <span class="text-muted">- Aislado por precaución</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('animalForm');
            const identificadorInput = document.getElementById('identificador');
            const observacionesTextarea = document.getElementById('observaciones');
            const contadorCaracteres = document.getElementById('contadorCaracteres');
            
            // Auto-mayúsculas para identificador
            identificadorInput.addEventListener('input', function() {
                this.value = this.value.toUpperCase();
            });
            
            // Contador de caracteres para observaciones
            observacionesTextarea.addEventListener('input', function() {
                contadorCaracteres.textContent = this.value.length;
            });
            
            // Inicializar contador
            contadorCaracteres.textContent = observacionesTextarea.value.length;
        });

        // Información contextual del estado seleccionado
        function mostrarInfoEstado() {
            const estadoSelect = document.getElementById('estado');
            const infoDiv = document.getElementById('infoEstado');
            const textoInfo = document.getElementById('textoInfoEstado');
            
            const infoEstados = {
                'saludable': '✅ El animal se encuentra en perfecto estado de salud. No requiere atención especial.',
                'en_tratamiento': '💊 El animal está recibiendo tratamiento veterinario. Registrar medicamentos y próximas revisiones.',
                'enfermo': '🚨 El animal muestra síntomas de enfermedad. Requiere atención veterinaria inmediata.',
                'gestacion': '🤰 Animal preñado. Controlar alimentación y preparar para el parto.',
                'lactancia': '🍼 Animal amamantando. Requiere nutrición especial y control de crías.',
                'recuperacion': '📈 Animal en proceso de recuperación. Monitorear progreso y seguir tratamiento.',
                'cuarentena': '🚫 Animal aislado por precaución. Puede ser por enfermedad contagiosa o llegada reciente.'
            };
            
            const estadoSeleccionado = estadoSelect.value;
            
            if (estadoSeleccionado && infoEstados[estadoSeleccionado]) {
                textoInfo.textContent = infoEstados[estadoSeleccionado];
                infoDiv.className = 'mt-2 p-3 rounded bg-light border';
                infoDiv.classList.remove('d-none');
            } else {
                infoDiv.classList.add('d-none');
            }
        }

        // Validación de fecha
        document.getElementById('fecha_ingreso').max = new Date().toISOString().split('T')[0];
    </script>
    
</body>
</html>
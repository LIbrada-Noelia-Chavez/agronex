<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Animal - Agronex</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-light">
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
                    <div class="card-header bg-warning text-dark py-3">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-edit fa-2x me-3"></i>
                            <div>
                                <h4 class="mb-0">Editar Animal: {{ $ganado->identificador }}</h4>
                                <small class="opacity-75">Modifique los campos necesarios</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-body p-4">
                        <form action="{{ route('ganado.update', $ganado->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="identificador" class="form-label">Identificador *</label>
                                    <input type="text" class="form-control" id="identificador" name="identificador" 
                                           value="{{ old('identificador', $ganado->identificador) }}" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="raza" class="form-label">Raza *</label>
                                    <select class="form-select" id="raza" name="raza" required>
                                        <option value="Angus" {{ $ganado->raza == 'Angus' ? 'selected' : '' }}>Angus</option>
                                        <option value="Hereford" {{ $ganado->raza == 'Hereford' ? 'selected' : '' }}>Hereford</option>
                                        <option value="Holstein" {{ $ganado->raza == 'Holstein' ? 'selected' : '' }}>Holstein</option>
                                        <option value="Brahman" {{ $ganado->raza == 'Brahman' ? 'selected' : '' }}>Brahman</option>
                                        <option value="Nelore" {{ $ganado->raza == 'Nelore' ? 'selected' : '' }}>Nelore</option>
                                        <option value="Brangus" {{ $ganado->raza == 'Brangus' ? 'selected' : '' }}>Brangus</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="edad" class="form-label">Edad (años)</label>
                                    <input type="number" class="form-control" id="edad" name="edad" 
                                           value="{{ old('edad', $ganado->edad) }}" min="0" max="30">
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="peso" class="form-label">Peso (kg)</label>
                                    <input type="number" step="0.1" class="form-control" id="peso" name="peso" 
                                           value="{{ old('peso', $ganado->peso) }}" min="0">
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="sexo" class="form-label">Sexo</label>
                                    <select class="form-select" id="sexo" name="sexo">
                                        <option value="">Seleccionar</option>
                                        <option value="hembra" {{ $ganado->sexo == 'hembra' ? 'selected' : '' }}>Hembra</option>
                                        <option value="macho" {{ $ganado->sexo == 'macho' ? 'selected' : '' }}>Macho</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="estado" class="form-label">Estado de Salud *</label>
                                <select class="form-select" id="estado" name="estado" required>
                                    <option value="saludable" {{ $ganado->estado == 'saludable' ? 'selected' : '' }}>🟢 Saludable</option>
                                    <option value="en_tratamiento" {{ $ganado->estado == 'en_tratamiento' ? 'selected' : '' }}>🟡 En tratamiento</option>
                                    <option value="enfermo" {{ $ganado->estado == 'enfermo' ? 'selected' : '' }}>🔴 Enfermo</option>
                                    <option value="gestacion" {{ $ganado->estado == 'gestacion' ? 'selected' : '' }}>👶 En gestación</option>
                                    <option value="lactancia" {{ $ganado->estado == 'lactancia' ? 'selected' : '' }}>🥛 En lactancia</option>
                                    <option value="recuperacion" {{ $ganado->estado == 'recuperacion' ? 'selected' : '' }}>🟠 En recuperación</option>
                                    <option value="cuarentena" {{ $ganado->estado == 'cuarentena' ? 'selected' : '' }}>🚧 En cuarentena</option>
                                </select>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="fecha_ingreso" class="form-label">Fecha de Ingreso</label>
                                    <input type="date" class="form-control" id="fecha_ingreso" name="fecha_ingreso" 
                                           value="{{ old('fecha_ingreso', $ganado->fecha_ingreso) }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="lote" class="form-label">Lote/Corral</label>
                                    <input type="text" class="form-control" id="lote" name="lote" 
                                           value="{{ old('lote', $ganado->lote) }}">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="observaciones" class="form-label">Observaciones</label>
                                <textarea class="form-control" id="observaciones" name="observaciones" 
                                          rows="3">{{ old('observaciones', $ganado->observaciones) }}</textarea>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('ganado.show', $ganado->id) }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times me-2"></i>Cancelar
                                </a>
                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-save me-2"></i>Actualizar Animal
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
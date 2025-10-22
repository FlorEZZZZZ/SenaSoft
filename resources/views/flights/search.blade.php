<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Vuelos - X-Fly333</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="/">
                <i class="fas fa-plane me-2"></i>
                <strong>X-FLY</strong>
            </a>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0"><i class="fas fa-search me-2"></i>Buscar Vuelos</h4>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Origen</label>
                                    <input type="text" class="form-control" placeholder="Ej: Bogotá" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Destino</label>
                                    <input type="text" class="form-control" placeholder="Ej: Medellín" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Fecha Ida</label>
                                    <input type="date" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Pasajeros</label>
                                    <select class="form-select" required>
                                        <option value="1">1 pasajero</option>
                                        <option value="2">2 pasajeros</option>
                                        <option value="3">3 pasajeros</option>
                                        <option value="4">4 pasajeros</option>
                                        <option value="5">5 pasajeros</option>
                                    </select>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-2">
                                <i class="fas fa-search me-2"></i> Buscar Vuelos Disponibles
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
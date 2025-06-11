<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Dashboard</h2>
        <div class="row">
            <!-- Card Users -->
            <div class="col-md-3 mb-3">
                <div class="card text-white bg-primary">
                    <div class="card-body">
                        <h5 class="card-title">Users</h5>
                        <p class="card-text">{{ $usersCount }}</p>
                        <a href="{{ route('users.index') }}" class="btn btn-light btn-sm">View Users</a>
                    </div>
                </div>
            </div>

            <!-- Card Konselors -->
            <div class="col-md-3 mb-3">
                <div class="card text-white bg-success">
                    <div class="card-body">
                        <h5 class="card-title">Konselors</h5>
                        <p class="card-text">{{ $konselorsCount }}</p>
                        <a href="{{ route('konselors.index') }}" class="btn btn-light btn-sm">View Konselors</a>
                    </div>
                </div>
            </div>

            <!-- Card Jadwals -->
            <div class="col-md-3 mb-3">
                <div class="card text-white bg-warning">
                    <div class="card-body">
                        <h5 class="card-title">Jadwals</h5>
                        <p class="card-text">{{ $jadwalsCount }}</p>
                        <a href="{{ route('jadwals.index') }}" class="btn btn-light btn-sm">View Jadwals</a>
                    </div>
                </div>
            </div>

            <!-- Card Appointments -->
            <div class="col-md-3 mb-3">
                <div class="card text-white bg-info">
                    <div class="card-body">
                        <h5 class="card-title">Appointments</h5>
                        <p class="card-text">{{ $appointmentsCount }}</p>
                        <a href="{{ route('appointments.index') }}" class="btn btn-light btn-sm">View Appointments</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

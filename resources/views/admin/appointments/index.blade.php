<!DOCTYPE html>
<html>
<head>
    <title>Appointments</title>

    <style>
        body{font-family:Inter;background:#f1f5f9;padding:30px;margin:0;}
        h2{margin-bottom:20px;}

        .card{
            background:white;
            padding:18px;
            margin-bottom:12px;
            border-radius:12px;
            box-shadow:0 5px 15px rgba(0,0,0,0.05);
        }

        .row{
            display:flex;
            justify-content:space-between;
        }

        .badge{
            padding:5px 10px;
            background:#2563eb;
            color:white;
            border-radius:8px;
            font-size:12px;
        }
    </style>
</head>

<body>

<h2>All Appointments</h2>

@foreach($appointments as $appointment)

<div class="card">

    <div class="row">
        <div>
            <strong>Patient:</strong> {{ $appointment->patient->name ?? 'N/A' }} <br>
            <strong>Doctor:</strong> {{ $appointment->doctor->name ?? 'N/A' }}
        </div>

        <div>
            <span class="badge">
                {{ $appointment->created_at->format('d M Y H:i') }}
            </span>
        </div>
    </div>

</div>

@endforeach

</body>
</html>
<!DOCTYPE html>
<html>
<head>
    <title>Approved Doctors</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>

    <style>
        body{
            font-family:Inter;
            background:#f1f5f9;
            padding:30px;
            margin:0;
        }

        h2{
            margin-bottom:20px;
            color:#0f172a;
        }

        .grid{
            display:grid;
            grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
            gap:15px;
        }

        .card{
            background:white;
            padding:20px;
            border-radius:14px;
            box-shadow:0 5px 15px rgba(0,0,0,0.05);
            text-align:center;
            transition:0.3s;
            position:relative;
        }

        .card:hover{
            transform:translateY(-4px);
        }

        img{
            width:80px;
            height:80px;
            border-radius:50%;
            object-fit:cover;
            margin-bottom:10px;
        }

        .badge{
            display:inline-block;
            padding:5px 10px;
            background:#16a34a;
            color:white;
            border-radius:8px;
            font-size:12px;
            margin-top:8px;
        }

        .delete-btn{
            margin-top:12px;
            display:inline-block;
            background:#ef4444;
            color:white;
            border:none;
            padding:10px 14px;
            border-radius:10px;
            cursor:pointer;
            font-weight:600;
            transition:0.3s;
        }

        .delete-btn:hover{
            background:#dc2626;
        }

        .top-actions{
            position:absolute;
            top:10px;
            right:10px;
        }

        .icon-delete{
            background:#fee2e2;
            color:#dc2626;
            border:none;
            padding:8px;
            border-radius:8px;
            cursor:pointer;
        }

        .icon-delete:hover{
            background:#fecaca;
        }

    </style>
</head>

<body>

<h2>Approved Doctors</h2>

<div class="grid">

@foreach($doctors as $doctor)

<div class="card">

    <!-- DELETE ICON TOP RIGHT -->
    <div class="top-actions">

        <form method="POST"
              action="{{ route('admin.doctors.delete', $doctor->id) }}"
              onsubmit="return confirm('Are you sure you want to delete this doctor?');">

            @csrf
            @method('DELETE')

           

        </form>

    </div>

    <!-- IMAGE -->
    @if($doctor->profile_image)
        <img src="{{ asset('storage/'.$doctor->profile_image) }}">
    @else
        <img src="https://via.placeholder.com/80">
    @endif

    <!-- INFO -->
    <h3>{{ $doctor->name }}</h3>
    <p>{{ $doctor->specialization }}</p>

    <span class="badge">Approved</span>

    <!-- DELETE BUTTON -->
    <form method="POST"
          action="{{ route('admin.doctors.delete', $doctor->id) }}"
          onsubmit="return confirm('Are you sure you want to remove this doctor from the system?');">

        @csrf
        @method('DELETE')

        <button class="delete-btn">
            <i class="fa-solid fa-trash"></i>
           Remove the doctor from the system
        </button>

    </form>

</div>

@endforeach

</div>

</body>
</html>
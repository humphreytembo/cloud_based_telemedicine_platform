<!DOCTYPE html>
<html>
<head>
    <title>Patients</title>

    <style>
        body{
            font-family:Inter;
            background:#f1f5f9;
            padding:30px;
            margin:0;
        }

        h2{
            margin-bottom:20px;
        }

        table{
            width:100%;
            border-collapse:collapse;
            background:white;
            border-radius:12px;
            overflow:hidden;
        }

        th,td{
            padding:14px;
            text-align:left;
            border-bottom:1px solid #e5e7eb;
        }

        th{
            background:#0f172a;
            color:white;
        }

        tr:hover{
            background:#f8fafc;
        }

        .delete-btn{
            background:#ef4444;
            color:white;
            border:none;
            padding:8px 12px;
            border-radius:8px;
            cursor:pointer;
            font-weight:600;
        }

        .delete-btn:hover{
            background:#dc2626;
        }

        .actions{
            display:flex;
            gap:10px;
        }
    </style>
</head>

<body>

<h2>Registered Patients</h2>

<table>

<tr>
    <th>Name</th>
    <th>Email</th>
    <th>Joined</th>
    <th>Action</th>
</tr>

@foreach($patients as $patient)

<tr>
    <td>{{ $patient->name }}</td>
    <td>{{ $patient->email }}</td>
    <td>{{ $patient->created_at->diffForHumans() }}</td>

    <td>

        <form method="POST"
              action="{{ route('admin.patients.delete', $patient->id) }}"
              onsubmit="return confirm('Are you sure you want to delete this patient?');">

            @csrf
            @method('DELETE')

            <button class="delete-btn">
                Delete
            </button>

        </form>

    </td>
</tr>

@endforeach

</table>

</body>
</html>
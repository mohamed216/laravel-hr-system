<!DOCTYPE html>
<html>
<head>
    <title>Attendance Report - {{ $month }}/{{ $year }}</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 8px; border: 1px solid #ddd; text-align: left; }
        th { background: #f5f5f5; }
    </style>
</head>
<body>
    <h1>Attendance Report - {{ $month }}/{{ $year }}</h1>
    <table>
        <thead>
            <tr>
                <th>Employee</th>
                <th>Date</th>
                <th>Check In</th>
                <th>Check Out</th>
                <th>Hours</th>
            </tr>
        </thead>
        <tbody>
            @foreach($attendances as $att)
            <tr>
                <td>{{ $att->employee->name ?? '-' }}</td>
                <td>{{ $att->date }}</td>
                <td>{{ $att->check_in ?? '-' }}</td>
                <td>{{ $att->check_out ?? '-' }}</td>
                <td>{{ $att->hours_worked ?? 0 }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <title>Employee Profile - {{ $employee->name }}</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        .header { text-align: center; margin-bottom: 30px; }
        .info { margin-bottom: 20px; }
        .info table { width: 100%; }
        .info td { padding: 8px; border-bottom: 1px solid #ddd; }
        .label { font-weight: bold; width: 30%; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Employee Profile</h1>
    </div>
    <div class="info">
        <table>
            <tr><td class="label">Name:</td><td>{{ $employee->name }}</td></tr>
            <tr><td class="label">Email:</td><td>{{ $employee->email }}</td></tr>
            <tr><td class="label">Phone:</td><td>{{ $employee->phone }}</td></tr>
            <tr><td class="label">Department:</td><td>{{ $employee->department?->name }}</td></tr>
            <tr><td class="label">Position:</td><td>{{ $employee->position?->name }}</td></tr>
            <tr><td class="label">Salary:</td><td>${{ number_format($employee->salary, 2) }}</td></tr>
            <tr><td class="label">Hire Date:</td><td>{{ $employee->hire_date }}</td></tr>
            <tr><td class="label">Status:</td><td>{{ $employee->status }}</td></tr>
        </table>
    </div>
</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <title>Payroll - {{ $payroll->month }}/{{ $payroll->year }}</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        .header { text-align: center; margin-bottom: 30px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 10px; border: 1px solid #ddd; text-align: left; }
        th { background: #f5f5f5; }
        .total { font-weight: bold; background: #e6f3ff; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Payroll Slip</h1>
        <p>{{ $payroll->month }}/{{ $payroll->year }}</p>
    </div>
    <table>
        <tr>
            <th>Employee</th>
            <td>{{ $payroll->employee->name }}</td>
        </tr>
        <tr>
            <th>Basic Salary</th>
            <td>${{ number_format($payroll->basic_salary, 2) }}</td>
        </tr>
        <tr>
            <th>Bonuses</th>
            <td>+${{ number_format($payroll->bonuses, 2) }}</td>
        </tr>
        <tr>
            <th>Deductions</th>
            <td>-${{ number_format($payroll->deductions, 2) }}</td>
        </tr>
        <tr class="total">
            <th>Net Salary</th>
            <th>${{ number_format($payroll->net_salary, 2) }}</th>
        </tr>
    </table>
</body>
</html>

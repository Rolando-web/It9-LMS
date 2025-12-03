<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Dashboard Report - {{ $startDate }} to {{ $endDate }}</title>
    <link rel="stylesheet" href="{{ public_path('css/pdf.css') }}">
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            margin: 20px;
            font-size: 12px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #4f46e5;
            padding-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            color: #4f46e5;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0;
            color: #666;
            font-size: 14px;
        }
        .date-range {
            background: #f3f4f6;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
            margin-bottom: 20px;
            font-weight: bold;
        }
        .section {
            margin-bottom: 25px;
        }
        .section-title {
            background: #4f46e5;
            color: white;
            padding: 8px 12px;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 10px;
            border-radius: 3px;
        }
        .stats-grid {
            display: table;
            width: 100%;
            margin-bottom: 15px;
        }
        .stats-row {
            display: table-row;
        }
        .stats-card {
            display: table-cell;
            width: 25%;
            padding: 10px;
            vertical-align: top;
        }
        .stats-card-inner {
            border: 1px solid #e5e7eb;
            padding: 12px;
            border-radius: 5px;
            text-align: center;
            background: #f9fafb;
        }
        .stats-card h3 {
            margin: 0 0 5px 0;
            font-size: 10px;
            color: #6b7280;
            text-transform: uppercase;
        }
        .stats-card p {
            margin: 0;
            font-size: 24px;
            font-weight: bold;
            color: #1f2937;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        table th {
            background: #f3f4f6;
            padding: 8px;
            text-align: left;
            font-size: 11px;
            border-bottom: 2px solid #4f46e5;
        }
        table td {
            padding: 8px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 11px;
        }
        table tr:hover {
            background: #f9fafb;
        }
        .status-badge {
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
        }
        .status-returned { background: #d1fae5; color: #065f46; }
        .status-borrowed { background: #dbeafe; color: #1e40af; }
        .status-overdue { background: #fee2e2; color: #991b1b; }
        .status-pending { background: #fef3c7; color: #92400e; }
        .status-damaged { background: #fed7aa; color: #9a3412; }
        .summary-box {
            background: #f0fdf4;
            border-left: 4px solid #10b981;
            padding: 12px;
            margin-top: 20px;
        }
        .summary-box h3 {
            margin: 0 0 10px 0;
            color: #065f46;
            font-size: 14px;
        }
        .summary-box p {
            margin: 5px 0;
            font-size: 11px;
        }
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #e5e7eb;
            text-align: center;
            font-size: 10px;
            color: #9ca3af;
        }
        .chart-section {
            page-break-inside: avoid;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>📊 Library Management System</h1>
        <p>Dashboard Activity Report</p>
    </div>

    <div class="date-range">
        📅 Report Period: {{ $startDate }} to {{ $endDate }}
    </div>

    <!-- Summary Statistics -->
    <div class="section">
        <div class="section-title">📈 Summary Statistics</div>
        <div class="stats-grid">
            <div class="stats-row">
                <div class="stats-card">
                    <div class="stats-card-inner">
                        <h3>Books Added</h3>
                        <p>{{ $stats['booksAdded'] }}</p>
                    </div>
                </div>
                <div class="stats-card">
                    <div class="stats-card-inner">
                        <h3>Total Borrowed</h3>
                        <p>{{ $stats['totalBorrowed'] }}</p>
                    </div>
                </div>
                <div class="stats-card">
                    <div class="stats-card-inner">
                        <h3>Returned</h3>
                        <p>{{ $stats['totalReturned'] }}</p>
                    </div>
                </div>
                <div class="stats-card">
                    <div class="stats-card-inner">
                        <h3>Activities</h3>
                        <p>{{ $stats['totalActivities'] }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Return Status Breakdown -->
    <div class="section">
        <div class="section-title">📦 Return Status Breakdown</div>
        <table>
            <thead>
                <tr>
                    <th>Status</th>
                    <th style="text-align: right;">Count</th>
                    <th style="text-align: right;">Percentage</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><span class="status-badge status-returned">Returned Well</span></td>
                    <td style="text-align: right;">{{ $stats['returnedWell'] }}</td>
                    <td style="text-align: right;">{{ $stats['totalReturned'] > 0 ? number_format(($stats['returnedWell'] / $stats['totalReturned']) * 100, 1) : 0 }}%</td>
                </tr>
                <tr>
                    <td><span class="status-badge status-damaged">Returned Damaged</span></td>
                    <td style="text-align: right;">{{ $stats['returnedDamaged'] }}</td>
                    <td style="text-align: right;">{{ $stats['totalReturned'] > 0 ? number_format(($stats['returnedDamaged'] / $stats['totalReturned']) * 100, 1) : 0 }}%</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Recent Books Added -->
    @if(count($recentBooks) > 0)
    <div class="section">
        <div class="section-title">📚 Books Added During This Period</div>
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Category</th>
                    <th style="text-align: center;">Copies</th>
                    <th>Added Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentBooks as $book)
                <tr>
                    <td>{{ $book->title }}</td>
                    <td>{{ $book->author }}</td>
                    <td>{{ $book->category }}</td>
                    <td style="text-align: center;">{{ $book->copies }}</td>
                    <td>{{ \Carbon\Carbon::parse($book->created_at)->format('M d, Y H:i') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <!-- Transaction Details -->
    @if(count($transactions) > 0)
    <div class="section">
        <div class="section-title">📋 Transactions During This Period</div>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Book</th>
                    <th>Borrowed Date</th>
                    <th>Due Date</th>
                    <th>Status</th>
                    <th style="text-align: right;">Fee</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $tx)
                <tr>
                    <td>{{ $tx->id }}</td>
                    <td>{{ optional($tx->user)->firstName }} {{ optional($tx->user)->lastName }}</td>
                    <td>{{ optional($tx->book)->title }}</td>
                    <td>{{ $tx->borrowed_at ? \Carbon\Carbon::parse($tx->borrowed_at)->format('M d, Y') : 'N/A' }}</td>
                    <td>{{ $tx->due_date ? \Carbon\Carbon::parse($tx->due_date)->format('M d, Y') : 'N/A' }}</td>
                    <td>
                        @if($tx->status == 'returned')
                            <span class="status-badge status-returned">Returned</span>
                        @elseif($tx->status == 'borrowed')
                            <span class="status-badge status-borrowed">Borrowed</span>
                        @elseif($tx->status == 'overdue')
                            <span class="status-badge status-overdue">Overdue</span>
                        @elseif($tx->status == 'pending')
                            <span class="status-badge status-pending">Pending</span>
                        @elseif($tx->status == 'damaged')
                            <span class="status-badge status-damaged">Damaged</span>
                        @else
                            <span class="status-badge">{{ ucfirst($tx->status) }}</span>
                        @endif
                    </td>
                    <td style="text-align: right;">₱{{ number_format($tx->fee ?? 0, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <!-- Activity Log Summary -->
    @if(count($activities) > 0)
    <div class="section">
        <div class="section-title">📝 Recent Activities</div>
        <table>
            <thead>
                <tr>
                    <th>Date & Time</th>
                    <th>User</th>
                    <th>Action</th>
                    <th>Details</th>
                </tr>
            </thead>
            <tbody>
                @foreach($activities->take(20) as $activity)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($activity->created_at)->format('M d, Y H:i') }}</td>
                    <td>{{ $activity->user_name }} ({{ ucfirst($activity->role) }})</td>
                    <td>{{ $activity->action }}</td>
                    <td>{{ Str::limit($activity->details, 60) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @if(count($activities) > 20)
        <p style="text-align: center; color: #6b7280; font-style: italic; margin-top: 10px;">
            Showing 20 of {{ count($activities) }} activities
        </p>
        @endif
    </div>
    @endif

    <!-- Summary Box -->
    <div class="summary-box">
        <h3>📊 Report Summary</h3>
        <p><strong>Period:</strong> {{ $startDate }} to {{ $endDate }} ({{ $stats['dayCount'] }} day{{ $stats['dayCount'] > 1 ? 's' : '' }})</p>
        <p><strong>Total Books Added:</strong> {{ $stats['booksAdded'] }} books</p>
        <p><strong>Total Transactions:</strong> {{ $stats['totalBorrowed'] }} borrowed, {{ $stats['totalReturned'] }} returned</p>
        <p><strong>Total Activities Logged:</strong> {{ $stats['totalActivities'] }} activities</p>
        <p><strong>Total Fees Collected:</strong> ₱{{ number_format($stats['totalFees'], 2) }}</p>
    </div>

    <div class="footer">
        <p>Generated on {{ now()->format('F d, Y \a\t H:i:s') }}</p>
        <p>Library Management System - Dashboard Report</p>
    </div>
</body>
</html>

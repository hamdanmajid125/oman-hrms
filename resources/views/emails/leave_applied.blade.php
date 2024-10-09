<h1>Leave Application Submitted</h1>
<p>Hello,</p>
<p>{{ $user->name }} has applied for a leave.</p>
<p><strong>Leave Details:</strong></p>
<ul>
    <li>Start Date: {{ $leaveDetails['start_date'] }}</li>
    <li>End Date: {{ $leaveDetails['end_date'] ?? 'N/A' }}</li>
    <li>Reason: {{ $leaveDetails['reason'] }}</li>
    <li>Leave Type: {{ $leaveDetails['type'] }}</li>
</ul>
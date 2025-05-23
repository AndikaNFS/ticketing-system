<x-app-layout>
<form method="GET" action="{{ url('/schedules') }}" class="mb-4">
    <label for="start_date">Start Date:</label>
    <input type="date" name="start_date" value="{{ $startDate }}">
    <label for="end_date">End Date:</label>
    <input type="date" name="end_date" value="{{ $endDate }}">
    <button type="submit">Filter</button>
</form>

</x-app-layout>
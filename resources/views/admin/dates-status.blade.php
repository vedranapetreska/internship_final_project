<form action="{{ route('admin.index') }}" method="GET" class="mb-4">
    <label for="date" class="text-gray-700 font-medium">Select Date:</label>
    <input type="date" id="date" name="date" value="{{ request('date') }}" class="border rounded-lg p-2 w-full">

    <label for="status" class="text-gray-700 font-medium mt-4">Select Status:</label>
    <select id="status" name="status" class="border rounded-lg p-2 w-full">
        <option value="">All Statuses</option>
        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
        <option value="denied" {{ request('status') == 'denied' ? 'selected' : '' }}>Denied</option>
    </select>

    <button type="submit" class="mt-2 bg-gray-400 hover:bg-gray-500 text-white p-2 rounded-lg">Show Reservations</button>
</form>

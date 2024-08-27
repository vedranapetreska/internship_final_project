<form action="{{ route('admin.approveReservation', $reservation->id) }}" method="POST" class="inline">
    @csrf
    @method('POST')
    <button type="submit" class="bg-green-500 text-white p-1 w-20 rounded-lg text-xs">
        Approve
    </button>
</form>

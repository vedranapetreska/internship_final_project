<form action="{{ route('admin.denyReservation', $reservation->id) }}" method="POST"
      class="inline">
    @csrf
    @method('POST')
    <button type="submit" class="bg-red-400 text-white p-1 w-20 rounded-lg text-xs">
        Deny
    </button>
</form>

<form action="{{ route('admin.denyReservation', $reservation->id) }}" method="POST"
      class="inline"
      onsubmit="return confirm('Are you sure you want to deny this reservation?');">
    @csrf
    @method('POST')
    <button type="submit" class="bg-red-400 hover:bg-red-500 text-white p-1 w-20 rounded-lg text-xs">
        Deny
    </button>
</form>

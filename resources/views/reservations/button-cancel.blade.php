<form action="{{ route('reservation.cancel', $reservation->id) }}" method="POST"
      class="inline">
    @csrf
    @method('PUT')
    <button type="submit" class="bg-red-500 text-white p-1 w-20 rounded-lg text-xs">
        Cancel
    </button>
</form>

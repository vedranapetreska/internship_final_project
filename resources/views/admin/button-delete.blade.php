<form action="{{ route('admin.deleteReservation', $reservation->id) }}" method="POST"
      class="inline"
      onsubmit="return confirm('Are you sure you want to delete this reservation?');">
    @csrf
    @method('DELETE')
    <button type="submit" class="bg-red-500 text-white p-1 w-20 rounded-lg text-xs">
        Delete
    </button>
</form>

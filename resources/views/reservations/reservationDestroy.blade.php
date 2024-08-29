<form action="{{ route('reservation.destroy', $reservation->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this reservation?');">
    @csrf
    @method('DELETE')
    <div class="space-x-4 flex" style="margin-top:3rem;display: flex;justify-content: center;align-items: center">
        <button type="submit" class="inline-flex items-center px-4 py-1 border border-transparent text-base font-medium rounded-lg shadow-sm text-black bg-red-500 hover:bg-green-900
                          focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" style="width:auto;height: 2.5rem">
            Delete
        </button>
    </div>
</form>

<h2>Confirm User Deletion</h2>
<p>Are you sure you want to delete the user {{ $users->name }}?</p>

<form action="{{ route('user.destroy', $users->id) }}" method="post">
    @method('DELETE')
    @csrf
    <button type="submit" class="btn btn-danger">Yes, delete user</button>
    <a href="{{ route('user.list') }}" class="btn btn-secondary">Cancel</a>
</form>

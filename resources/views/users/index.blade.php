@foreach($users as $user)
    <tr>
        <td>{{ $user->name }}</td>
        <td>{{ $user->email }}</td>
        <td>
            @if($user->hasRole('superadmin|admin'))
                <span class="badge bg-success">Admin</span>
            @else
                <span class="badge bg-secondary">User</span>
            @endif
        </td>
        <td>
            @if(!$user->hasRole('superadmin|admin'))
                <form action="{{ route('admin.makeAdmin', $user->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-warning">Jadikan Admin</button>
                </form>
            @endif
        </td>
    </tr>
@endforeach

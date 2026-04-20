<h2>User Management</h2>

@if(session('success'))
    <p style="color:green">{{ session('success') }}</p>
@endif

<table border="1" cellpadding="10">
    <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Role</th>
        <th>Assign Role</th>
    </tr>

    @foreach($users as $user)
    <tr>
        <td>{{ $user->name }}</td>
        <td>{{ $user->email }}</td>
        <td>{{ $user->role->name ?? 'No Role' }}</td>

        <td>
            <form method="POST" action="/admin/users/{{ $user->id }}/assign-role">
                @csrf
                <select name="role_id">
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                    @endforeach
                </select>

                <button type="submit">Assign</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>
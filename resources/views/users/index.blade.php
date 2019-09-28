@extends ('layouts.app')

@section ('content')
<table class="table table-striped">
    <thead>
        <tr>
            <th>Name</th>
            <th>Family</th>
            <th>#</th>
        </tr>
    </thead>
    <tbody>
    @foreach($result as $user)
        <tr>
            <td>{{ $user->name }}</td>
            <td>{{ $user->family }}</td>
            <td>
                <a class="btn btn-primary" href="{{ route('users.show', ['ticket_id' => $user->id]) }}">V</a>
                <a class="btn btn-success" href="{{ route('users.edit', ['ticket_id' => $user->id]) }}">E</a>
                <button  onclick="deleteTicket({{ $user->id }})" class="delete-ticket btn btn-danger" data-id="{{ $user->id }}">D</button>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

    {{ $result->links() }}
@endsection

@section('scripts')
    <script>
        function deleteTicket(id) {
            $.ajax({
                url: '/dashboard/users/' +id,
                method: 'POST',
                accept: 'json',
                data: {_method: 'delete', _token: "{{ csrf_token() }}"}
            }).then(res => {
                window.location.reload();
            });
        }
    </script>
@endsection

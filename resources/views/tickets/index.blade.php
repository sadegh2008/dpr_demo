@extends ('layouts.app')

@section ('content')
<a class="btn btn-primary mb-4" role="button" href="{{ route('tickets.create') }}">New Ticket</a>

<table class="table table-striped">
    <thead>
        <tr>
            <th>Title</th>
            <th>Creator</th>
            <th>Status</th>
            <th>#</th>
        </tr>
    </thead>
    <tbody>
    @foreach($result as $ticket)
        <tr>
            <td>{{ $ticket->title }}</td>
            <td>{{ $ticket->creator->name }} {{ $ticket->creator->family }}</td>
            <td class="{{
                $ticket->status == 'new' ? 'text-success' : 'text-primary'
            }}">{{ $ticket->status }}</td>
            <td>
                <a class="btn btn-primary" href="{{ route('tickets.show', ['ticket_id' => $ticket->id]) }}">V</a>
                <a class="btn btn-success" href="{{ route('tickets.edit', ['ticket_id' => $ticket->id]) }}">E</a>
                <button  onclick="deleteTicket({{ $ticket->id }})" class="delete-ticket btn btn-danger" data-id="{{ $ticket->id }}">D</button>
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
                url: '/dashboard/tickets/' +id,
                method: 'POST',
                accept: 'json',
                data: {_method: 'delete', _token: "{{ csrf_token() }}"}
            }).then(res => {
                window.location.reload();
            });
        }
    </script>
@endsection

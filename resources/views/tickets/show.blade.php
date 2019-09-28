@extends ('layouts.app')

@section ('content')
    <div>
        @permission('assign_user_to_ticket')
            <button class="btn btn-primary" data-toggle="modal" data-target="#usersModal">Assign User</button>
        @endpermission
        <a class="btn btn-success text-white">Edit</a>
    </div>
    <div class="my-4">
        <p>Creator: <strong>{{ $result->creator->full_name }}</strong></p>
        <p>status: <strong>{{ $result->status }}</strong></p>
        <p>Title: <strong>{{ $result->title }}</strong></p>
    </div>
    <hr>
    <div>
        @foreach($result->messages as $message)
            <div class="alert {{ $message->creator_id == auth()->id() ? 'alert-primary' : 'alert-secondary' }}">
                <p>From: {{ $message->creator_id != auth()->id() ? $message->creator->full_name : 'Me' }}</p>
                <p>{{ $message->message }}</p>
            </div>
        @endforeach
    </div>

    <!-- Modal -->
    <div class="modal fade" id="usersModal" tabindex="-1" role="dialog" aria-labelledby="usersModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="usersModalLabel">Assign User...</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('tickets.assign_user', ['ticket_id' => $result->id]) }}">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="user_id">Select User:</label>
                            <select class="form-control" name="user_id" id="user_id"></select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(function () {
            $.ajax({
                url: '/dashboard/users/list',
                method: 'GET',
                header: {
                    Accept: 'application/json; charset=utf-8'
                },
                success: function (res) {
                    res.result.forEach(function (user) {
                        $('#user_id').append(new Option(user.name + ' ' + user.family, user.id))
                    });
                }
            });
        });
    </script>
@endsection

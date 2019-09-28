@extends ('layouts.app')

@section ('content')
    <form action="{{ route('tickets.update', ['ticket_id' => $result->id]) }}" method="post">
        @csrf
        @method('patch')
        <div class="form-group">
            <label for="title">Title</label>
            <input value="{{ $result->title }}" class="form-control" name="title" id="title" placeholder="Ticket title..."/>
        </div>
        <div class="form-group">
            <label for="message">Message</label>
            <textarea class="form-control" name="message" id="message" placeholder="Ticket message">
                {{ $result->message }}
            </textarea>
        </div>

        <button class="btn btn-success" type="submit">Save</button>
        <a class="btn btn-secondary" href="{{ route('tickets.index') }}">Cancel</a>
    </form>
@endsection

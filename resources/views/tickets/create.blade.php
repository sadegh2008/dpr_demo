@extends ('layouts.app')

@section ('content')
    <form action="{{ route('tickets.create') }}" method="post">
        @csrf
        <div class="form-group">
            <label for="title">Title</label>
            <input class="form-control @error('title') is-invalid @enderror" name="title" id="title" placeholder="Ticket title..."/>
            @error('title')
            <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
            @enderror
        </div>
        <div class="form-group">
            <label for="message">Message</label>
            <textarea class="form-control @error('message') is-invalid @enderror" name="message" id="message" placeholder="Ticket message">
            </textarea>
            @error('message')
            <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
            @enderror
        </div>

        <button class="btn btn-success" type="submit">Save</button>
        <a class="btn btn-secondary" href="{{ route('tickets.index') }}">Cancel</a>
    </form>
@endsection

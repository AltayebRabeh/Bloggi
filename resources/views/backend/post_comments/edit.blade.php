@extends('layouts.admin')

@section('content')

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary">Edit comment on ({{ $comment->post->title }})</h6>
            <div class="ml-auto">
                <a href="{{ route('admin.post_comments.index') }}" class="btn btn-primary">
                    <span class="icon text-white-60">
                        <i class="fa fa-home"></i>
                        <span class="text">Comments</span>
                    </span>
                </a>
            </div>
        </div>
        <div class="card-body">
            {!! Form::model($comment, ['route' => ['admin.post_comments.update', $comment->id], 'method' => 'patch']) !!}
            <div class="row">
                <div class="col-4">
                    <div class="form-group">
                        {!! Form::label('name', 'Name') !!} {{ $comment->user_id != null ? '(Member)' : '' }}
                        {!! Form::text('name', old('name', $comment->name), ['class' => 'form-control']) !!}
                        @error('name') <span class="text-danger"> {{ $message }} </span> @enderror
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        {!! Form::label('email', 'Email') !!}
                        {!! Form::email('email', old('email', $comment->email), ['class' => 'form-control']) !!}
                        @error('email') <span class="text-danger"> {{ $message }} </span> @enderror
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        {!! Form::label('url', 'Url') !!}
                        {!! Form::text('url', old('url', $comment->url), ['class' => 'form-control']) !!}
                        @error('url') <span class="text-danger"> {{ $message }} </span> @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        {!! Form::label('ip_address', 'IP Address') !!}
                        {!! Form::text('ip_address', old('ip_address', $comment->ip_address), ['class' => 'form-control']) !!}
                        @error('ip_address') <span class="text-danger"> {{ $message }} </span> @enderror
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        {!! Form::label('status', 'Status') !!}
                        {!! Form::select('status', ['1' => 'Active', '0' => 'Inactive'], old('status', $comment->status), ['class' => 'form-control']) !!}
                        @error('status') <span class="text-danger"> {{ $message }} </span> @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        {!! Form::label('status', 'Status') !!}
                        {!! Form::select('status', ['1' => 'Active', '0' => 'Inactive'], old('status', $comment->status), ['class' => 'form-control']) !!}
                        @error('status') <span class="text-danger"> {{ $message }} </span> @enderror
                    </div>
                </div>
            </div>

            <div class="row pt-4">
                <div class="col-12">
                    {!! Form::label('Sliders', 'images') !!}
                    <div class="form-group">
                        {!! Form::label('comment', 'Comment') !!}
                        {!! Form::textarea('comment', old('comment', $comment->comment), ['class' => 'form-control', 'rows' => 5]) !!}
                        @error('comment') <span class="text-danger"> {{ $message }} </span> @enderror
                    </div>
                </div>
            </div>

            <div class="form-group pt-4">
                {!! Form::submit('Update comment', ['class' => 'btn btn-primary']) !!}
            </div>

            {!! Form::close() !!}
        </div>
    </div>

@endsection

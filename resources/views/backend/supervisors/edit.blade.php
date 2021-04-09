@extends('layouts.admin')
@section('style')
    <link rel="stylesheet" href="{{ asset('backend/vendor/select2/css/select2.min.css') }}">
@endsection
@section('content')

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary">Edit supervisor</h6>
            <div class="ml-auto">
                <a href="{{ route('admin.supervisors.index') }}" class="btn btn-primary">
                    <span class="icon text-white-60">
                        <i class="fa fa-home"></i>
                        <span class="text">Supervisors</span>
                    </span>
                </a>
            </div>
        </div>
        <div class="card-body">
            {!! Form::model($supervisor, ['route' => ['admin.supervisors.update', $supervisor->id], 'method' => 'patch', 'files' => true]) !!}
            <div class="row">
                <div class="col-3">
                    <div class="form-group">
                        {!! Form::label('name', 'Name') !!}
                        {!! Form::text('name', old('name', $supervisor->name), ['class' => 'form-control']) !!}
                        @error('name') <span class="text-danger"> {{ $message }} </span> @enderror
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        {!! Form::label('username', 'Username') !!}
                        {!! Form::text('username', old('username', $supervisor->username), ['class' => 'form-control']) !!}
                        @error('username') <span class="text-danger"> {{ $message }} </span> @enderror
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        {!! Form::label('email', 'Email') !!}
                        {!! Form::email('email', old('email', $supervisor->email), ['class' => 'form-control']) !!}
                        @error('email') <span class="text-danger"> {{ $message }} </span> @enderror
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        {!! Form::label('mobile', 'Mobile') !!}
                        {!! Form::text('mobile', old('mobile', $supervisor->mobile), ['class' => 'form-control']) !!}
                        @error('mobile') <span class="text-danger"> {{ $message }} </span> @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        {!! Form::label('password', 'Password') !!}
                        {!! Form::password('password', ['class' => 'form-control']) !!}
                        @error('password') <span class="text-danger"> {{ $message }} </span> @enderror
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        {!! Form::label('status', 'Status') !!}
                        {!! Form::select('status', ['' => '', '1' => 'Active', '0' => 'Inactive'], old('status', $supervisor->status), ['class' => 'form-control']) !!}
                        @error('status') <span class="text-danger"> {{ $message }} </span> @enderror
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        {!! Form::label('receive_email', 'Receive Email') !!}
                        {!! Form::select('receive_email', ['' => '', '1' => 'Yes', '0' => 'No'], old('receive_email', $supervisor->receive_email), ['class' => 'form-control']) !!}
                        @error('receive_email') <span class="text-danger"> {{ $message }} </span> @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        {!! Form::label('bio', 'Bio') !!}
                        {!! Form::textarea('bio', old('bio', $supervisor->bio), ['class' => 'form-control', 'style' => 'max-height: 100px']) !!}
                        @error('bio') <span class="text-danger"> {{ $message }} </span> @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        {!! Form::label('permissions', 'Permissions') !!}
                        {!! Form::select('permissions[]', [] + $permissions->toArray(), old('permissions',  $supervisor->$userPermission), ['class' => 'form-control select-multiple-tag', 'multiple' => 'multiple']) !!}
                        @error('permissions') <span class="text-danger"> {{ $message }} </span> @enderror
                    </div>
                </div>
            </div>

            <div class="row pt-4">
                @if ($supervisor->user_image)
                    <div class="col-12 text-center">
                        <div id="imgArea">
                            <img src="{{ asset('assets/users/' . $supervisor->user_image) }}" width="200" height="200">
                            <button class="btn btn-danger removeImage">Remove Image</button>
                        </div>
                    </div>
                @endif
                <div class="col-12">
                    {!! Form::label('user_image', 'Supervisor Image') !!}
                    <div class="file-loading">
                        {!! Form::file('user_image', ['id' => 'user-image', 'class' => 'file-input-overview']) !!}
                        <span class="form-text text-muted">Image width should be 300 x 300</span>
                        @error('user_image') <span class="text-danger"> {{ $message }} </span> @enderror
                    </div>
                </div>
            </div>

            <div class="form-group pt-4">
                {!! Form::submit('Update', ['class' => 'btn btn-primary']) !!}
            </div>

            {!! Form::close() !!}
        </div>
    </div>

@endsection

@section('script')
    <script src="{{ asset('backend/vendor/select2/js/select2.full.min.js') }}"></script>
    <script>
        $(function () {
            $('.select-multiple-tag').select2({
                minimumResultsForSearch: Infinity,
                tags: false,
                closeOnSelect: false,
            });

            $('#user-image').fileinput({
                theme: "fas",
                maxFileCount: 1,
                allowedFileTypes: ['image'],
                showCancel: true,
                showRemove: false,
                showUpload: false,
                overwriteInitial: false,
            });

            $('.removeImage').click(function (){
                $.post('{{ route('admin.supervisors.remove_image') }}', { user_id: '{{ $supervisor->id }}', _token: '{{ csrf_token() }}' }, function (data) {
                    if (data == 'true') {
                        window.location.href = window.location;
                    }
                })
            });
        });

    </script>
@endsection

@extends('layouts.admin')

@section('content')

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary">Edit post ({{ $post->title }})</h6>
            <div class="ml-auto">
                <a href="{{ route('admin.posts.index') }}" class="btn btn-primary">
                    <span class="icon text-white-60">
                        <i class="fa fa-home"></i>
                        <span class="text">Posts</span>
                    </span>
                </a>
            </div>
        </div>
        <div class="card-body">
            {!! Form::model($post, ['route' => ['admin.posts.update', $post->id], 'method' => 'patch', 'files' => true]) !!}
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        {!! Form::label('title', 'Title') !!}
                        {!! Form::text('title', old('title', $post->title), ['class' => 'form-control']) !!}
                        @error('title') <span class="text-danger"> {{ $message }} </span> @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        {!! Form::label('description', 'Description') !!}
                        {!! Form::textarea('description', old('description', $post->description), ['class' => 'form-control summernote']) !!}
                        @error('description') <span class="text-danger"> {{ $message }} </span> @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-4">
                    <div class="form-group">
                        {!! Form::label('category_id', 'Category') !!}
                        {!! Form::select('category_id', ['' => '---'] + $categories->toArray(), old('category_id', $post->category_id), ['class' => 'form-control']) !!}
                        @error('category_id') <span class="text-danger"> {{ $message }} </span> @enderror
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        {!! Form::label('comment_able', 'Comment Able') !!}
                        {!! Form::select('comment_able', ['1' => 'Yes', '0' => 'No'], old('comment_able', $post->comment_able), ['class' => 'form-control']) !!}
                        @error('comment_able') <span class="text-danger"> {{ $message }} </span> @enderror
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        {!! Form::label('status', 'Status') !!}
                        {!! Form::select('status', ['1' => 'Active', '0' => 'Inactive'], old('status', $post->status), ['class' => 'form-control']) !!}
                        @error('status') <span class="text-danger"> {{ $message }} </span> @enderror
                    </div>
                </div>
            </div>

            <div class="row pt-4">
                <div class="col-12">
                    {!! Form::label('Sliders', 'images') !!}
                    <div class="file-loading">
                        {!! Form::file('images[]', ['id' => 'post-images', 'class' => 'file-input-overview', 'multiple' => 'multiple']) !!}

                        @error('images') <span class="text-danger"> {{ $message }} </span> @enderror
                    </div>
                </div>
            </div>

            <div class="form-group pt-4">
                {!! Form::submit('Update post', ['class' => 'btn btn-primary']) !!}
            </div>

            {!! Form::close() !!}
        </div>
    </div>

@endsection

@section('script')
    <script src="{{ asset('frontend/js/summernote/summernote-bs4.min.js') }}"></script>
    <script>
        $(function () {
            $('.summernote').summernote({
                placeholder: '',
                tabsize: 2,
                height: 180,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });

            $('#post-images').fileinput({
                theme: "fa",
                maxFileCount: {{ 5 - $post->media->count() }},
                allowedFileTypes: ['image'],
                showCancel: true,
                showRemove: false,
                showUpload: false,
                overwriteInitial: false,
                initialPreview: [
                    @if($post->media->count() > 0)
                        @foreach($post->media as $media)
                            "{{ asset('assets/posts/' . $media->file_name) }}",
                        @endforeach
                    @endif
                ],
                initialPreviewAsData: true,
                initialPreviewFileType: 'image',
                initialPreviewConfig: [
                    @if($post->media->count() > 0)
                        @foreach($post->media as $media)
                            {caption: "{{ $media->file_name }}", size:  "{{ $media->file_size }}", width:  120, url: "{{ route('admin.posts.media.destroy', [$media->id, '_token' => csrf_token()]) }}", key: "{{ $media->id }}"},
                        @endforeach
                    @endif
                ],
            });
        });
    </script>
@endsection

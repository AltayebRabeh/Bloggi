@extends('layouts.admin')

@section('content')

    <div class="row">
        <div class="col-3">
            <div class="card">
                <div class="card-header">Settings</div>
                <ul class="list-group list-group-flush">
                    @foreach($settings_sections as $settings_section)
                        <li class="list-group-item">
                            <a href="{{ route('admin.settings.index', ['section' => $settings_section]) }}" class="nav-link">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-gear" viewBox="0 0 16 16">
                                    <path d="M8 4.754a3.246 3.246 0 1 0 0 6.492 3.246 3.246 0 0 0 0-6.492zM5.754 8a2.246 2.246 0 1 1 4.492 0 2.246 2.246 0 0 1-4.492 0z"/>
                                    <path d="M9.796 1.343c-.527-1.79-3.065-1.79-3.592 0l-.094.319a.873.873 0 0 1-1.255.52l-.292-.16c-1.64-.892-3.433.902-2.54 2.541l.159.292a.873.873 0 0 1-.52 1.255l-.319.094c-1.79.527-1.79 3.065 0 3.592l.319.094a.873.873 0 0 1 .52 1.255l-.16.292c-.892 1.64.901 3.434 2.541 2.54l.292-.159a.873.873 0 0 1 1.255.52l.094.319c.527 1.79 3.065 1.79 3.592 0l.094-.319a.873.873 0 0 1 1.255-.52l.292.16c1.64.893 3.434-.902 2.54-2.541l-.159-.292a.873.873 0 0 1 .52-1.255l.319-.094c1.79-.527 1.79-3.065 0-3.592l-.319-.094a.873.873 0 0 1-.52-1.255l.16-.292c.893-1.64-.902-3.433-2.541-2.54l-.292.159a.873.873 0 0 1-1.255-.52l-.094-.319zm-2.633.283c.246-.835 1.428-.835 1.674 0l.094.319a1.873 1.873 0 0 0 2.693 1.115l.291-.16c.764-.415 1.6.42 1.184 1.185l-.159.292a1.873 1.873 0 0 0 1.116 2.692l.318.094c.835.246.835 1.428 0 1.674l-.319.094a1.873 1.873 0 0 0-1.115 2.693l.16.291c.415.764-.42 1.6-1.185 1.184l-.291-.159a1.873 1.873 0 0 0-2.693 1.116l-.094.318c-.246.835-1.428.835-1.674 0l-.094-.319a1.873 1.873 0 0 0-2.692-1.115l-.292.16c-.764.415-1.6-.42-1.184-1.185l.159-.291A1.873 1.873 0 0 0 1.945 8.93l-.319-.094c-.835-.246-.835-1.428 0-1.674l.319-.094A1.873 1.873 0 0 0 3.06 4.377l-.16-.292c-.415-.764.42-1.6 1.185-1.184l.292.159a1.873 1.873 0 0 0 2.692-1.115l.094-.319z"/>
                                </svg>
                                {{ $settings_section }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="col-9">
            <div class="card">
                <div class="card-header">Settings {{ $section}}</div>
                <div class="card-body">
                    {!! Form::model($settings, ['route' => ['admin.settings.update', 1], 'method' => 'patch']) !!}
                    @foreach($settings as $setting)
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="title">{{ $setting->display_name }}</label>
                                    @if ($setting->type == 'text')
                                        <input type="text" name="value[{{ $loop->index }}]" id="value" class="form-control" value="{{ $setting->value }}">
                                    @elseif ($setting->type == 'textarea')
                                        <textarea name="value[{{ $loop->index }}]" id="value" class="form-control">{{ $setting->value }}</textarea>
                                    @elseif ($setting->type == 'image')
                                        <input type="file" name="value[{{ $loop->index }}]" id="value" class="form-control">
                                    @elseif ($setting->type == 'select')
                                        {!! Form::select('value[' . $loop->index . ']', explode('|', $setting->details), $setting->value, ['id' => 'value', 'class' => 'form-control']) !!}
                                    @elseif ($setting->type == 'checkbox')
                                        {!! Form::checkbox('value[' . $loop->index . ']', 1, $setting->value == 1 ? true : false, ['id' => 'value', 'class' => 'styled']) !!}
                                    @elseif ($setting->type == 'radio')
                                        {!! Form::radio('value[' . $loop->index . ']', 1, $setting->value == 1 ? true : false, ['id' => 'value', 'class' => 'styled']) !!}
                                    @endif

                                    <input type="hidden" name="key[{{ $loop->index }}]" id="key" class="form-control" value="{{  $setting->key }}" readonly>
                                    <input type="hidden" name="id[{{ $loop->index }}]" id="key" class="form-control" value="{{  $setting->id }}" readonly>
                                    <input type="hidden" name="ordering[{{ $loop->index }}]" id="key" class="form-control" value="{{  $setting->ordering }}" readonly>

                                    @error('value') <span class="text-danger">{{ $message }}</span>@enderror
                                </div>
                            </div>
                        </div>
                    @endforeach

                        <div class="text-right">
                            {!! Form::submit('Submit', ['type' => 'submit','class' => 'btn btn-primary']) !!}
                        </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

@endsection

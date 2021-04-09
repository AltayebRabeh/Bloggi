@extends('layouts.admin')

@section('content')

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary">Supervisor ({{ $supervisor->name }})</h6>
            <div class="ml-auto">
                <a href="{{ route('admin.supervisors.index') }}" class="btn btn-primary">
                    <span class="icon text-white-60">
                        <i class="fa fa-home"></i>
                        <span class="text">Supervisors</span>
                    </span>
                </a>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover">
                <tbody>
                    <tr>
                        <td colspan="4">
                            @if($supervisor->supervisor_image != '')
                                <img src="{{ asset('assets/supervisors/' . $supervisor->supervisor_image) }}" class="img-fluid">
                            @else
                                <img src="{{ asset('assets/supervisors/default.png') }}" class="img-fluid" style="max-height: 80px">
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Name</th>
                        <td>{{ $supervisor->name }} ({{ $supervisor->name }})</td>
                        <th>Email</th>
                        <td>{{ $supervisor->email }}</td>
                    </tr>
                    <tr>
                        <th>Mobile</th>
                        <td>{{ $supervisor->mobile }}</td>
                        <th>Status</th>
                        <td>{{ $supervisor->status() }}</td>
                    </tr>
                    <tr>
                        <th>Created date</th>
                        <td>{{ $supervisor->created_at->format('d-m-Y h:i a') }}</td>
                        <th>Posts Count</th>
                        <td>{{ $supervisor->posts_count }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

@endsection

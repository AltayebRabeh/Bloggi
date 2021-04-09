@extends('layouts.admin')

@section('content')

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary">Supervisor</h6>
            <div class="ml-auto">
                <a href="{{ route('admin.supervisors.create') }}" class="btn btn-primary">
                    <span class="icon text-white-60">
                        <i class="fa fa-plus"></i>
                        <span class="text">Add new supervisor</span>
                    </span>
                </a>
            </div>
        </div>

        @include('backend.supervisors.filter.filter')

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Email & Mobile</th>
                    <th>Status</th>
                    <th>Created at</th>
                    <th class="text-center" style="width: 30px;">Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse($supervisors as $supervisor)
                    <tr>
                        <td>
                            @if($supervisor->supervisor_image != '')
                                <img src="{{ asset('assets/supervisors/' . $supervisor->supervisor_image) }}" class="img-fluid" width="60">
                            @else
                                <img src="{{ asset('assets/supervisors/default.png') }}" class="img-fluid" width="60">
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.supervisors.show', $supervisor->id) }}">{{ $supervisor->name }}</a>
                            <p class="text-gray-400"><b>{{ $supervisor->supervisorname }}</b></p>
                        </td>
                        <td>
                            {{ $supervisor->email }}
                            <p class="text-gray-400"><b>{{ $supervisor->mobile }}</b></p>
                        </td>
                        <td>{{ $supervisor->status() }}</td>
                        <td>{{ $supervisor->created_at->format('d-m-Y h:i a') }}</td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('admin.supervisors.edit', $supervisor->id) }}" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                <a href="javascript:void(0)" onclick="if (confirm('Are you sure to delete this supervisor?')) { event.preventDefault(); document.getElementById('supervisor-delete-{{ $supervisor->id }}').submit();} else {return false;}" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                                <form action="{{ route('admin.supervisors.destroy', $supervisor->id) }}" id="supervisor-delete-{{ $supervisor->id }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No supervisors found</td>
                    </tr>
                @endforelse
                </tbody>
                <tfoot>
                <tr>
                    <th colspan="6">
                        <div class="float-right">
                            {!! $supervisors->appends(request()->input())->links() !!}
                        </div>
                    </th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>

@endsection

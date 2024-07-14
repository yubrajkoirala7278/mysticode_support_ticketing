@extends('admin.layouts.app')
@section('content')
    {{-- create roles --}}
    @include('livewire.admin.role.create')
    {{-- edit role --}}
    @include('livewire.admin.role.edit')
    <div class="p-4 bg-white">
        <div class="d-flex align-items-center justify-content-between">
            <h2 class="fw-semibold fs-4 text-success">Roles</h2>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createRoles">
                Add Role
            </button>
        </div>
        <div class="pt-3" style="overflow-x:auto;">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Role</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($roles->count() > 0)
                        @foreach ($roles as $key => $role)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $role->name }}</td>
                                <td>
                                    <button type="button" class="btn btn-transparent p-0 me-2" data-bs-toggle="modal"
                                        data-bs-target="#editRoles" data-toggle="tooltip" title="Edit Role"
                                        wire:click="edit({{$role->id}})">
                                        <i class="fa-solid fa-pencil text-warning fs-5"></i>
                                    </button>


                                    </button>
                                    <button class="btn btn-transparent p-0" wire:confirm="Are you sure you want to delete this role?"
                                        wire:click="destroy({{ $role->id }})" data-toggle="tooltip"
                                        title="Delete Role"><i class="fa-solid fa-trash text-danger fs-5"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr class="text-center">
                            <td colspan="20">No roles to display..</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-end mt-3 pagination">
            {{ $roles->links() }}
        </div>
    </div>
@endsection

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Livewire.on('success', (event) => {
                toastify().success(event.title);
                $('#createRoles').modal('hide');
                $('#editRoles').modal('hide');
            });
            Livewire.on('error', (event) => {
                toastify().error(event.title);
            });
            Livewire.on('delete', (event) => {
                toastify().success(event.title);
            });
        });
    </script>
@endpush

@extends('admin.layouts.app')
@section('content')
    <div class="bg-white p-4">
        {{-- create user --}}
        @include('livewire.admin.user.create')
        {{-- edit user --}}
        @include('livewire.admin.user.edit')
        <div class="d-flex align-items-center justify-content-between">
            <h2 class="fw-semibold fs-4 text-success">Users</h2>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createUser"
                wire:click="create">
                Add User
            </button>
        </div>
        {{-- search users --}}
        <input type="text" class="form-control my-2 " placeholder="Search user.." style="max-width: 300px" wire:model.live.debounce.500ms="search">

        <div class="pt-3">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Role</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($users->count() > 0)
                        @foreach ($users as $key => $user)
                            <tr :key={{$key}}>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <span
                                        class="badge rounded-pill text-bg-success">{{ count($user->getRoleNames()) > 0 ? $user->getRoleNames()->first() : '' }}</span>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-transparent p-0 me-2" data-toggle="tooltip"
                                        title="Edit User" data-bs-toggle="modal" data-bs-target="#editUser"
                                        wire:click="edit({{ $user->id }})">
                                        <i class="fa-solid fa-pencil text-warning fs-5"></i>
                                    </button>
                                    <button class="btn btn-transparent p-0" data-toggle="tooltip" title="Delete User"
                                        wire:confirm="Are you sure you want to delete this user?"
                                        wire:click="destroy({{ $user->id }})"><i
                                            class="fa-solid fa-trash text-danger fs-5"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr class="text-center">
                            <td colspan="20">No Users to display...</td>
                        </tr>
                    @endif

                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-end mt-3 pagination">
            {{ $users->links() }}
        </div>
    </div>
@endsection
@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Livewire.on('success', (event) => {
                toastify().success(event.title);
                $('#createUser').modal('hide');
                $('#editUser').modal('hide');
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

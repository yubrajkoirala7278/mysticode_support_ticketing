{{-- create roles --}}
<div class="modal fade" wire:ignore.self id="createRoles" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="createRolesLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="createRolesLabel">Add Roles</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"  wire:click="resetFields()"></button>
            </div>
            <div class="modal-body">
                <form wire:submit.prevent="submit">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" wire:model="name">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click="resetFields()">Close</button>
                <button type="button" class="btn btn-primary" wire:click.prevent="store()">Submit</button>
            </div>
        </div>
    </div>
</div>

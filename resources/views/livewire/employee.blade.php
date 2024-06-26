<div>
    <div class="container">
        @if ($errors->any())
            <div class="pt-3">
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $item)
                            <li>{{ $item }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        @if (session()->has('message'))
            <div class="pt-3">
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            </div>
        @endif
        <!-- START FORM -->
        <div class="my-3 p-3 bg-body rounded shadow-sm">
            <form>
                <div class="mb-3 row">
                    <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" wire:model="nama">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="email" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" wire:model="email">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" wire:model="alamat">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label"></label>
                    <div class="col-sm-10">
                        @if ($updateData == false)
                            <button type="button" class="btn btn-primary" name="submit"
                                wire:click="store()">SIMPAN</button>
                        @else
                            <button type="button" class="btn btn-primary" name="submit"
                                wire:click="update()">UPDATE</button>
                        @endif
                        <button type="button" class="btn btn-secondary" name="submit"
                            wire:click="clear()">CLEAR</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- AKHIR FORM -->

        <!-- START DATA -->
        <div class="my-3 p-3 bg-body rounded shadow-sm">
            <h1>Data Pegawai</h1>
            <div class="pt-3">
                <input type="text" class="form-control mb-3 w-25" placeholder="Search.." wire:model.live="keyword">
            </div>

            @if ($employee_selected_id)
                <a wire:click="deleteconfirm('')" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                    data-bs-target="#exampleModal">Delete {{ count($employee_selected_id) }}</a>
            @endif

            <table class="table table-striped table-sortable">
                <thead>
                    <tr>
                        <th class="col-md-1"></th>
                        <th class="col-md-1">No</th>
                        <th class="col-md-4 sort @if($sortColumn == 'nama') {{ $sortDirection }} @endif" wire:click="sort('nama')">Nama</th>
                        <th class="col-md-3 sort @if($sortColumn == 'email') {{ $sortDirection }} @endif" wire:click="sort('email')">Email</th>
                        <th class="col-md-2 sort @if($sortColumn == 'alamat') {{ $sortDirection }} @endif" wire:click="sort('alamat')">Alamat</th>
                        <th class="col-md-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dataEmployees as $key => $item)
                        <tr>
                            <td><input type="checkbox" wire:key="{{ $item->id }}" value="{{ $item->id }}"
                                    wire:model.live="employee_selected_id"></td>
                            <td>{{ $dataEmployees->firstItem() + $key }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->email }}</td>
                            <td>{{ $item->alamat }}</td>
                            <td>
                                <a wire:click="edit({{ $item->id }})" class="btn btn-warning btn-sm">Edit</a>
                                <a wire:click="deleteconfirm({{ $item->id }})" class="btn btn-danger btn-sm"
                                    data-bs-toggle="modal" data-bs-target="#exampleModal">Del</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $dataEmployees->links() }}
        </div>
        <!-- AKHIR DATA -->
        <!-- Modal -->
        <div wire:ignore.self class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Konfirmasi Delete</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Yakin akan mengahpus Data?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal"
                            wire:click="delete()">Iya</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@extends('layouts.master')

@section('content')
    <div class="container-fluid">
        <h1 class="mt-4">Tables</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Manage Table List</li>
        </ol>
        <div class="card mb-4">
            <div class="card-header">

                <div class="row">
                    <div class="col-md-6"><i class="fas fa-table mr-1"></i>Table list</div>
                    <div class="col-md-6">
                        <button type="button" @click="setAdd" class="btn btn-primary float-right" data-toggle="modal" data-target="#tableModal">New Table</button>
                    </div>
                </div>
            </div>

            @include('pages.modals.add-table')

            <div class="card-body">
                <div class="row">
                    <div class="col-xl-3 col-md-3">
                        <div class="card bg-danger text-white mb-3">
                            <div class="card-body">Table Number</div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-3">
                        <div class="card bg-danger text-white mb-3">
                            <div class="card-body">Capacity</div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-3">
                        <div class="card bg-danger text-white mb-3">
                            <div class="card-body">Status</div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-3">
                        <div class="card bg-danger text-white mb-3">
                            <div class="card-body">Actions</div>
                        </div>
                    </div>
                </div>
                <div class="row" v-for="table in tables">
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-default text-white mb-3">
                            <div class="card-body" style="color: #0f0f0f">@{{ table.id }}</div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-default text-white mb-3">
                            <div class="card-body" style="color: #0f0f0f">@{{ table.capacity }}</div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-default text-white mb-3">
                            <div class="card-body" style="color: #0f0f0f">@{{ table.status }}</div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-default text-white mb-3">
                            <div class="card-body" style="color: #0f0f0f">
                                <div class="row">
                                    <div class="col-md-6">
                                        <button type="button" @click="setAttribute(table)" data-toggle="modal" data-target="#tableModal" class="btn btn-outline-primary"><svg class="bi bi-pencil" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M11.293 1.293a1 1 0 0 1 1.414 0l2 2a1 1 0 0 1 0 1.414l-9 9a1 1 0 0 1-.39.242l-3 1a1 1 0 0 1-1.266-1.265l1-3a1 1 0 0 1 .242-.391l9-9zM12 2l2 2-9 9-3 1 1-3 9-9z"/>
                                                <path fill-rule="evenodd" d="M12.146 6.354l-2.5-2.5.708-.708 2.5 2.5-.707.708zM3 10v.5a.5.5 0 0 0 .5.5H4v.5a.5.5 0 0 0 .5.5H5v.5a.5.5 0 0 0 .5.5H6v-1.5a.5.5 0 0 0-.5-.5H5v-.5a.5.5 0 0 0-.5-.5H3z"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        new Vue({
            el: '#app',
            data: {
                selected: 'Available',
                capacity: '',
                tables: [],
                table:[],

                isUpdate: false,
            },

            mounted() {
                this.fetchTables();
            },

            methods: {
                setAdd: function () {
                    this.isUpdate = false;
                    this.capacity = '1';
                    this.selected = 'Available';
                },
                setAttribute: function (table) {
                    this.table = table;
                    this.capacity = table.capacity;
                    this.selected = table.status;
                    this.isUpdate = true;
                },

                updateTable: function () {
                    let _this = this;
                    let attributes = {
                        capacity: this.capacity,
                        status: this.selected
                    }

                    console.log('Attributes: ', attributes);

                    axios.patch('api/table/' + this.table.id, attributes).then(() => {
                        _this.fetchTables();
                        _this.showAlert('Successfully updated.');
                        _this.close();
                    })
                },

                save: function () {
                    let _this = this;

                    let attributes = {
                        capacity: this.capacity,
                        status: this.selected
                    }

                    axios.post('api/table', attributes).then((response) => {
                        _this.fetchTables();
                        _this.showAlert('Successfully added.');
                        _this.close();
                    })
                },

                fetchTables: function () {
                    let _this = this;

                    axios.get('api/table').then((response) => {
                        let data = response.data.table;

                        _this.tables = data;

                        console.log('tables: ', data)
                    })
                },
                showAlert: function (message) {
                    Swal.fire({
                        icon: 'success',
                        title: message,
                        showConfirmButton: false,
                        timer: 2000
                    })
                },
                close: function () {
                    $('#tableModal').modal('hide');
                }
            }
        })
    </script>
@endpush

@extends('layouts.master')

@section('content')
    <div class="container-fluid">
        <h1 class="mt-4">All Booking Request</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">New Booking Request</li>
        </ol>

        @include('pages.modals.update-status')

        <div class="card mb-4">
            <div class="card-header"><i class="fas fa-table mr-1"></i>Booking request</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-3 col-md-3">
                        <div class="card bg-success text-white mb-3">
                            <div class="card-body">Table Number</div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-3">
                        <div class="card bg-success text-white mb-3">
                            <div class="card-body">Date</div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-3">
                        <div class="card bg-success text-white mb-3">
                            <div class="card-body">Time</div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-3">
                        <div class="card bg-success text-white mb-3">
                            <div class="card-body">Status</div>
                        </div>
                    </div>
                </div>

                <div class="row" v-for="booking in bookings">
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-default text-white mb-3">
                            <div class="card-body" style="color: #0f0f0f">@{{ booking.id }}</div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-default text-white mb-3">
                            <div class="card-body" style="color: #0f0f0f">@{{ booking.date }}</div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-default text-white mb-3">
                            <div class="card-body" style="color: #0f0f0f">@{{ booking.time }}</div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-default text-white mb-3">
                            <div class="card-body" style="color: #0f0f0f">
                                <div class="row">
                                    <div class="col-md-6">@{{ booking.status }}</div>
                                    <div class="col-md-6">
                                        <button type="button" @click="setId(booking.id, booking.table_id)" data-toggle="modal" data-target="#statusModal" class="btn btn-outline-primary"><svg class="bi bi-pencil" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
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
                {{--                <div class="table-responsive">--}}
                {{--                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">--}}
                {{--                        <thead>--}}
                {{--                        <tr>--}}
                {{--                            <th>Name</th>--}}
                {{--                            <th>Position</th>--}}
                {{--                            <th>Office</th>--}}
                {{--                            <th>Age</th>--}}
                {{--                            <th>Start date</th>--}}
                {{--                            <th>Salary</th>--}}
                {{--                        </tr>--}}
                {{--                        </thead>--}}
                {{--                        <tfoot>--}}
                {{--                        <tr>--}}
                {{--                            <th>Name</th>--}}
                {{--                            <th>Position</th>--}}
                {{--                            <th>Office</th>--}}
                {{--                            <th>Age</th>--}}
                {{--                            <th>Start date</th>--}}
                {{--                            <th>Salary</th>--}}
                {{--                        </tr>--}}
                {{--                        </tfoot>--}}
                {{--                        <tbody>--}}
                {{--                        <tr>--}}
                {{--                            <td>Tiger Nixon</td>--}}
                {{--                            <td>System Architect</td>--}}
                {{--                            <td>Edinburgh</td>--}}
                {{--                            <td>61</td>--}}
                {{--                            <td>2011/04/25</td>--}}
                {{--                            <td>$320,800</td>--}}
                {{--                        </tr>--}}
                {{--                        <tr>--}}
                {{--                            <td>Garrett Winters</td>--}}
                {{--                            <td>Accountant</td>--}}
                {{--                            <td>Tokyo</td>--}}
                {{--                            <td>63</td>--}}
                {{--                            <td>2011/07/25</td>--}}
                {{--                            <td>$170,750</td>--}}
                {{--                        </tr>--}}
                {{--                        </tbody>--}}
                {{--                    </table>--}}
                {{--                </div>--}}
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        new Vue({
            el: '#app',
            data: {
                selected: 'pending',
                tableId: '',
                bookingId: '',
                booking: {
                    capacity:'',
                    date: '',
                    time: ''
                },
                tables: [],
                bookings: []
            },

            mounted() {
                // this.fetchTables();
                this.fetchBookings();
            },
            methods: {
                setId: function(id, tableId) {
                    this.bookingId = id;
                    this.tableId   = tableId;
                },
                fetchBookings: function () {
                    let _this = this;

                    axios.get('api/booking').then((response) => {
                        let data = response.data.booking;
                        _this.bookings = data;
                        console.log('booking: ', data);
                    })
                },
                updateStatus: function () {
                    let _this = this;

                    let attributes = {
                        status: this.selected,
                        tableId: this.tableId
                    }

                    axios.patch('api/booking/' + this.bookingId, attributes).then((response) => {
                        let data = response.data.booking;
                        this.fetchBookings();

                        Swal.fire({
                            position: 'top',
                            icon: 'success',
                            title: 'Booking accepted.',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    })

                    $('#statusModal').modal('hide');
                },

                // fetchTables: function () {
                //     let _this = this;
                //
                //     axios.get('api/table').then((response) => {
                //         let data = response.data.table;
                //
                //         _this.tables = data;
                //
                //         console.log('data: ', data)
                //     })
                // },



                // saveBooking: function () {
                //     let _this = this;
                //
                //     let attributes = {
                //         capacity: this.booking.capacity,
                //         date: $('#date').val(),
                //         time: $('#timepicker1').val(),
                //         table: $('#select2').val()
                //     }
                //
                //     axios.post('api/booking', attributes).then((response) => {
                //         let data = response.data.booking;
                //         this.fetchBookings();
                //
                //         Swal.fire({
                //             position: 'top',
                //             icon: 'success',
                //             title: 'Your work has been saved',
                //             showConfirmButton: false,
                //             timer: 1500
                //         })
                //     })
                //
                //     $('#bookModal').modal('hide');
                // }
            }
        })
    </script>
@endpush

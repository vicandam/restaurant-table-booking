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
                                <div class="row justify-content-center">
                                    @{{ booking.status }}
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
                }
            }
        })
    </script>
@endpush

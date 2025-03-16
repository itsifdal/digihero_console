<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 text-gray-900 dark:text-gray-100">
        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="table-auto w-full mt-4 min-w-max">
                <thead>
                    <tr>
                        <th class="border px-4 py-2">Order ID</th>
                        <th class="border px-4 py-2">Service</th>
                        <th class="border px-4 py-2">Name</th>
                        <th class="border px-4 py-2">Whatsapp</th>
                        <th class="border px-4 py-2">Email</th>
                        <th class="border px-4 py-2">Booking Date</th>
                        <th class="border px-4 py-2">Booking Code</th>
                        <th class="border px-4 py-2">Price</th>
                        <th class="border px-4 py-2">Paid Amount</th>
                        <th class="border px-4 py-2">Payment Status</th>
                        <th class="border px-4 py-2">Payment Type</th>
                        <th class="border px-4 py-2">Updated At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $booking)
                        <tr>
                            <td class="border px-4 py-2">{{ $booking->order_id }}</td>
                            <td class="border px-4 py-2">{{ $booking->service->name }}</td>
                            <td class="border px-4 py-2">{{ $booking->customer->name }}</td>
                            <td class="border px-4 py-2">{{ $booking->customer->whatsapp_number }}</td>
                            <td class="border px-4 py-2">{{ $booking->customer->email }}</td>
                            <td class="border px-4 py-2">{{ $booking->booking_date }}</td>
                            <td class="border px-4 py-2">{{ $booking->booking_code }}</td>
                            <td class="border px-4 py-2">{{ $booking->price }}</td>
                            <td class="border px-4 py-2">{{ $booking->paid_amount }}</td>
                            <td class="border px-4 py-2">
                                @if($booking->payment_status == 'settlement')
                                    <span class="bg-green-100 text-green-800 text-md font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-green-200 dark:text-green-900">{{$booking->payment_status}}</span>
                                @elseif($booking->payment_status == 'Tertunda' || $booking->payment_status == 'pending')
                                    <span class="bg-blue-100 text-blue-800 text-md font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-blue-200 dark:text-blue-900">{{$booking->payment_status}}</span>
                                @else
                                    <span class="bg-red-100 text-red-800 text-md font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-red-200 dark:text-red-900">Failure</span>
                                @endif
                            </td>
                            <td class="border px-4 py-2">{{ $booking->payment_type }}</td>
                            <td class="border px-4 py-2">{{ $booking->updated_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
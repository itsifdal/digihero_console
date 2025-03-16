<div>
    <div id="calendar"></div>

    @if($selectedDate)
        <p class="mt-4">Tanggal Dipilih: <strong>{{ $selectedDate }}</strong></p>
        
    @if(session()->has('message'))
        <p class="mt-4 text-red-500 font-bold">{{ session('message') }}</p>
    @endif
    @endif

    

    <script type="module">
        document.addEventListener('DOMContentLoaded', function () {
            var calendarEl = document.getElementById('calendar');
            var calendar   = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                selectable: true,
                dateClick: function(info) {
                    Livewire.dispatch('dateClicked', { date: info.dateStr });
                }
            });
            calendar.render();
        });
    </script>
</div>

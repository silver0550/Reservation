<template>
    <calendar-with-time
        @changeDate="updateDate">
    </calendar-with-time>
    <button class="btn btn-primary" @click="store">Mentés</button>
    <div class="text-sm text-red-700 p-2"> {{ errors }}</div>
    <div>
        <div class="text-center p-3 font-bold text-2xl">Foglalásaim</div>

        <div class="overflow-x-auto">
            <table class="table table-zebra w-1/2 mx-auto">
                <thead>
                <tr>
                    <th class="w-1/12"></th>
                    <th class="w-4/12">Dátum</th>
                    <th class="w-4/12">Idő</th>
                    <th class="w-2/12"></th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(booking, index) in ownBookings" :key="index">
                    <BookingRow
                        @deletedBooking="deleteBooking"
                        @updatedBooking="updateBooking"
                        :booking="booking"
                        :index="index"
                    ></BookingRow>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
import CalendarWithTime from "@/Pages/Reservation/CalendarWithTime.vue";
import axios from "axios";
import BookingRow from "@/Components/Booking/BookingRow.vue";

export default {
    name: "Create",
    components: {BookingRow, CalendarWithTime},

    data() {
        return {
            selectedDate: null,
            ownBookings: null,
            errors: null,
        }
    },
    methods: {
        updateDate(date) {
            this.selectedDate = date;
        },
        store() {
            if (this.selectedDate) {
                let date = this.selectedDate.toISOString().split('T')[0];
                let time = this.selectedDate.toLocaleTimeString([], {hour: '2-digit', minute: '2-digit'})

                axios.post('/booking', {date: date, time: time})
                    .then((response) => {
                        this.errors = null;
                        alert('Sikeres foglalás');
                    })
                    .catch((error) => {
                        if (error.response && error.response.data && error.response.data.message) {
                            this.errors = error.response.data.message;
                        }
                    });
            } else {
                this.errors = 'A dátum kötelezeő';
            }
        },
        getMyBookings() {
            axios.get('/booking/myAppointments')
                .then(response => {
                    this.ownBookings = response.data;
                })
                .catch(error => {
                    console.error('Error updating booked:', error);
                });
        },
        deleteBooking(id) {
            this.ownBookings = this.ownBookings.filter(booking => booking.id !== id);
        },
        updateBooking(booking) {
            for (let i = 0; i < this.ownBookings.length; i++) {
                if (this.ownBookings[i]['id'] === booking['id']) {
                    this.ownBookings[i] = booking;

                    return;
                }
            }
        },
    },
    created() {
        this.getMyBookings()
    },
}
</script>


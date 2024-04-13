<template>
    <calendar-with-time
        @changeDate="updateDate"
    ></calendar-with-time>

    <button class="btn btn-primary" @click="store">Mentés</button>
    {{ selectedDate }}
    {{ errors }}
    <div>
        foglalásaim
        <div class="overflow-x-auto">
            <table class="table table-zebra">
                <thead>
                <tr>
                    <th></th>
                    <th>Dátum</th>
                    <th>Idő</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(booking, index) in ownBookings" :key="index">
                    <td>{{ index + 1 }}</td>
                    <td>{{ booking['date'] }}</td>
                    <td>{{ booking['time'] }}</td>
                    <td v-if="!isBookingInThePast(booking)">
                        <a href="" class="btn btn-sm btn-ghost"><i class="las la-edit"/></a>
                        <a @click="destroy(booking['id'])" class="btn btn-sm btn-ghost">
                            <i class="las la-trash"/>
                        </a>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    {{ ownBookings }}

</template>

<script>
import CalendarWithTime from "@/Pages/Reservation/CalendarWithTime.vue";
import axios from "axios";

export default {
    name: "Create",
    components: {CalendarWithTime},

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
                        //TODO: sikeres foglalás visszajelzés
                    })
                    .catch((error) => {
                        this.errors = error
                        console.error(error.message);
                    });
            } else {
                this.errors = 'A dátum kötelezeő';
            }
        },
        destroy(id) {
            axios.delete(`/booking/${id}`)
                .then((response) => {
                    this.ownBookings = this.ownBookings.filter(booking => booking.id !== id);
                    //TODO: sikeres törlés visszajelzés
                })
                .catch((error) => {
                    this.errors = error //TODO: error handling
                    console.error(error.message);
                });
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
        isBookingInThePast(booking) {
            const bookingDateTime = new Date(booking['date'] + 'T' + booking['time']);
            const currentDateTime = new Date();

            return bookingDateTime < currentDateTime;
        },
    },
    created() {
        this.getMyBookings()
    },
}
</script>


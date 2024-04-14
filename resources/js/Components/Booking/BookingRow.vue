<template>
    <td>{{ index + 1 }}</td>
    <td v-if="!isEditorVisible">{{ booking['date'] }}</td>
    <td v-if="!isEditorVisible">{{ booking['time'] }}</td>
    <td v-if="isEditorVisible">
        <input class="input input-sm input-bordered max-w-xs" v-model="bookingCopy['date']" type="date">
    </td>
    <td v-if="isEditorVisible">
        <input class="input input-sm input-bordered " v-model="bookingCopy['time']" type="time">
    </td>

    <td v-if="!isBookingInThePast(booking)">
        <button v-if="!isEditorVisible"
                @click="toggleEditorView"
                class="btn btn-sm btn-ghost">
            <i class="las la-edit"/>
        </button>
        <span v-if="isEditorVisible">
            <button @click="update" class="pr-2">
                <i class="las la-check"></i>
            </button>
            <button @click="toggleEditorView">
                <i class="las la-times"/>
            </button>
        </span>
        <button @click="destroy" class="btn btn-sm btn-ghost">
            <i class="las la-trash"/>
        </button>
    </td>
</template>

<script>
import axios from "axios";

export default {
    emits: ['deletedBooking', 'updatedBooking'],
    name: "BookingRow",
    props: {
        booking: {required: true, type: Object},
        index: {required: true, type: Number},
    },
    data() {
        return {
            isEditorVisible: false,
            bookingCopy: null,
        }
    },
    methods: {
        destroy() {
            axios.delete(`/booking/${this.booking['id']}`)
                .then((response) => {
                    this.$emit('deletedBooking', this.booking['id'])
                    this.errors = null;
                    alert('Sikeres törlés');
                })
                .catch((error) => {
                    if (error.response && error.response.data && error.response.data.message) {
                        alert(error.response.data.message);
                    }
                });
        },
        update() {
            axios.put(`/booking/${this.booking['id']}`, this.bookingCopy)
                .then((response) => {
                    this.$emit('updatedBooking', this.bookingCopy);
                    this.isEditorVisible = false;
                    this.errors = null;
                    alert('Sikeres frissítés');
                })
                .catch((error) => {
                    if (error.response && error.response.data && error.response.data.message) {
                        alert(error.response.data.message);
                    }
                });
        },
        isBookingInThePast(booking) {
            const bookingDateTime = new Date(booking['date'] + 'T' + booking['time']);
            const currentDateTime = new Date();

            return bookingDateTime < currentDateTime;
        },
        toggleEditorView() {
            this.isEditorVisible = !this.isEditorVisible;
        },
    },
    created() {
        this.bookingCopy = JSON.parse(JSON.stringify(this.booking));
    },
}
</script>

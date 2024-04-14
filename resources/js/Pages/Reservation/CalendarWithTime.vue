<template>
    <div class="flex justify-center my-10">
        <div class="w-1/2">
            <calendar
                @updateData="updateDate">
            </calendar>
        </div>
        <div class="w-1/4 ml-5">
            <time-chooser
                :is-active="isActive"
                :booked-times="filteredTimes"
                @updateTime="updateTime"
            ></time-chooser>
        </div>
    </div>
</template>

<script>
import Calendar from "@/Components/Booking/Calendar.vue";
import TimeChooser from "@/Components/Booking/TimeChooser.vue";
import axios from "axios";

export default {
    emits: ['changeDate'],
    name: "calendar-with-time",
    components: {TimeChooser, Calendar},
    props: {
        isActive: {type: Boolean, default: true},
    },
    data() {
        return {
            bookedTimes: [],
            selectedDay: null,
            selectedTime: null,
        }
    },
    computed: {
        filteredTimes() {
            if (this.selectedDay) {
                return this.bookedTimes
                    .filter(time => time.day === this.selectedDay.getDate())
                    .map(time => time.time);
            } else {
                return [];
            }
        }
    },
    methods: {
        updateDate(date) {
            if (!this.selectedDay ||
                this.selectedDay.getFullYear() !== date.getFullYear() ||
                this.selectedDay.getMonth() !== date.getMonth()) {
                this.updateBookedTimes(date.getFullYear(), date.getMonth() + 1)
            }

            this.selectedDay = date;

            if (this.selectedTime) {
                let time = this.selectedTime.split(':');
                this.selectedDay.setHours(parseInt(time[0]), parseInt(time[1]), 0);
            }

            this.$emit('changeDate', new Date(this.selectedDay));

        },
        updateTime(time) {
            this.selectedTime = time;
            time = time.split(':');

            this.selectedDay.setHours(parseInt(time[0]), parseInt(time[1]), 0);
            this.$emit('changeDate', new Date(this.selectedDay));
        },
        updateBookedTimes(year, month) {
            axios.get('/api/booking/times', {
                params: {
                    year: year,
                    month: month
                }
            })
                .then(response => {
                    this.bookedTimes = response.data;
                })
                .catch(error => {
                    console.error('Error updating booked:', error);
                });
        }
    },
    created() {
        const now = new Date();
        this.updateBookedTimes(now.getFullYear(), now.getMonth() + 1);
        this.selectedDay = now;
    },
}
</script>

<template>
    <div class="flex justify-center my-10">
        <div class="w-1/2">
            <calendar
                @updateData="updateDate">
            </calendar>
        </div>
        <div class="w-1/4 ml-5">
            <time-chooser
                :is-active="!!selectedDay"
                :booked-times="filteredTimes"
                @updateTime="updateTime"
            ></time-chooser>
        </div>
    </div>
    {{ selectedDay }}
    {{ bookedTimes }}
</template>

<script>
import Calendar from "@/Components/Calendar.vue";
import TimeChooser from "@/Components/TimeChooser.vue";
import axios from "axios";

export default {
    name: "index",
    components: {TimeChooser, Calendar},

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
        },
        updateTime(time) {
            this.selectedTime = time;
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
                    console.error('Error updating booked times:', error);
                });
        }
    },
    created() {
        const now = new Date();
        this.updateBookedTimes(now.getFullYear(), now.getMonth() + 1);
    },
}
</script>

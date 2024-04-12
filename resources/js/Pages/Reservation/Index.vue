<template>
    <div class="flex justify-center my-10">
        <div class="w-1/2">
            <calendar
                @updateData="updateData">
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
</template>

<script>
import Calendar from "@/Components/Calendar.vue";
import TimeChooser from "@/Components/TimeChooser.vue";

export default {
    name: "index",
    components: {TimeChooser, Calendar},

    props: {
        bookedTimes: {type: Array, default: []}
    },
    data() {
        return {
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
        updateData(data) {
            // TODO: ha nem egyezik a hónap a régivel akkor újra kérni a foglalásokat
            this.selectedDay = data;
        },
        updateTime(time) {
            this.selectedTime = time;
        }
    },
}
</script>

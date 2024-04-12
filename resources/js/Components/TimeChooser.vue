<template>
    <div class="time-chooser flex flex-col justify-between h-full">
        <div v-for="time in times" :key="time"
             @click="isSelectable(time) ? selectTime(time) : null"
             class="p-2 text-center border border-gray-300"
             :class="{
                 'cursor-pointer hover:bg-gray-100': isSelectable(time) && time !== selected,
                 'bg-blue-500 text-white': time === selected,
                 'cursor-not-allowed': !isSelectable(time),
                 'border-red-500': bookedTimes.includes(time)
             }">
            {{ time }}
        </div>
    </div>
</template>

<script>
export default {
    name: "TimeChooser",
    props: {
        isActive: {type: Boolean, default: true},
        bookedTimes: {required: true, type: Array},
    },
    data() {
        return {
            selected: null,
            times: this.generateTimes(),
        };
    },
    methods: {
        generateTimes() {
            const times = [];
            for (let hour = 8; hour <= 18; hour += 2) {
                times.push(`${hour < 10 ? '0' + hour : hour}:00`);
            }
            return times;
        },
        selectTime(time) {
            if (this.isSelectable(time)) {
                this.selected = time;
                this.$emit('updateTime', time);
            }
        },
        isSelectable(time) {
            return this.isActive && !this.bookedTimes.includes(time);
        },
    }
}
</script>


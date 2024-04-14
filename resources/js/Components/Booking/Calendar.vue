<template>
    <div class="max-w-lg mx-auto">
        <div class="flex items-center justify-between mb-4">
            <button @click="changeMonth(-1)" class="p-2 rounded hover:bg-gray-300">
                &lt;
            </button>
            <div class="text-center font-bold">{{ monthName }} {{ year }}</div>
            <button @click="changeMonth(1)" class="p-2 rounded hover:bg-gray-300">
                &gt;
            </button>
        </div>
        <div class="grid grid-cols-7 gap-1">
            <div v-for="day in daysOfMonth" :key="day"
                 class="flex justify-center items-center h-12 rounded-lg hover:bg-gray-300"
                 :class="{
                     'bg-blue-500 text-white': day === selected,
                     'border-2 border-yellow-500 bg-gray-200': isToday(day),
                     'cursor-not-allowed opacity-50': !day || isWeekend(day),
                     'cursor-pointer': day && !isWeekend(day)
                 }"
                 @click="day && !isWeekend(day) && selectDay(day)">
                {{ day }}
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'calendar',
    data() {
        return {
            currentDate: new Date(),
            selected: null,
        };
    },
    computed: {
        year() {
            return this.currentDate.getFullYear();
        },
        month() {
            return this.currentDate.getMonth();
        },
        daysOfMonth() {
            const daysInMonth = new Date(this.year, this.month + 1, 0).getDate();

            const paddingDays = new Date(this.year, this.month, 0).getDay();
            let days = Array.from({length: daysInMonth}, (_, i) => i + 1);
            for (let i = 0; i < paddingDays; i++) {
                days.unshift(null);
            }

            return days;
        },
        monthName() {
            return new Date(this.year, this.month).toLocaleString('default', {month: 'long'});
        }
    },
    methods: {
        selectDay(day) {
            if (day && !this.isWeekend(day)) {
                const selectedDate = new Date(this.year, this.month, day);
                this.$emit('updateData', selectedDate);
                this.selected = day;
            }
        },
        isWeekend(day) {
            const date = new Date(this.year, this.month, day);
            const dayOfWeek = date.getDay();

            return dayOfWeek === 0 || dayOfWeek === 6;
        },
        isToday(day) {
            const today = new Date();

            return day === today.getDate() && this.month === today.getMonth() && this.year === today.getFullYear();
        },
        changeMonth(step) {
            let newDate = new Date(this.currentDate);
            newDate.setMonth(this.currentDate.getMonth() + step);

            this.currentDate = newDate;
            this.selected = 0;
        }
    }
}
</script>


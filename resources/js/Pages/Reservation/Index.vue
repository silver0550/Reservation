
<template>
    <div class>
        <calendar
            @updateData =  "handleUpdate"
            :year="2024"
            :month="3">
        </calendar>
        {{ selectedDay }}
    </div>
</template>

<script>
import Calendar from "@/Components/Calendar.vue";

export default {
    name: "index",
    components: {Calendar},

    data() {
        return {
            selectedDay: 0,
        }
    },
    methods: {
        handleUpdate(data) {
            this.selectedDay = data;
        }
    }
}
</script>

<style scoped>

</style>

<template>
    <div>
        <calendar-with-time
            :is-active="false">
        </calendar-with-time>
    </div>
    <div class="flex justify-center">
        <a href="/booking/reservation" class="btn btn-primary">Foglalás</a>
    </div>
</template>

<script>
import CalendarWithTime from "@/Pages/Reservation/CalendarWithTime.vue";

export default {
    name: "index",
    components: {CalendarWithTime},
    data() {
        return {
            messages: []
        };
    },
}
</script>

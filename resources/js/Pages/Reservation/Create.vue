<template>
    <div class="card w-96 bg-neutral text-neutral-content mx-auto mt-5">
        <div class="card-body items-center text-center">
            <h2 class="card-title">Véglegesítés!</h2>
            <p>Az ön időpontja: {{ booking['date'] }} {{ booking['time'] }} óra</p>
            <p>Kérem jelenjen meg a foglalás előtt legalább fél órával!</p>
            <div class="card-actions justify-end">
                <button class="btn btn-primary" @click="accept">Foglalás</button>
                <button class="btn btn-ghost" @click="cancel">Mégse</button>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "Create",
    props: {
        'booking': {required: true, type: Object},
    },
    data() {
        return {
            status: null,
        }
    },
    methods: {
        send() {
            axios.get(`/booking/status/?id=${this.booking['id']}&status=${this.status}`)
                .then((response) => {
                    window.location.href = `${window.location.origin}/booking/reservation`;
                    this.status == 'resolved'
                        ? alert('A foglalás véglegesítve!')
                        : alert('A foglalás Megszakítva!');
                })
                .catch((error) => {
                    alert('Probléma a folgalással kérem próbálja meg később');
                });
        },
        accept() {
            this.status = 'resolved';
            this.send();
        },
        cancel() {
            this.status = 'canceled';
            this.send();
        }
    }
}
</script>

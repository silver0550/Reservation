<template>
    Create Number: {{ id }}
    <button
        class="btn btn-primary"
        @click="accept"> Véglegesítés
    </button>
    <button
        class="btn btn-primary"
        @click="cancal"> Mégse
    </button>
</template>

<script>
export default {
    name: "Create",
    props: {
        'id': {required: true, type: Number},
    },
    data() {
        return {
            status: null,
        }
    },
    methods: {
        send() {
            axios.get(`/booking/status?id=${this.id}&status=${this.satus}`)
                .then((response) => {
                    alert('Sikeres Mentés')
                })
                .catch((error) => {
                    if (error.response && error.response.data && error.response.data.message) {
                        alert(error.response.data.message);
                    }
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

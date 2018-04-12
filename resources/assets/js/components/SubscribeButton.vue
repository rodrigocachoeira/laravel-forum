<template>
    <button :class="classes" @click="subcribe" class="btn" >Subscribe</button>
</template>
<script>
    export default {

        props: ['active'],

        data () {
            return {
                subscribed: this.active
            }
        },

        computed: {

            classes() {
                return ['btn', this.subscribed ? 'btn-primary' : 'btn-default']
            }

        },

        methods: {

            subcribe() {
                axios[this.active ? 'delete' : 'post'](location.pathname + '/subscriptions')
                    .then(resp => {
                        this.subscribed = !this.subscribed
                    })
            }

        }

    }
</script>
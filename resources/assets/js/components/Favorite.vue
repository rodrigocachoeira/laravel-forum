<template>
    <button type="submit" :class="classes" @click="toggle">
        <span class="glyphicon glyphicon-heart" ></span>
        <span v-text="count" ></span>
    </button>
</template>

<script>
    export default {

        name: 'favorite',

        props: ['reply'],

        data () {
            return {
                count: this.reply.favoritesCount,
                active: this.reply.isFavorited
            }
        },

        computed: {

            /**
             * @returns {[string,null]}
             */
            classes () {
                return ['btn', this.active ? 'btn-primary' : 'btn-default']
            },

            /**
             * @returns {string}
             */
            endpoint () {
                return '/replies/'+this.reply.id+'/favorites'
            }

        },

        methods: {

            toggle () {
                this.active ? this.destroy() : this.create()
            },

            destroy () {
                axios.delete(this.endpoint).then(resp => {
                    this.active = false
                    this.count--
                })
            },

            create () {
                axios.post(this.endpoint).then(resp => {
                    this.active = true
                    this.count++
                })
            }

        }

    }
</script>
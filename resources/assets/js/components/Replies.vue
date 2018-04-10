<template>
    <div>
        <div v-for="(reply, index) in items" >
            <reply :data="reply" @deleted="remove(index)"></reply>
        </div>
    </div>
</template>

<script>
    import Reply from './Reply.vue'

    export default {

        name: 'replies',

        props: ['data'],

        components: {Reply},

        data () {
            return {
                items: (JSON.parse(this.data)).data
            }
        },

        methods: {

            /**
             * @param index
             */
            remove (index){
                this.items.splice(index, 1)
                this.$emit('removed')
                
                flash('Your reply has been deleted')
            }

        }
    }
</script>
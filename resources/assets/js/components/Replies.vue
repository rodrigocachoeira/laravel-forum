<template>
    <div>
        <div v-for="(reply, index) in items" >
            <reply :data="reply" @deleted="remove(index)"></reply>
        </div>

        <new-reply :action="newReplyAction" @created="add" ></new-reply>
    </div>
</template>

<script>
    import Reply from './Reply.vue'
    import NewReply from './NewReply.vue'

    export default {

        name: 'replies',

        props: ['data'],

        components: {Reply, NewReply},

        data () {
            return {
                items: (JSON.parse(this.data)).data,
                newReplyAction: location.pathname + '/replies'
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
            },

            add (reply) {
                this.items.push(reply)
                this.$emit('added')
            }

        }
    }
</script>
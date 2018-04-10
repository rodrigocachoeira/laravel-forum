<template>
    <div :id="'reply-'+id" class="panel panel-default">
        <div class="panel-heading">
            <div class="level">
                <h5 class="flex" >
                    <a :href="'/profile/'+data.owner.name" v-text="data.owner.name" ></a> said
                    {{ data.created_at }}...
                </h5>
                <div>
                    <div v-if="signedIn" >
                        <favorite :reply="data"></favorite>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel-body">

            <div v-if="editing" >
                <div class="form-group">
                    <textarea v-model="body" class="form-control" name="" id="" cols="30" rows="5"></textarea>
                </div>

                <button @click="update" class="btn btn-xs btn-primary">Update</button>
                <button @click="editing = false" class="btn btn-xs btn-link">Cancel</button>
            </div>
            <div v-else v-text="body" ></div>
        </div>

        <!--@can('update', $reply)-->

        <div class="panel-footer level" v-if="canUpdate">
            <button @click="editing = true" class="btn btn-xs mr-1">Edit</button>
            <button @click="destroy" class="btn btn-danger btn-xs">Delete</button>
        </div>

        <!--@endif-->

    </div>
</template>

<script>
    import Favorite from './Favorite.vue'

    export default {

        props: ['data'],

        components: {Favorite},

        data () {
            return {
                editing: false,
                body: this.data.body,
                id: this.data.id
            }
        },

        computed: {

            signedIn () {
                return window.App.signedIn
            },

            canUpdate () {
                return this.authorize(user => this.data.user_id == user.id)
            }

        },

        methods: {

            update () {
                axios.patch('/replies/' + this.data.id, {body: this.body}).then(resp => {
                    this.editing = false
                    flash('Updated')
                })
            },

            destroy () {
                axios.delete('/replies/' + this.data.id).then(resp => {
                    this.$emit('deleted', this.data.id)
                })
            }

        }

    }
</script>
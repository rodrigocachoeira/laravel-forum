<script>
    export default {

        props: ['attributes'],

        data () {
            return {
                editing: false,
                body: this.attributes.body
            }
        },

        methods: {

            update () {
                axios.patch('/replies/' + this.attributes.id, {body: this.body}).then(resp => {
                    this.editing = false

                    flash('Updated')
                }, err => {
                    this.editing = false
                })
            },

            destroy () {
                axios.delete('/replies/' + this.attributes.id).then(resp => {
                    $(this.$el).fadeOut(300, () => {
                        flash('Your reply has been deleted')
                    })

                }, err => {
                    this.editing = false
                })
            }

        }

    }
</script>
<template>
      <section>
      	<div v-if="signedIn" >
      		<div class="form-group" >
	          <textarea v-model="body" placeholder="Have somethind to say?" rows="5 " name="body" id="body" class="form-control" ></textarea>
	      </div>
	      <input @click="addReply" type="submit" class="btn btn-primary" value="Post">
      	</div>
      	<div v-else >
      		<p class="text-center" >Please <a href="/login">sign in</a> to participate in this discution.</p>
      	</div>     	  
	      
      </section>
</template>

<script>
	export default {

		computed: {

			signedIn () {
				return window.App.signedIn
			}

		},

		props: ['action'],

		data () {
			return {
				body: '',
				endpoint: this.action
			}
		},

		methods: {

			addReply () {
				axios.post(this.endpoint, {body: this.body})
					.then(resp => {
						this.body = '' //reset

						flash('Your reply has been posted.')
						this.$emit('created', resp.data)
					})
			}

		}

	}
</script>
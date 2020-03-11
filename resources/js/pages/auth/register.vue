<template>
	<div class="row items-center">
		<div class="col-lg-8 m-auto">
			<card v-if="mustVerifyEmail" :title="$t('register')">
				<div class="alert alert-success" role="alert">
					{{ $t('verify_email_address') }}
				</div>
			</card>
			<card v-else :title="$t('register')">
				<div class="w-full max-w-xs">
					<form @submit.prevent="register" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" @keydown="form.onKeydown($event)">
						<!-- Name -->
						<div class="form-group row">
							<label class="block text-gray-700 text-sm font-bold mb-2">{{ $t('name') }}</label>
							<div class="col-md-7">
								<input v-model="form.name" :class="{ 'is-invalid': form.errors.has('name') }" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" name="name">
								<has-error :form="form" field="name" />
							</div>
						</div>

						<!-- Email -->
						<div class="form-group row">
							<label class="block text-gray-700 text-sm font-bold mb-2">{{ $t('email') }}</label>
							<div class="col-md-7">
								<input v-model="form.email" :class="{ 'is-invalid': form.errors.has('email') }" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="email" name="email">
								<has-error :form="form" field="email" />
							</div>
						</div>

						<!-- Password -->
						<div class="form-group row">
							<label class="block text-gray-700 text-sm font-bold mb-2">{{ $t('password') }}</label>
							<div class="col-md-7">
								<input v-model="form.password" :class="{ 'is-invalid': form.errors.has('password') }" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="password" name="password">
								<has-error :form="form" field="password" />
							</div>
						</div>

						<!-- Password Confirmation -->
						<div class="form-group row">
							<label class="block text-gray-700 text-sm font-bold mb-2">{{ $t('confirm_password') }}</label>
							<div class="col-md-7">
								<input v-model="form.password_confirmation" :class="{ 'is-invalid': form.errors.has('password_confirmation') }" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="password" name="password_confirmation">
								<has-error :form="form" field="password_confirmation" />
							</div>
						</div>

						<div class="form-group row">
							<div class="col-md-7 offset-md-3 d-flex">
								<!-- Submit Button -->
								<v-button :loading="form.busy">
									{{ $t('register') }}
								</v-button>

								<!-- GitHub Register Button -->
								<login-with-github />
							</div>
						</div>
					</form>
				</div>
			</card>
		</div>
	</div>
</template>

<script>
import Form from 'vform'
import LoginWithGithub from '~/components/LoginWithGithub'

export default {
	middleware: 'guest',
	layout: 'basic',
	components: {
		LoginWithGithub
	},

	metaInfo () {
		return { title: this.$t('register') }
	},

	data: () => ({
		form: new Form({
			name: '',
			email: '',
			password: '',
			password_confirmation: ''
		}),
		mustVerifyEmail: false
	}),

	methods: {
		async register () {
			// Register the user.
			const { data } = await this.form.post('/api/register')

			// Must verify email fist.
			if (data.status) {
				this.mustVerifyEmail = true
			} else {
				// Log in the user.
				const { data: { token } } = await this.form.post('/api/login')

				// Save the token.
				this.$store.dispatch('auth/saveToken', { token })

				// Update the user.
				await this.$store.dispatch('auth/updateUser', { user: data })

				// Redirect home.
				this.$router.push({ name: 'home' })
			}
		}
	}
};
</script>

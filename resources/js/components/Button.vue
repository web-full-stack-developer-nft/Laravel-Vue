<template>
	<button :type="nativeType" :disabled="loading" :class="{
		[`btn-${type}`]: true,
		'btn-block': block,
		'btn-lg': large,
		'btn-loading': loading
	}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
	>
		<slot />
	</button>
</template>

<script>
export default {
	name: 'VButton',

	props: {
		type: {
			type: String,
			default: 'primary'
		},

		nativeType: {
			type: String,
			default: 'submit'
		},

		loading: {
			type: Boolean,
			default: false
		},

		block: {
			type: Boolean,
			default: false
		},

		large: {
			type: Boolean,
			default: false
		}
	}
}
</script>

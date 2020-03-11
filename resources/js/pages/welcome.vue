<template>
<div style="border:1px solid red;">
	<div>
		Welcome to Our Site
	</div>
</div>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
	layout: 'basic',

	metaInfo () {
		return { title: this.$t('home') }
	},

	data: () => ({
		title: window.config.appName
	}),

	computed: mapGetters({
		authenticated: 'auth/check'
	})
};
</script>

<style scoped>
.top-right {
	position: absolute;
	right: 10px;
	top: 18px;
}

.title {
	font-size: 85px;
}
</style>

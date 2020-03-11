<template>
<div>
	<sidebar/>
	<div class="ml-64">
		<navbar/>
		<div>
			<child />
		</div>
	</div>
</div>
</template>

<script>
import Navbar from '~/components/Navbar'
import Sidebar from '~/components/Sidebar'
export default {
	components: {
    	Navbar,
    	Sidebar
  	},
	name: 'BasicLayout'
};
</script>

<style>
	
</style>

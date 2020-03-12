<template>
<div>
	<sidebar/>
	<div class="ml-10 sm:ml-10 md:ml-64 lg:ml-64 xl:ml-64">
		<navbar/>
		<div class="p-5">
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

<template>
<div>
	<div>
		<!-- <sidebar/> -->
	</div>
	<div>
		<navbar/>
		<child />
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

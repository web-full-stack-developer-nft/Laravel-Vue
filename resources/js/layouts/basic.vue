<template>
<div class="basic-layout d-flex align-items-center justify-content-center m-0 bg-white w-full">
	<sidebar/>
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
